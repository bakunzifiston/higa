<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst(str_replace('-', ' ', $module)) }} - HigaGroup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <span class="brand-text">HIGA<span style="color:#d8ba4a">GROUP</span>
        </div>
        <nav class="menu">
            @foreach($menuItems as $item)
                <a href="{{ $item['href'] }}" class="{{ $navActive === $item['slug'] ? 'active' : '' }}">
                    <i class="fas {{ $item['icon'] ?? 'fa-circle' }}"></i>
                    {{ $item['label'] }}
                </a>
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
        <div class="spacer"></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn" type="submit">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </aside>

    <main class="main">
        <div class="topbar-ims">
            <div class="topbar-ims-title">
                <i class="fas fa-layer-group"></i>
                {{ $module === 'locations' ? 'Warehouses' : ucfirst(str_replace('-', ' ', $module)) }}
            </div>
            <div class="topbar-account">
                <a href="{{ route('profile.edit') }}" class="topbar-link">
                    <i class="fas fa-user-circle"></i> Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="logout-inline">
                    @csrf
                    <button type="submit" class="topbar-link-btn">
                        <i class="fas fa-power-off"></i> Log out
                    </button>
                </form>
            </div>

        <section class="card">
            <h1 class="title">
                <i class="fas fa-database"></i>
                {{ $module === 'locations' ? 'Warehouse' : str_replace('-', ' ', $module) }} records
            </h1>
            <p class="sub">Create and manage module records from the web interface.</p>
        </section>

        <section class="stats">
            <div class="stat"><b>{{ $stats['farmers'] }}</b><span><i class="fas fa-tractor" style="margin-right:4px;color:var(--brand-green-dark)"></i>Farmers</span></div>
            <div class="stat"><b>{{ $stats['locations'] }}</b><span><i class="fas fa-map-marker-alt" style="margin-right:4px;color:var(--brand-green-dark)"></i>Locations</span></div>
            <div class="stat"><b>{{ $stats['collections'] }}</b><span><i class="fas fa-seedling" style="margin-right:4px;color:var(--brand-green-dark)"></i>Collections</span></div>
            <div class="stat"><b>{{ $stats['products'] }}</b><span><i class="fas fa-boxes" style="margin-right:4px;color:var(--brand-green-dark)"></i>Products</span></div>
            <div class="stat"><b>{{ $stats['production_batches'] }}</b><span><i class="fas fa-industry" style="margin-right:4px;color:var(--brand-green-dark)"></i>Batches</span></div>
            <div class="stat"><b>{{ $stats['sales'] }}</b><span><i class="fas fa-chart-line" style="margin-right:4px;color:var(--brand-green-dark)"></i>Sales</span></div>
        </section>

        @php
            $canCreate = !in_array($module, ['raw-inventory', 'finished-inventory']);
            $showForm = $canCreate && ($editRecord || $errors->any() || count(old()) > 0);
        @endphp
        <section class="card">
            @if(session('success'))
                <p class="success"><i class="fas fa-check-circle"></i> {{ session('success') }}</p>
            @endif
            @if($errors->any())
                <p class="error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</p>
            @endif

            <div class="form-toolbar">
{{ $editRecord ? 'Edit #' . $editRecord->id : ($module === 'locations' ? 'Warehouse' : str_replace('-', ' ', $module)) . ' form' }}</h3>
                @if($canCreate)
                    <button type="button" class="primary" id="show-form-btn"><i class="fas fa-plus"></i> Add Record</button>
                @else
                    <span class="sub"><i class="fas fa-lock"></i> Read-only ledger module</span>
                @endif
            </div>

            <div id="module-form-modal" class="modal-overlay {{ $showForm ? 'is-open' : '' }}">
            <div class="modal-card" role="dialog" aria-modal="true" aria-label="Add record form">
            <div class="modal-header">
