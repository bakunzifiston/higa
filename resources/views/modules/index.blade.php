<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst(str_replace('-', ' ', $module)) }} - HigaGroup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@if (file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json')))
        <style>{!! file_exists(resource_path('css/modules.css')) ? file_get_contents(resource_path('css/modules.css')) : '' !!}</style>
    @else
        <style>{!! file_get_contents(resource_path('css/modules.css')) !!}</style>
    @endif
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <div class="brand">
            <img src="{{ asset('higalog.jpg') }}" alt="HigaGroup Logo" style="max-height:32px;width:auto;border-radius:6px;">
        </div>
        <nav class="menu">
            @foreach($menuItems as $item)
                <a href="{{ $item['endpoint'] ?? $item['href'] ?? '#' }}" class="{{ $navActive === $item['slug'] ? 'active' : '' }}">
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
        </div>

        @php
            $canCreate = !in_array($module, ['raw-inventory', 'finished-inventory']);
            $showForm = $canCreate && ($editRecord || $errors->any() || count(old()) > 0);
            $normalizedModule = strtolower(trim((string) $module));
        @endphp


        @if($canCreate && !$editRecord)
            <div style="margin:0 0 12px 0;">
                    <button type="button" id="show-form-btn" class="primary">
                    <i class="fas fa-plus"></i> Add {{ $normalizedModule === 'locations' ? 'Warehouse' : str_replace('-', ' ', $module) }}
                </button>

            </div>
        @endif

        <section class="card" id="farmers-form" style="margin-bottom:16px;">
            @if(session('success'))
                <p class="success"><i class="fas fa-check-circle"></i> {{ session('success') }}</p>
            @endif
            @if($errors->any())
                <p class="error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</p>
            @endif

            <div class="form-toolbar">
                {{ $editRecord ? 'Edit #' . $editRecord->id : ($module === 'locations' ? 'Warehouse' : str_replace('-', ' ', $module)) . ' form' }}
            </div>


            <div id="module-form-modal" class="modal-overlay {{ $showForm ? 'is-open' : '' }}">
                <div class="modal-card" role="dialog" aria-modal="true" aria-label="Add record form">
                    <div class="modal-header">
                        <h3>
                            <i class="fas {{ $editRecord ? 'fa-pen' : 'fa-plus' }}" style="margin-right:6px;color:var(--brand-green-dark)"></i>
                            {{ $editRecord ? 'Edit' : 'Add' }} {{ $module === 'locations' ? 'Warehouse' : str_replace('-', ' ', $module) }} record
                        </h3>
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

                        @elseif($module === 'employees')
                            <div><label><i class="fas fa-id-card" style="margin-right:4px"></i> Employee Code</label><input name="employee_code" value="{{ old('employee_code', $editRecord?->employee_code ?? '') }}" required></div>
                            <div><label><i class="fas fa-user" style="margin-right:4px"></i> Full Name</label><input name="full_name" value="{{ old('full_name', $editRecord?->full_name ?? '') }}" required></div>
                            <div><label><i class="fas fa-venus-mars" style="margin-right:4px"></i> Gender</label><input name="gender" value="{{ old('gender', $editRecord?->gender ?? '') }}"></div>
                            <div><label><i class="fas fa-birthday-cake" style="margin-right:4px"></i> Date of Birth</label><input type="date" name="date_of_birth" value="{{ old('date_of_birth', $editRecord?->date_of_birth?->format('Y-m-d') ?? '') }}"></div>
                            <div><label><i class="fas fa-flag" style="margin-right:4px"></i> Nationality</label><input name="nationality" value="{{ old('nationality', $editRecord?->nationality ?? '') }}"></div>
                            <div><label><i class="fas fa-wheelchair" style="margin-right:4px"></i> Disability Status</label><input name="disability_status" value="{{ old('disability_status', $editRecord?->disability_status ?? '') }}"></div>
                            <div><label><i class="fas fa-phone" style="margin-right:4px"></i> Phone Number</label><input name="phone_number" value="{{ old('phone_number', $editRecord?->phone_number ?? '') }}"></div>
                            <div><label><i class="fas fa-envelope" style="margin-right:4px"></i> Email</label><input name="email" type="email" value="{{ old('email', $editRecord?->email ?? '') }}"></div>
                            <div class="full"><label><i class="fas fa-map" style="margin-right:4px"></i> Address</label><input name="address" value="{{ old('address', $editRecord?->address ?? '') }}"></div>
                            <div><label><i class="fas fa-building" style="margin-right:4px"></i> Department</label><input name="department" value="{{ old('department', $editRecord?->department ?? '') }}"></div>
                            <div><label><i class="fas fa-briefcase" style="margin-right:4px"></i> Position</label><input name="position" value="{{ old('position', $editRecord?->position ?? '') }}"></div>
                            <div><label><i class="fas fa-user-tie" style="margin-right:4px"></i> Employment Type</label><input name="employment_type" value="{{ old('employment_type', $editRecord?->employment_type ?? '') }}"></div>
                            <div><label><i class="fas fa-calendar" style="margin-right:4px"></i> Hire Date</label><input type="date" name="hire_date" value="{{ old('hire_date', $editRecord?->hire_date?->format('Y-m-d') ?? '') }}"></div>
                            <div><label><i class="fas fa-map-marker-alt" style="margin-right:4px"></i> Work Location</label><input name="work_location" value="{{ old('work_location', $editRecord?->work_location ?? '') }}"></div>
                            <div><label><i class="fas fa-circle" style="margin-right:4px"></i> Status</label><input name="status" value="{{ old('status', $editRecord?->status ?? '') }}"></div>

                        @else
                            {{-- Keep existing modules' forms unchanged below. --}}
                            <div class="full">
                                <p class="sub"><i class="fas fa-lock"></i> This module is ledger driven and read-only in web view.</p>
                            </div>
                        @endif

                        @if($canCreate)
                            <div class="full actions">
                                <button class="primary" type="submit"><i class="fas {{ $editRecord ? 'fa-save' : 'fa-check' }}"></i> {{ $editRecord ? 'Update Record' : 'Save Record' }}</button>
                                @if($editRecord)
                                    <a href="{{ route('modules.show', ['module' => $module]) }}" class="secondary" style="text-decoration:none;"><i class="fas fa-times"></i> Cancel</a>
                                @else
                                    <button class="secondary" id="cancel-form-btn" type="button"><i class="fas fa-times"></i> Cancel</button>
                                @endif
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </section>

        <section class="card">
            <h3 style="margin-top:0;"><i class="fas fa-list-alt" style="margin-right:8px;color:var(--brand-green-dark)"></i>Recent records</h3>
            <div class="table-responsive">
                <table>
                    <thead>
                        @if($normalizedModule === 'employees')
                            <tr>
                                <th>Employee</th>

                                <th>Department</th>
                                <th>Position</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Hire Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        @elseif($module === 'collections')
                            <tr>
                                <th>Farmer</th><th>Item Name</th><th>Location</th><th>Collection Date</th>
                                <th>Collected (kg)</th><th>Accepted (kg)</th><th>Rejected (kg)</th><th>Price / kg</th><th>Actions</th>
                            </tr>
                        @elseif($module === 'farmers')
                            <tr>
                                <th>Name</th><th>Phone</th><th>Country</th><th>Province</th><th>District</th><th>Sector</th><th>Cell</th><th>Village</th><th>Created</th><th>Actions</th>
                            </tr>
                        @elseif($module === 'locations')
                            <tr>
                                <th>Warehouse</th><th>Code</th><th>Country</th><th>Province</th><th>District</th><th>Sector</th><th>Cell</th><th>Village</th><th>Created</th><th>Actions</th>
                            </tr>
                        @elseif($module === 'products')
                            <tr>
                                <th>Name</th><th>SKU</th><th>Status</th><th>Created</th><th>Actions</th>
                            </tr>
                        @else
                            <tr><th>Info</th><th>Date</th></tr>
                        @endif
                    </thead>
                    <tbody>
                        @forelse($records as $record)
                        @if($normalizedModule === 'farmers')
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
                        @elseif($normalizedModule === 'collections')
                            <tr>
                                <td><i class="fas fa-user" style="margin-right:4px"></i> {{ $record->farmer?->name ?? '-' }}</td>
                                <td>{{ $record->product_name ?? '-' }}</td>
                                <td>{{ $record->location?->name ?? '-' }}</td>
                                <td>{{ $record->collection_date?->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ $record->quantity_collected ?? '-' }}</td>
                                <td>{{ $record->accepted_quantity ?? '-' }}</td>
                                <td>{{ $record->quantity_rejected ?? ($record->rejected_quantity ?? '-') }}</td>
                                <td>{{ $record->price_per_kg ?? '-' }}</td>
                                <td class="actions">
                                    <a href="{{ route('modules.edit', ['module' => $module, 'id' => $record->id]) }}" class="secondary" style="text-decoration:none;"><i class="fas fa-pen"></i> Edit</a>
                                    <form method="POST" action="{{ route('modules.destroy', ['module' => $module, 'id' => $record->id]) }}" onsubmit="return confirm('Delete this record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @elseif($normalizedModule === 'locations')
                            <tr>
                                <td><i class="fas fa-tag" style="margin-right:4px"></i> {{ $record->name }}</td>
                                <td>{{ $record->code }}</td>
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
                        @elseif($normalizedModule === 'employees')
                            <tr>
                                <td><strong>{{ $record->full_name }}</strong><div class="sub">{{ $record->employee_code }}</div></td>
                                <td>{{ $record->department ?? '-' }}</td>
                                <td>{{ $record->position ?? '-' }}</td>
                                <td>{{ $record->phone_number ?? '-' }}</td>
                                <td>{{ $record->email ?? '-' }}</td>
                                <td>{{ $record->hire_date?->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ $record->status ?? '-' }}</td>
                                <td class="actions">
                                    <a href="{{ route('modules.edit', ['module' => $module, 'id' => $record->id]) }}" class="secondary" style="text-decoration:none;"><i class="fas fa-pen"></i> Edit</a>
                                    <form method="POST" action="{{ route('modules.destroy', ['module' => $module, 'id' => $record->id]) }}" onsubmit="return confirm('Delete this record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td>{{ $record->id ?? '-' }}</td>
                                <td>{{ $record->created_at?->format('Y-m-d') ?? '-' }}</td>
                            </tr>
                        @endif
                        @empty
                            <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:24px;"><i class="fas fa-folder-open" style="font-size:2rem;margin-bottom:8px;display:block;color:var(--line)"></i>No records yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($records instanceof \Illuminate\Pagination\Paginator || $records instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="pagination">{{ $records->links() }}</div>
            @endif

        </section>
    </main>
</div>
<script>{!! file_get_contents(resource_path('js/modules.js')) !!}</script>
</body>
</html>

