<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst(str_replace('-', ' ', $module)) }} - HigaGroup</title>
    @if (file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/modules.css', 'resources/js/modules.js'])
    @else
        <style>{!! file_get_contents(resource_path('css/modules.css')) !!}</style>
    @endif
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <div class="brand">
            <span class="brand-mark" aria-hidden="true"></span>
            <span class="brand-text">HIGA<span style="color:#d8ba4a">GROUP</span></span>
        </div>
        <nav class="menu">
            @foreach($menuItems as $item)
                <a href="{{ $item['href'] }}" class="{{ $navActive === $item['slug'] ? 'active' : '' }}">{{ $item['label'] }}</a>
            @endforeach
        </nav>
        <div class="user-box">
            <div class="avatar" title="{{ auth()->user()->name }}">
                @php
                    $ulabel = trim((string) (auth()->user()->name ?? auth()->user()->email ?? ''));
                    $uinitial = $ulabel !== '' ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($ulabel, 0, 1)) : '?';
                @endphp
                {{ $uinitial }}
            </div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
        <div class="spacer"></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn" type="submit">Log out</button>
        </form>
    </aside>

    <main class="main">
        <div class="topbar-ims">
            <span class="topbar-ims-title">{{ ucfirst(str_replace('-', ' ', $module)) }}</span>
            <div class="topbar-account">
                <a href="{{ route('profile.edit') }}" class="topbar-link">Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="logout-inline">
                    @csrf
                    <button type="submit" class="topbar-link-btn">Log out</button>
                </form>
            </div>
        </div>
        <section class="card">
            <h1 class="title">{{ str_replace('-', ' ', $module) }} records</h1>
            <p class="sub">Create and manage module records from the web interface.</p>
        </section>

        <section class="stats">
            <div class="stat"><b>{{ $stats['farmers'] }}</b><span>Farmers</span></div>
            <div class="stat"><b>{{ $stats['locations'] }}</b><span>Locations</span></div>
            <div class="stat"><b>{{ $stats['collections'] }}</b><span>Collections</span></div>
            <div class="stat"><b>{{ $stats['products'] }}</b><span>Products</span></div>
            <div class="stat"><b>{{ $stats['production_batches'] }}</b><span>Batches</span></div>
            <div class="stat"><b>{{ $stats['sales'] }}</b><span>Sales</span></div>
        </section>

        @php
            $canCreate = !in_array($module, ['raw-inventory', 'finished-inventory']);
            $showForm = $canCreate && ($errors->any() || count(old()) > 0);
        @endphp
        <section class="card">
            @if(session('success'))
                <p class="success">{{ session('success') }}</p>
            @endif
            @if($errors->any())
                <p class="error">{{ $errors->first() }}</p>
            @endif

            <div class="form-toolbar">
                <h3 style="margin:0;">{{ str_replace('-', ' ', $module) }} form</h3>
                @if($canCreate)
                    <button type="button" class="primary" id="show-form-btn">Add Record</button>
                @else
                    <span class="sub">Read-only ledger module</span>
                @endif
            </div>

            <div id="module-form-modal" class="modal-overlay {{ $showForm ? 'is-open' : '' }}">
            <div class="modal-card" role="dialog" aria-modal="true" aria-label="Add record form">
            <div class="modal-header">
                <h3>Add {{ str_replace('-', ' ', $module) }} record</h3>
                <button class="icon-close" id="close-form-btn" type="button" aria-label="Close">×</button>
            </div>
            <form method="POST" action="{{ route('modules.store', ['module' => $module]) }}" class="form-grid">
                @csrf

                @if($module === 'farmers')
                    <div><label>Name</label><input name="name" required></div>
                    <div><label>Phone</label><input name="phone" required></div>
                    <div><label>Country</label><input name="country" value="Rwanda" required></div>
                    <div><label>Province</label><input name="province" required></div>
                    <div><label>District</label><input name="district" required></div>
                    <div><label>Sector</label><input name="sector" required></div>
                    <div><label>Cell</label><input name="cell" required></div>
                    <div><label>Village</label><input name="village" required></div>
                @elseif($module === 'locations')
                    <div><label>Name</label><input name="name" required></div>
                    <div><label>Code</label><input name="code" required></div>
                    <div><label>Country</label><input name="country" value="Rwanda" required></div>
                    <div><label>Province</label><input name="province" required></div>
                    <div><label>District</label><input name="district" required></div>
                    <div><label>Sector</label><input name="sector" required></div>
                    <div><label>Cell</label><input name="cell" required></div>
                    <div><label>Village</label><input name="village" required></div>
                @elseif($module === 'collections')
                    <div><label>Farmer</label><select name="farmer_id" required>@foreach($lookups['farmers'] as $f)<option value="{{ $f->id }}">{{ $f->name }}</option>@endforeach</select></div>
                    <div><label>Location</label><select name="location_id" required>@foreach($lookups['locations'] as $l)<option value="{{ $l->id }}">{{ $l->name }}</option>@endforeach</select></div>
                    <div><label>Date</label><input type="date" name="collection_date" value="{{ $lookups['today'] }}" required></div>
                    <div><label>Collected Qty</label><input type="number" step="0.001" name="quantity_collected" required></div>
                    <div><label>Rejected Qty</label><input type="number" step="0.001" name="quantity_rejected" value="0"></div>
                    <div><label>Price per Kg</label><input type="number" step="0.01" name="price_per_kg" required></div>
                    <div class="full"><label>Rejection Reason</label><input name="rejection_reason"></div>
                @elseif($module === 'products')
                    <div><label>Name</label><input name="name" required></div>
                    <div><label>SKU</label><input name="sku" required></div>
                    <div><label>Active</label><select name="is_active"><option value="1">Yes</option><option value="0">No</option></select></div>
                @elseif($module === 'production')
                    <div><label>Batch Number</label><input name="batch_number" required></div>
                    <div><label>Location</label><select name="location_id" required>@foreach($lookups['locations'] as $l)<option value="{{ $l->id }}">{{ $l->name }}</option>@endforeach</select></div>
                    <div><label>Date</label><input type="date" name="production_date" value="{{ $lookups['today'] }}" required></div>
                    <div><label>Quality %</label><input type="number" step="0.01" name="quality_percentage" value="95" required></div>
                    <div><label>Maize Used (kg)</label><input type="number" step="0.001" name="maize_used" required></div>
                    <div><label>Produced Qty (kg)</label><input type="number" step="0.001" name="quantity_produced" required></div>
                    <div><label>Wastage Qty (kg)</label><input type="number" step="0.001" name="wastage_quantity" value="0" required></div>
                    <div><label>Product</label><select name="product_id" required>@foreach($lookups['products'] as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select></div>
                    <div><label>Package</label><select name="product_package_id" required>@foreach($lookups['packages'] as $pp)<option value="{{ $pp->id }}">{{ $pp->name }}</option>@endforeach</select></div>
                    <div class="full"><label>Wastage Reason</label><input name="wastage_reason"></div>
                @elseif($module === 'sales')
                    <div><label>Invoice Number</label><input name="invoice_number" required></div>
                    <div><label>Customer Name</label><input name="customer_name" required></div>
                    <div><label>Phone</label><input name="customer_phone"></div>
                    <div><label>Location</label><select name="location_id" required>@foreach($lookups['locations'] as $l)<option value="{{ $l->id }}">{{ $l->name }}</option>@endforeach</select></div>
                    <div><label>Sale Date</label><input type="date" name="sale_date" value="{{ $lookups['today'] }}" required></div>
                    <div><label>Payment Method</label><select name="payment_method"><option>cash</option><option>mobile_money</option><option>bank_transfer</option><option>credit</option></select></div>
                    <div><label>Delivery Status</label><select name="delivery_status"><option>pending</option><option>in_transit</option><option>delivered</option></select></div>
                    <div><label>Product</label><select name="product_id" required>@foreach($lookups['products'] as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select></div>
                    <div><label>Package</label><select name="product_package_id" required>@foreach($lookups['packages'] as $pp)<option value="{{ $pp->id }}">{{ $pp->name }}</option>@endforeach</select></div>
                    <div><label>Batch (optional)</label><select name="production_batch_id"><option value="">-</option>@foreach($lookups['batches'] as $b)<option value="{{ $b->id }}">{{ $b->batch_number }}</option>@endforeach</select></div>
                    <div><label>Quantity</label><input type="number" step="0.001" name="quantity" required></div>
                    <div><label>Price</label><input type="number" step="0.01" name="price" required></div>
                    <div class="full"><label>Customer Address</label><input name="customer_address"></div>
                @elseif($module === 'returns')
                    <div><label>Sale</label><select name="sale_id" required>@foreach($lookups['sales'] as $s)<option value="{{ $s->id }}">{{ $s->invoice_number }}</option>@endforeach</select></div>
                    <div><label>Sale Item</label><select name="sale_item_id" required>@foreach($lookups['sale_items'] as $si)<option value="{{ $si->id }}">Item #{{ $si->id }} (Qty {{ $si->quantity }})</option>@endforeach</select></div>
                    <div><label>Quantity</label><input type="number" step="0.001" name="quantity" required></div>
                    <div><label>Date</label><input type="date" name="return_date" value="{{ $lookups['today'] }}" required></div>
                    <div class="full"><label>Reason</label><input name="reason" required></div>
                @elseif($module === 'expenses')
                    <div><label>Batch</label><select name="production_batch_id" required>@foreach($lookups['batches'] as $b)<option value="{{ $b->id }}">{{ $b->batch_number }}</option>@endforeach</select></div>
                    <div><label>Type</label><select name="type"><option>labor</option><option>transport</option><option>packaging</option><option>utilities</option></select></div>
                    <div><label>Amount</label><input type="number" step="0.01" name="amount" required></div>
                    <div class="full"><label>Description</label><input name="description"></div>
                @elseif($module === 'payments')
                    <div><label>Sale</label><select name="sale_id" required>@foreach($lookups['sales'] as $s)<option value="{{ $s->id }}">{{ $s->invoice_number }}</option>@endforeach</select></div>
                    <div><label>Amount</label><input type="number" step="0.01" name="amount" required></div>
                    <div><label>Method</label><select name="payment_method"><option>cash</option><option>mobile_money</option><option>bank_transfer</option><option>credit</option></select></div>
                    <div><label>Date</label><input type="date" name="payment_date" value="{{ $lookups['today'] }}" required></div>
                    <div class="full"><label>Reference</label><input name="reference"></div>
                @else
                    <div class="full">
                        <p class="sub">This module is ledger driven and read-only in web view.</p>
                    </div>
                @endif

                @if($canCreate)
                    <div class="full actions">
                        <button class="primary" type="submit">Save Record</button>
                        <button class="secondary" id="cancel-form-btn" type="button">Cancel</button>
                    </div>
                @endif
            </form>
            </div>
            </div>
        </section>

        <section class="card">
            <h3 style="margin-top:0;">Recent records</h3>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Summary</th>
                    <th>Date</th>
                    @if(in_array($module, ['farmers','locations','products']))
                        <th>Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @forelse($records as $record)
                    <tr>
                        <td>{{ $record->id }}</td>
                        <td>
                            @switch($module)
                                @case('farmers') {{ $record->name }} ({{ $record->phone }}) @break
                                @case('locations') {{ $record->name }} - {{ $record->code }} @break
                                @case('collections') Farmer: {{ optional($record->farmer)->name }} / Accepted: {{ $record->accepted_quantity }} @break
                                @case('raw-inventory') {{ $record->type }} - {{ $record->quantity }} ({{ $record->source }}) @break
                                @case('production') {{ $record->batch_number }} / Produced: {{ $record->quantity_produced }} @break
                                @case('products') {{ $record->name }} ({{ $record->sku }}) @break
                                @case('finished-inventory') {{ $record->type }} - {{ $record->quantity }} @break
                                @case('sales') {{ $record->invoice_number }} / {{ $record->customer_name }} / {{ $record->total_amount }} @break
                                @case('returns') Sale #{{ $record->sale_id }} / Qty {{ $record->quantity }} @break
                                @case('expenses') {{ $record->type }} / {{ $record->amount }} @break
                                @case('payments') Sale #{{ $record->sale_id }} / {{ $record->amount }} @break
                            @endswitch
                        </td>
                        <td>{{ $record->created_at?->format('Y-m-d H:i') ?? '-' }}</td>
                        @if(in_array($module, ['farmers','locations','products']))
                            <td class="actions">
                                <form method="POST" action="{{ route('modules.destroy', ['module' => $module, 'id' => $record->id]) }}" onsubmit="return confirm('Delete this record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="danger">Delete</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr><td colspan="4">No records yet.</td></tr>
                @endforelse
                </tbody>
            </table>
            <div class="pagination">{{ $records->links() }}</div>
        </section>
    </main>
</div>
@if (! (file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json'))))
    <script>{!! file_get_contents(resource_path('js/modules.js')) !!}</script>
@endif
</body>
</html>