<h3><i class="fas {{ $editRecord ? 'fa-pen' : 'fa-plus' }}" style="margin-right:6px;color:var(--brand-green-dark)"></i>{{ $editRecord ? 'Edit' : 'Add' }} {{ $module === 'locations' ? 'Warehouse' : str_replace('-', ' ', $module) }} record</h3>
                <button class="icon-close" id="close-form-btn" type="button" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form method="POST" action="{{ $editRecord ? route('modules.update', ['module' => $module, 'id' => $editRecord->id]) : route('modules.store', ['module' => $module]) }}" class="form-grid">
                @csrf
                @if($editRecord) @method('PUT') @endif

                @if($module === 'farmers')
                    <div><label><i class="fas fa-user" style="margin-right:4px"></i> Name</label><input name="name" value="{{ old('name', $editRecord?->name ?? '') }}" required></div>
                    <div><label><i class="fas fa-phone" style="margin-right:4px"></i> Phone</label><input name="phone" value="{{ old('phone', $editRecord?->phone ?? '') }}" required></div>
                    <div><label><i class="fas fa-globe" style="margin-right:4px"></i> Country</label><input name="country" value="{{ old('country', $editRecord?->country ?? 'Rwanda') }}" required></div>
                    <div><label><i class="fas fa-map" style="margin-right:4px"></i> Province</label><input name="province" value="{{ old('province', $editRecord?->province ?? '') }}" required></div>
                    <div><label><i class="fas fa-city" style="margin-right:4px"></i> District</label><input name="district" value="{{ old('district', $editRecord?->district ?? '') }}" required></div>
                    <div><label><i class="fas fa-building" style="margin-right:4px"></i> Sector</label><input name="sector" value="{{ old('sector', $editRecord?->sector ?? '') }}" required></div>
                    <div><label><i class="fas fa-home" style="margin-right:4px"></i> Cell</label><input name="cell" value="{{ old('cell', $editRecord?->cell ?? '') }}" required></div>
                    <div><label><i class="fas fa-tree" style="margin-right:4px"></i> Village</label><input name="village" value="{{ old('village', $editRecord?->village ?? '') }}" required></div>
                @elseif($module === 'locations')
                    <div><label><i class="fas fa-tag" style="margin-right:4px"></i> Name</label><input name="name" value="{{ old('name', $editRecord?->name ?? '') }}" required></div>
                    <div><label><i class="fas fa-barcode" style="margin-right:4px"></i> Code</label><input name="code" value="{{ old('code', $editRecord?->code ?? '') }}" required></div>
                    <div><label><i class="fas fa-globe" style="margin-right:4px"></i> Country</label><input name="country" value="{{ old('country', $editRecord?->country ?? 'Rwanda') }}" required></div>
                    <div><label><i class="fas fa-map" style="margin-right:4px"></i> Province</label><input name="province" value="{{ old('province', $editRecord?->province ?? '') }}" required></div>
                    <div><label><i class="fas fa-city" style="margin-right:4px"></i> District</label><input name="district" value="{{ old('district', $editRecord?->district ?? '') }}" required></div>
                    <div><label><i class="fas fa-building" style="margin-right:4px"></i> Sector</label><input name="sector" value="{{ old('sector', $editRecord?->sector ?? '') }}" required></div>
                    <div><label><i class="fas fa-home" style="margin-right:4px"></i> Cell</label><input name="cell" value="{{ old('cell', $editRecord?->cell ?? '') }}" required></div>
                    <div><label><i class="fas fa-tree" style="margin-right:4px"></i> Village</label><input name="village" value="{{ old('village', $editRecord?->village ?? '') }}" required></div>
                @elseif($module === 'collections')
<div><label><i class="fas fa-tractor" style="margin-right:4px"></i> Farmer</label><select name="farmer_id" required>@foreach($lookups['farmers'] as $f)<option value="{{ $f->id }}" {{ old('farmer_id', $editRecord?->farmer_id ?? '') == $f->id ? 'selected' : '' }}>{{ $f->name }}</option>@endforeach</select></div>
                    <div><label><i class="fas fa-seedling" style="margin-right:4px"></i> Item Name</label><input name="product_name" value="{{ old('product_name', $editRecord?->product_name ?? '') }}"></div>
                    <div><label><i class="fas fa-map-marker-alt" style="margin-right:4px"></i> Location</label><select name="location_id" required>@foreach($lookups['locations'] as $l)<option value="{{ $l->id }}" {{ old('location_id', $editRecord?->location_id ?? '') == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>@endforeach</select></div>
                    <div><label><i class="fas fa-calendar" style="margin-right:4px"></i> Date</label><input type="date" name="collection_date" value="{{ old('collection_date', $editRecord?->collection_date?->format('Y-m-d') ?? $lookups['today']) }}" required></div>
                    <div><label><i class="fas fa-weight-hanging" style="margin-right:4px"></i> Collected Qty</label><input type="number" step="0.001" name="quantity_collected" value="{{ old('quantity_collected', $editRecord?->quantity_collected ?? '') }}" required></div>
                    <div><label><i class="fas fa-times-circle" style="margin-right:4px"></i> Rejected Qty</label><input type="number" step="0.001" name="quantity_rejected" value="{{ old('quantity_rejected', $editRecord?->quantity_rejected ?? '0') }}"></div>
                    <div><label><i class="fas fa-money-bill-wave" style="margin-right:4px"></i> Price per Kg</label><input type="number" step="0.01" name="price_per_kg" value="{{ old('price_per_kg', $editRecord?->price_per_kg ?? '') }}" required></div>
                    <div class="full"><label><i class="fas fa-comment" style="margin-right:4px"></i> Rejection Reason</label><input name="rejection_reason" value="{{ old('rejection_reason', $editRecord?->rejection_reason ?? '') }}"></div>
                @elseif($module === 'products')
                    <div><label><i class="fas fa-box" style="margin-right:4px"></i> Name</label><input name="name" value="{{ old('name', $editRecord?->name ?? '') }}" required></div>
                    <div><label><i class="fas fa-barcode" style="margin-right:4px"></i> SKU</label><input name="sku" value="{{ old('sku', $editRecord?->sku ?? '') }}" required></div>
                    <div><label><i class="fas fa-toggle-on" style="margin-right:4px"></i> Active</label><select name="is_active"><option value="1" {{ old('is_active', $editRecord?->is_active ?? 1) == '1' ? 'selected' : '' }}>Yes</option><option value="0" {{ old('is_active', $editRecord?->is_active ?? 1) == '0' ? 'selected' : '' }}>No</option></select></div>
                @elseif($module === 'production')
                    <div><label><i class="fas fa-hashtag" style="margin-right:4px"></i> Batch Number</label><input name="batch_number" required></div>
                    <div><label><i class="fas fa-map-marker-alt" style="margin-right:4px"></i> Location</label><select name="location_id" required>@foreach($lookups['locations'] as $l)<option value="{{ $l->id }}">{{ $l->name }}</option>@endforeach</select></div>
                    <div><label><i class="fas fa-calendar" style="margin-right:4px"></i> Date</label><input type="date" name="production_date" value="{{ $lookups['today'] }}" required></div>
                    <div><label><i class="fas fa-percentage" style="margin-right:4px"></i> Quality %</label><input type="number" step="0.01" name="quality_percentage" value="95" required></div>
                    <div><label><i class="fas fa-weight-hanging" style="margin-right:4px"></i> Maize Used (kg)</label><input type="number" step="0.001" name="maize_used" required></div>
                    <div><label><i class="fas fa-box-open" style="margin-right:4px"></i> Produced Qty (kg)</label><input type="number" step="0.001" name="quantity_produced" required></div>
                    <div><label><i class="fas fa-trash" style="margin-right:4px"></i> Wastage Qty (kg)</label><input type="number" step="0.001" name="wastage_quantity" value="0" required></div>
                    <div><label><i class="fas fa-box" style="margin-right:4px"></i> Product</label><select name="product_id" required>@foreach($lookups['products'] as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select></div>
                    <div><label><i class="fas fa-cube" style="margin-right:4px"></i> Package</label><select name="product_package_id" required>@foreach($lookups['packages'] as $pp)<option value="{{ $pp->id }}">{{ $pp->name }}</option>@endforeach</select></div>
                    <div class="full"><label><i class="fas fa-comment" style="margin-right:4px"></i> Wastage Reason</label><input name="wastage_reason"></div>
                @elseif($module === 'sales')
                    <div><label><i class="fas fa-receipt" style="margin-right:4px"></i> Invoice Number</label><input name="invoice_number" required></div>
                    <div><label><i class="fas fa-user" style="margin-right:4px"></i> Customer Name</label><input name="customer_name" required></div>
                    <div><label><i class="fas fa-phone" style="margin-right:4px"></i> Phone</label><input name="customer_phone"></div>
                    <div><label><i class="fas fa-map-marker-alt" style="margin-right:4px"></i> Location</label><select name="location_id" required>@foreach($lookups['locations'] as $l)<option value="{{ $l->id }}">{{ $l->name }}</option>@endforeach</select></div>
                    <div><label><i class="fas fa-calendar" style="margin-right:4px"></i> Sale Date</label><input type="date" name="sale_date" value="{{ $lookups['today'] }}" required></div>
                    <div><label><i class="fas fa-credit-card" style="margin-right:4px"></i> Payment Method</label><select name="payment_method"><option>cash</option><option>mobile_money</option><option>bank_transfer</option><option>credit</option></select></div>
                    <div><label><i class="fas fa-shipping-fast" style="margin-right:4px"></i> Delivery Status</label><select name="delivery_status"><option>pending</option><option>in_transit</option><option>delivered</option></select></div>
                    <div><label><i class="fas fa-box" style="margin-right:4px"></i> Product</label><select name="product_id" required>@foreach($lookups['products'] as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select></div>
                    <div><label><i class="fas fa-cube" style="margin-right:4px"></i> Package</label><select name="product_package_id" required>@foreach($lookups['packages'] as $pp)<option value="{{ $pp->id }}">{{ $pp->name }}</option>@endforeach</select></div>
                    <div><label><i class="fas fa-industry" style="margin-right:4px"></i> Batch (optional)</label><select name="production_batch_id"><option value="">-</option>@foreach($lookups['batches'] as $b)<option value="{{ $b->id }}">{{ $b->batch_number }}</option>@endforeach</select></div>
                    <div><label><i class="fas fa-weight-hanging" style="margin-right:4px"></i> Quantity</label><input type="number" step="0.001" name="quantity" required></div>
                    <div><label><i class="fas fa-money-bill-wave" style="margin-right:4px"></i> Price</label><input type="number" step="0.01" name="price" required></div>
                    <div class="full"><label><i class="fas fa-home" style="margin-right:4px"></i> Customer Address</label><input name="customer_address"></div>
                @elseif($module === 'returns')
                    <div><label><i class="fas fa-receipt" style="margin-right:4px"></i> Sale</label><select name="sale_id" required>@foreach($lookups['sales'] as $s)<option value="{{ $s->id }}">{{ $s->invoice_number }}</option>@endforeach</select></div>
                    <div><label><i class="fas fa-shopping-cart" style="margin-right:4px"></i> Sale Item</label><select name="sale_item_id" required>@foreach($lookups['sale_items'] as $si)<option value="{{ $si->id }}">Item #{{ $si->id }} (Qty {{ $si->quantity }})</option>@endforeach</select></div>
                    <div><label><i class="fas fa-weight-hanging" style="margin-right:4px"></i> Quantity</label><input type="number" step="0.001" name="quantity" required></div>
                    <div><label><i class="fas fa-calendar" style="margin-right:4px"></i> Date</label><input type="date" name="return_date" value="{{ $lookups['today'] }}" required></div>
                    <div class="full"><label><i class="fas fa-comment" style="margin-right:4px"></i> Reason</label><input name="reason" required></div>
                @elseif($module === 'expenses')
                    <div><label><i class="fas fa-industry" style="margin-right:4px"></i> Batch</label><select name="production_batch_id" required>@foreach($lookups['batches'] as $b)<option value="{{ $b->id }}">{{ $b->batch_number }}</option>@endforeach</select></div>
                    <div><label><i class="fas fa-list" style="margin-right:4px"></i> Type</label><select name="type"><option>labor</option><option>transport</option><option>packaging</option><option>utilities</option></select></div>
                    <div><label><i class="fas fa-money-bill-wave" style="margin-right:4px"></i> Amount</label><input type="number" step="0.01" name="amount" required></div>
                    <div class="full"><label><i class="fas fa-align-left" style="margin-right:4px"></i> Description</label><input name="description"></div>
                @elseif($module === 'payments')
                    <div><label><i class="fas fa-receipt" style="margin-right:4px"></i> Sale</label><select name="sale_id" required>@foreach($lookups['sales'] as $s)<option value="{{ $s->id }}">{{ $s->invoice_number }}</option>@endforeach</select></div>
                    <div><label><i class="fas fa-money-bill-wave" style="margin-right:4px"></i> Amount</label><input type="number" step="0.01" name="amount" required></div>
                    <div><label><i class="fas fa-credit-card" style="margin-right:4px"></i> Method</label><select name="payment_method"><option>cash</option><option>mobile_money</option><option>bank_transfer</option><option>credit</option></select></div>
                    <div><label><i class="fas fa-calendar" style="margin-right:4px"></i> Date</label><input type="date" name="payment_date" value="{{ $lookups['today'] }}" required></div>
                    <div class="full"><label><i class="fas fa-barcode" style="margin-right:4px"></i> Reference</label><input name="reference"></div>
                @else
                    <div class="full">
                        <p class="sub"><i class="fas fa-lock"></i> This module is ledger driven and read-only in web view.</p>
                    </div>
                @endif

                @if($canCreate)
                    <div class="full actions">
                        <button class="primary" type="submit"><i class="fas {{ $editRecord ? 'fa-save' : 'fa-check' }}"></i> {{ $editRecord ? 'Update Record' : 'Save Record' }}</button>
                        @if($editRecord)<a href="{{ route('modules.show', ['module' => $module]) }}" class="secondary" style="text-decoration:none;"><i class="fas fa-times"></i> Cancel</a>@else<button class="secondary" id="cancel-form-btn" type="button"><i class="fas fa-times"></i> Cancel</button>@endif
                    </div>
                @endif
            </form>
            </div>
        </section>

        <section class="card">
            <h3 style="margin-top:0;"><i class="fas fa-list-alt" style="margin-right:8px;color:var(--brand-green-dark)"></i>Recent records</h3>
            <table>
                <thead>
@if($module === 'collections')
                <tr>
                    <th>Farmer</th>
                    <th>Item Name</th>
                    <th>Location</th>
                    <th>Collection Date</th>
                    <th>Collected (kg)</th>
                    <th>Accepted (kg)</th>
                    <th>Rejected (kg)</th>
                    <th>Price / kg</th>
                    <th>Actions</th>
                </tr>

                @elseif($module === 'farmers')
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Country</th>
                    <th>Province</th>
                    <th>District</th>
                    <th>Sector</th>
                    <th>Cell</th>
                    <th>Village</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>

@elseif($module === 'locations')
                <tr>
                    <th>Warehouse</th>
                    <th>Code</th>
                    <th>Country</th>
                    <th>Province</th>
                    <th>District</th>
                    <th>Sector</th>
                    <th>Cell</th>
                    <th>Village</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>

                @elseif($module === 'products')
                <tr>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>

                @elseif($module === 'finished-inventory')
                <tr>
                    <th>Product</th>
                    <th>Quality</th>
                    <th>Stock</th>
                    <th>Location</th>
                    <th>Production Date</th>
                    <th>Expiry Date</th>
                    <th>Unit Cost</th>
                    <th>Suggested Price</th>
                    <th>Total Value</th>
                </tr>
                @elseif($module === 'sales')
                <tr>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Product</th>
                    <th>Package</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Address</th>
                    <th>Returns</th>
                </tr>
                @else
                <tr>
                    <th>Info</th>
                    <th>Date</th>
                </tr>
                @endif

                </thead>
                <tbody>
                @forelse($records as $record)
@if($module === 'collections')
                    <tr>
                        <td><i class="fas fa-tractor" style="margin-right:4px;color:var(--brand-green-dark)"></i> {{ optional($record->farmer)->name ?? '-' }}</td>
                        <td>{{ $record->product_name ?? 'Maize' }}</td>
                        <td><i class="fas fa-map-marker-alt" style="margin-right:4px;color:var(--muted)"></i> {{ optional($record->location)->name ?? '-' }}</td>
                        <td>{{ $record->collection_date?->format('Y-m-d') ?? '-' }}</td>
                        <td>{{ number_format($record->quantity_collected, 3) }}</td>
                        <td>{{ number_format($record->accepted_quantity, 3) }}</td>
                        <td>{{ number_format($record->quantity_rejected, 3) }}</td>
                        <td>{{ number_format($record->price_per_kg, 2) }}</td>
                        <td class="actions">
                            <a href="{{ route('modules.edit', ['module' => $module, 'id' => $record->id]) }}" class="secondary" style="text-decoration:none;"><i class="fas fa-pen"></i> Edit</a>
                            <form method="POST" action="{{ route('modules.destroy', ['module' => $module, 'id' => $record->id]) }}" onsubmit="return confirm('Delete this record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>

                    @elseif($module === 'farmers')
                    <tr>
                        <td><i class="fas fa-user" style="margin-right:4px;color:var(--brand-green-dark)"></i> {{ $record->name }}</td>
                        <td>{{ $record->phone }}</td>
                        <td>{{ $record->country }}</td>
                        <td>{{ $record->province }}</td>
                        <td>{{ $record->district }}</td>
                        <td>{{ $record->sector }}</td>
                        <td>{{ $record->cell }}</td>
                        <td>{{ $record->village }}</td>
                        <td>{{ $record->created_at?->format('Y-m-d') ?? '-' }}</td>
                        <td class="actions">
                            <a href="{{ route('modules.edit', ['module' => $module, 'id' => $record->id]) }}" class="secondary" style="text-decoration:none;"><i class="fas fa-pen"></i> Edit</a>
                            <form method="POST" action="{{ route('modules.destroy', ['module' => $module, 'id' => $record->id]) }}" onsubmit="return confirm('Delete this record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>


                    @elseif($module === 'locations')
                    <tr>
                        <td><i class="fas fa-warehouse" style="margin-right:4px;color:var(--brand-green-dark)"></i> {{ $record->name }}</td>
                        <td><span class="badge badge-muted">{{ $record->code }}</span></td>
                        <td>{{ $record->country }}</td>
                        <td>{{ $record->province }}</td>
                        <td>{{ $record->district }}</td>
                        <td>{{ $record->sector }}</td>
                        <td>{{ $record->cell }}</td>
                        <td>{{ $record->village }}</td>
                        <td>{{ $record->created_at?->format('Y-m-d') ?? '-' }}</td>
                        <td class="actions">
                            <a href="{{ route('modules.edit', ['module' => $module, 'id' => $record->id]) }}" class="secondary" style="text-decoration:none;"><i class="fas fa-pen"></i> Edit</a>
                            <form method="POST" action="{{ route('modules.destroy', ['module' => $module, 'id' => $record->id]) }}" onsubmit="return confirm('Delete this record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>

                    @elseif($module === 'products')
                    <tr>
                        <td><i class="fas fa-box" style="margin-right:4px;color:var(--brand-green-dark)"></i> {{ $record->name }}</td>
                        <td>{{ $record->sku }}</td>
                        <td><span class="badge {{ $record->is_active ? 'badge-success' : 'badge-muted' }}"><i class="fas {{ $record->is_active ? 'fa-check' : 'fa-times' }}"></i> {{ $record->is_active ? 'Active' : 'Inactive' }}</span></td>
                        <td>{{ $record->created_at?->format('Y-m-d') ?? '-' }}</td>
                        <td class="actions">
                            <a href="{{ route('modules.edit', ['module' => $module, 'id' => $record->id]) }}" class="secondary" style="text-decoration:none;"><i class="fas fa-pen"></i> Edit</a>
                            <form method="POST" action="{{ route('modules.destroy', ['module' => $module, 'id' => $record->id]) }}" onsubmit="return confirm('Delete this record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @elseif($module === 'finished-inventory')
                    <tr>
                        <td><i class="fas fa-box" style="margin-right:4px;color:var(--brand-green-dark)"></i> {{ optional($record->product)->name ?? '-' }}</td>
                        <td>{{ $record->quality ?? '-' }}</td>
                        <td><strong>{{ number_format($record->stock ?? 0, 3) }}</strong> kg</td>
                        <td><i class="fas fa-warehouse" style="margin-right:4px;color:var(--muted)"></i> {{ optional($record->location)->name ?? '-' }}</td>
                        <td>{{ $record->production_date instanceof \Carbon\Carbon ? $record->production_date->format('Y-m-d') : ($record->production_date ?? '-') }}</td>
                        <td>{{ $record->expiry_date instanceof \Carbon\Carbon ? $record->expiry_date->format('Y-m-d') : ($record->expiry_date ?? '-') }}</td>
                        <td>{{ number_format($record->unit_cost ?? 0, 2) }} RWF</td>
                        <td>{{ number_format($record->suggested_price ?? 0, 2) }} RWF</td>
                        <td><strong>{{ number_format($record->total_value ?? 0, 2) }}</strong> RWF</td>
                    </tr>

                    @elseif($module === 'sales')
                    <tr>
                        <td><strong>{{ $record->invoice_number }}</strong></td>
                        <td>{{ $record->customer_name }}</td>
                        <td>{{ $record->customer_phone }}</td>
                        <td>{{ optional($record->location)->name ?? '-' }}</td>
                        <td>{{ $record->sale_date?->format('d/m/Y') }}</td>
                        <td><span class="badge {{ $record->payment_method === 'cash' ? 'badge-success' : ($record->payment_method === 'mobile_money' ? 'badge-primary' : 'badge-secondary') }}">{{ ucfirst(str_replace('_', ' ', $record->payment_method)) }}</span></td>
                        <td><span class="badge {{ $record->delivery_status === 'delivered' ? 'badge-success' : ($record->delivery_status === 'in_transit' ? 'badge-primary' : 'badge-warning') }}">{{ ucfirst(str_replace('_', ' ', $record->delivery_status)) }}</span></td>
                        <td>{{ optional($record->items->first()->product)->name ?? '-' }}</td>
                        <td>{{ optional($record->items->first()->product_package)->name ?? '-' }}</td>
                        <td>{{ number_format($record->items->first()->quantity ?? 0, 3) }}</td>
                        <td>{{ number_format($record->items->first()->price ?? 0, 2) }}</td>
                        <td>{{ Str::limit($record->customer_address ?? '', 30) }}</td>
                        <td>
                            @php $returnCount = $record->returns->count(); @endphp
                            @if($returnCount > 0)
                                <span class="badge badge-danger">{{ $returnCount }}</span>
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td>
                            @switch($module)
                                @case('raw-inventory') <i class="fas fa-exchange-alt" style="margin-right:4px;color:var(--brand-green-dark)"></i> {{ $record->type }} — {{ number_format($record->quantity, 3) }} kg ({{ $record->source }}) @break
                                @case('production') <i class="fas fa-industry" style="margin-right:4px;color:var(--brand-green-dark)"></i> {{ $record->batch_number }} — Produced {{ number_format($record->quantity_produced, 3) }} kg @break
                                @case('sales') <i class="fas fa-receipt" style="margin-right:4px;color:var(--brand-green-dark)"></i> {{ $record->invoice_number }} — {{ $record->customer_name }} — {{ number_format($record->total_amount, 2) }} RWF @break
                                @case('returns') <i class="fas fa-undo" style="margin-right:4px;color:var(--brand-orange)"></i> {{ optional($record->sale)->invoice_number ?? 'Sale #' . $record->sale_id }} — Qty {{ number_format($record->quantity, 3) }} @break
                                @case('expenses') <i class="fas fa-file-invoice-dollar" style="margin-right:4px;color:var(--brand-orange)"></i> {{ ucfirst($record->type) }} — {{ number_format($record->amount, 2) }} RWF @break
                                @case('payments') <i class="fas fa-money-check-alt" style="margin-right:4px;color:var(--brand-green-dark)"></i> {{ optional($record->sale)->invoice_number ?? 'Sale #' . $record->sale_id }} — {{ number_format($record->amount, 2) }} RWF @break
                            @endswitch
                        </td>
                        <td>{{ $record->created_at?->format('Y-m-d H:i') ?? '-' }}</td>
                    </tr>
                    @endif

                @empty
                    @if($module === 'finished-inventory')
                        <tr><td colspan="9" style="text-align:center;color:var(--muted);padding:24px;"><i class="fas fa-box-open" style="font-size:2rem;margin-bottom:8px;display:block;color:var(--line)"></i>No stock records yet.</td></tr>
                    @elseif(in_array($module, ['farmers','locations','collections','products']))
                        <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:24px;"><i class="fas fa-folder-open" style="font-size:2rem;margin-bottom:8px;display:block;color:var(--line)"></i>No records yet.</td></tr>
                    @else
                        <tr><td colspan="2" style="text-align:center;color:var(--muted);padding:24px;"><i class="fas fa-folder-open" style="font-size:2rem;margin-bottom:8px;display:block;color:var(--line)"></i>No records yet.</td></tr>
                    @endif
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
