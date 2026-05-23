<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst(str_replace('-', ' ', $module)) }} - HigaGroup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
:root {
    --brand: #5f9e3d;
    --brand-dark: #3f7f2d;
    --brand-green-dark: #3f7f2d;
    --bg: #f5f7fb;
    --card: #ffffff;
    --text: #1e293b;
    --muted: #64748b;
    --line: #e2e8f0;
    --danger: #dc2626;
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: Arial, Helvetica, sans-serif;
    background: var(--bg);
    color: var(--text);
}

.shell { display: flex; min-height: 100vh; }

/* ── SIDEBAR ── */
.sidebar {
    width: 260px;
    background: #fff;
    border-right: 1px solid var(--line);
    padding: 20px;
    display: flex;
    flex-direction: column;
}

.brand {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--brand-dark);
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.menu { display: flex; flex-direction: column; gap: 8px; }

.menu a {
    text-decoration: none;
    color: var(--text);
    padding: 12px 14px;
    border-radius: 12px;
    transition: .3s;
    display: flex;
    align-items: center;
    gap: 10px;
}

.menu a:hover,
.menu a.active { background: var(--brand); color: #fff; }

.spacer { flex: 1; }

.user-box {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 0;
    border-top: 1px solid var(--line);
    margin-top: 12px;
    margin-bottom: 12px;
}

.avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--brand);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    flex-shrink: 0;
}

.user-name { font-weight: 600; font-size: .9rem; }
.user-role { font-size: .75rem; color: var(--muted); }

.logout-btn {
    width: 100%;
    border: none;
    background: var(--danger);
    color: #fff;
    padding: 12px;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

/* ── MAIN ── */
.main { flex: 1; padding: 24px; overflow-x: hidden; }

.topbar-ims {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    gap: 15px;
    flex-wrap: wrap;
}

.topbar-ims-title {
    font-size: 1.5rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--text);
}

.topbar-account {
    display: flex;
    align-items: center;
    gap: 14px;
}

.topbar-link {
    text-decoration: none;
    color: var(--muted);
    font-size: .9rem;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: color .2s;
}

.topbar-link:hover { color: var(--brand); }

.topbar-link-btn {
    border: none;
    background: none;
    color: var(--muted);
    font-size: .9rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 0;
    transition: color .2s;
}

.topbar-link-btn:hover { color: var(--danger); }

/* ── BUTTONS ── */
.primary, .secondary, .danger {
    border: none;
    padding: 10px 16px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: .9rem;
    transition: opacity .2s;
}

.primary { background: var(--brand); color: #fff; }
.primary:hover { opacity: .88; }
.secondary { background: #e2e8f0; color: #111; }
.secondary:hover { opacity: .8; }
.danger { background: var(--danger); color: #fff; }
.danger:hover { opacity: .88; }

/* ── CARD ── */
.card {
    background: #fff;
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
}

/* ── ALERTS ── */
.success, .error {
    padding: 12px 16px;
    border-radius: 10px;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

.success { background: #dcfce7; color: #166534; }
.error   { background: #fee2e2; color: #991b1b; }

.sub { font-size: .82rem; color: var(--muted); margin-top: 2px; }

/* ── TABLE ── */
.table-responsive { overflow-x: auto; }

table { width: 100%; border-collapse: collapse; min-width: 800px; }

th {
    background: #f8fafc;
    padding: 14px;
    text-align: left;
    font-size: .85rem;
    text-transform: uppercase;
    letter-spacing: .03em;
    color: var(--muted);
    font-weight: 600;
}

td { padding: 14px; border-top: 1px solid var(--line); font-size: .9rem; }

td .actions { display: flex; gap: 8px; align-items: center; }

/* ── STATUS BADGE ── */
.status-badge {
    padding: 4px 11px;
    border-radius: 30px;
    font-size: .78rem;
    font-weight: 700;
    display: inline-block;
}

.status-badge.active   { background: #dcfce7; color: #166534; }
.status-badge.inactive { background: #fee2e2; color: #991b1b; }

/* ── PAGINATION ── */
.pagination { margin-top: 20px; }

/* ── MODAL OVERLAY ── */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.55);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 999;
    padding: 20px;
}

.modal-overlay.is-open { display: flex; }

.modal-card {
    background: #fff;
    width: 100%;
    max-width: 950px;
    border-radius: 22px;
    padding: 24px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.modal-header h3 { font-size: 1.15rem; }

.icon-close {
    border: none;
    background: #f1f5f9;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--muted);
    transition: background .2s;
}

.icon-close:hover { background: #e2e8f0; color: var(--text); }

/* ── FORM GRID ── */
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 18px;
}

.form-grid > div { display: flex; flex-direction: column; }

.form-grid label {
    margin-bottom: 7px;
    font-weight: 600;
    font-size: .88rem;
    display: flex;
    align-items: center;
    gap: 5px;
}

.form-grid input,
.form-grid select {
    padding: 11px 13px;
    border: 1px solid var(--line);
    border-radius: 10px;
    font-size: .9rem;
    transition: border-color .2s;
    background: #fff;
}

.form-grid input:focus,
.form-grid select:focus {
    outline: none;
    border-color: var(--brand);
}

.form-grid .full { grid-column: 1 / -1; }

.form-grid .actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

/* nationality "Other" text input reveal */
#nationality-other-wrap { display: none; }

/* ── FORM TOOLBAR ── */
.form-toolbar {
    font-size: .82rem;
    color: var(--muted);
    margin-bottom: 4px;
}

/* ── SEARCH BAR ── */
.table-toolbar {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 18px;
    flex-wrap: wrap;
}

.search-wrap {
    position: relative;
    flex: 1;
    min-width: 220px;
    max-width: 380px;
}

.search-wrap i {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
    pointer-events: none;
    font-size: .9rem;
}

.search-wrap input {
    width: 100%;
    padding: 10px 13px 10px 36px;
    border: 1px solid var(--line);
    border-radius: 10px;
    font-size: .9rem;
    transition: border-color .2s;
    background: #f8fafc;
}

.search-wrap input:focus {
    outline: none;
    border-color: var(--brand);
    background: #fff;
}

.search-count {
    font-size: .82rem;
    color: var(--muted);
    white-space: nowrap;
}

.search-no-results {
    display: none;
    text-align: center;
    padding: 40px 20px;
    color: var(--muted);
}

.search-no-results i {
    font-size: 2rem;
    display: block;
    margin-bottom: 8px;
    color: #cbd5e1;
}

/* ── EMPTY STATE ── */
.empty-state {
    text-align: center;
    padding: 48px 20px;
    color: var(--muted);
}

.empty-state i {
    font-size: 2.6rem;
    margin-bottom: 12px;
    display: block;
    color: #cbd5e1;
}

@media (max-width: 900px) {
    .sidebar { display: none; }
    .main { padding: 15px; }
}
    </style>
</head>
<body>

<div class="shell">

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar">
        <div class="brand">
            <img src="{{ asset('higalog.jpg') }}" alt="HigaGroup Logo"
                 style="max-height:32px;width:auto;border-radius:6px;">
        </div>

        <nav class="menu">
            @foreach($menuItems as $item)
                <a href="{{ $item['endpoint'] ?? $item['href'] ?? '#' }}"
                   class="{{ $navActive === $item['slug'] ? 'active' : '' }}">
                    <i class="fas {{ $item['icon'] ?? 'fa-circle' }}"></i>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="spacer"></div>

        <div class="user-box">
            <div class="avatar" title="{{ auth()->user()->name }}">
                @php
                    $ulabel   = trim((string) (auth()->user()->name ?? auth()->user()->email ?? ''));
                    $uinitial = $ulabel !== '' ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($ulabel, 0, 1)) : '?';
                @endphp
                {{ $uinitial }}
            </div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn" type="submit">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </aside>

    {{-- ── MAIN ── --}}
    <main class="main">

        {{-- TOPBAR --}}
        <div class="topbar-ims">
            <div class="topbar-ims-title">
                <i class="fas fa-layer-group"></i>
                {{ $module === 'locations' ? 'Warehouses' : ucfirst(str_replace('-', ' ', $module)) }}
            </div>
            <div class="topbar-account">
                <a href="{{ route('profile.edit') }}" class="topbar-link">
                    <i class="fas fa-user-circle"></i> Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="topbar-link-btn">
                        <i class="fas fa-power-off"></i> Log out
                    </button>
                </form>
            </div>
        </div>

        @php
            $canCreate        = !in_array($module, ['raw-inventory', 'finished-inventory']);
            $showForm         = $canCreate && ($editRecord || $errors->any() || count(old()) > 0);
            $normalizedModule = strtolower(trim((string) $module));
        @endphp

        {{-- ADD BUTTON --}}
        @if($canCreate && !$editRecord)
            <div style="margin: 0 0 16px 0;">
                <button type="button" id="show-form-btn" class="primary">
                    <i class="fas fa-plus"></i>
                    Add {{ $normalizedModule === 'locations' ? 'Warehouse' : str_replace('-', ' ', $module) }}
                </button>
            </div>
        @endif

        {{-- ALERTS --}}
        @if(session('success'))
            <p class="success"><i class="fas fa-check-circle"></i> {{ session('success') }}</p>
        @endif
        @if($errors->any())
            <p class="error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</p>
        @endif

        {{-- ── MODAL FORM ── --}}
        <div id="module-form-modal" class="modal-overlay {{ $showForm ? 'is-open' : '' }}">
            <div class="modal-card" role="dialog" aria-modal="true" aria-label="Add record form">

                <div class="modal-header">
                    <h3>
                        <i class="fas {{ $editRecord ? 'fa-pen' : 'fa-plus' }}"
                           style="margin-right:6px;color:var(--brand-green-dark)"></i>
                        {{ $editRecord ? 'Edit' : 'Add' }}
                        {{ $module === 'locations' ? 'Warehouse' : str_replace('-', ' ', $module) }} record
                    </h3>
                    <button class="icon-close" id="close-form-btn" type="button" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form method="POST"
                      action="{{ $editRecord
                          ? route('modules.update', ['module' => $module, 'id' => $editRecord->id])
                          : route('modules.store',  ['module' => $module]) }}"
                      class="form-grid">
                    @csrf
                    @if($editRecord) @method('PUT') @endif

                    {{-- ════════════════════════════════
                         FARMERS
                    ════════════════════════════════ --}}
                    @if($module === 'farmers')
                        <div><label><i class="fas fa-user"></i> Name</label><input name="name" value="{{ old('name', $editRecord?->name ?? '') }}" required></div>
                        <div><label><i class="fas fa-phone"></i> Phone</label><input name="phone" value="{{ old('phone', $editRecord?->phone ?? '') }}" required></div>
                        <div><label><i class="fas fa-globe"></i> Country</label><input name="country" value="{{ old('country', $editRecord?->country ?? 'Rwanda') }}" required></div>
                        <div><label><i class="fas fa-map"></i> Province</label><input name="province" value="{{ old('province', $editRecord?->province ?? '') }}" required></div>
                        <div><label><i class="fas fa-city"></i> District</label><input name="district" value="{{ old('district', $editRecord?->district ?? '') }}" required></div>
                        <div><label><i class="fas fa-building"></i> Sector</label><input name="sector" value="{{ old('sector', $editRecord?->sector ?? '') }}" required></div>
                        <div><label><i class="fas fa-home"></i> Cell</label><input name="cell" value="{{ old('cell', $editRecord?->cell ?? '') }}" required></div>
                        <div><label><i class="fas fa-tree"></i> Village</label><input name="village" value="{{ old('village', $editRecord?->village ?? '') }}" required></div>

                    {{-- ════════════════════════════════
                         LOCATIONS / WAREHOUSES
                    ════════════════════════════════ --}}
                    @elseif($module === 'locations')
                        <div><label><i class="fas fa-tag"></i> Name</label><input name="name" value="{{ old('name', $editRecord?->name ?? '') }}" required></div>
                        <div><label><i class="fas fa-barcode"></i> Code</label><input name="code" value="{{ old('code', $editRecord?->code ?? '') }}" required></div>
                        <div><label><i class="fas fa-globe"></i> Country</label><input name="country" value="{{ old('country', $editRecord?->country ?? 'Rwanda') }}" required></div>
                        <div><label><i class="fas fa-map"></i> Province</label><input name="province" value="{{ old('province', $editRecord?->province ?? '') }}" required></div>
                        <div><label><i class="fas fa-city"></i> District</label><input name="district" value="{{ old('district', $editRecord?->district ?? '') }}" required></div>
                        <div><label><i class="fas fa-building"></i> Sector</label><input name="sector" value="{{ old('sector', $editRecord?->sector ?? '') }}" required></div>
                        <div><label><i class="fas fa-home"></i> Cell</label><input name="cell" value="{{ old('cell', $editRecord?->cell ?? '') }}" required></div>
                        <div><label><i class="fas fa-tree"></i> Village</label><input name="village" value="{{ old('village', $editRecord?->village ?? '') }}" required></div>

                    {{-- ════════════════════════════════
                         EMPLOYEES
                    ════════════════════════════════ --}}
                    @elseif($module === 'employees')
                        @php
                            /* ── Exact positions at Higa Group ── */
                            $empPositions = [
                                'General Manager',
                                'Manager',
                                'Sales and Marketing Manager',
                                'Supervisor',
                                'Accountant',
                                'Collection Officer',
                                'HR Officer',
                                'IT Officer',
                                'Logistics Officer',
                                'Officer',
                                'Production Officer',
                                'Sales Officer',
                                'Warehouse Officer',
                                'Driver',
                                'Operator',
                                'Technician',
                                'Cashier',
                                'Internship / Trainee',
                            ];

                            /* ── Departments ── */
                            $empDepts = [
                                'Administration',
                                'Finance',
                                'HR',
                                'Logistics',
                                'Operations',
                                'Production',
                                'Sales',
                            ];

                            /* ── Employment types ── */
                            $empEmpTypes = [
                                'Full-time',
                                'Part-time',
                                'Contract',
                                'Casual',
                                'Internship',
                            ];

                            /* ── Genders ── */
                            $empGenders = ['Male', 'Female', 'Other'];

                            /* ── Nationalities: Rwanda + East Africa ── */
                            $empNationalities = [
                                'Rwandan',
                                'Burundian',
                                'Congolese (DRC)',
                                'Kenyan',
                                'Tanzanian',
                                'Ugandan',
                            ];

                            /* ── Disability statuses ── */
                            $empDisability = ['None', 'Physical', 'Visual', 'Hearing', 'Cognitive', 'Other'];

                            /* ── Statuses ── */
                            $empStatuses = ['Active', 'Inactive'];

                            /* ── Work locations: pulled from lookupData() passed by the controller ── */
                            $warehouseList = $lookups['locations'] ?? collect();
                        @endphp

                        {{-- Row 1: Code + Full Name --}}
                        <div>
                            <label><i class="fas fa-id-card"></i> Employee Code</label>
                            <input name="employee_code"
                                   value="{{ old('employee_code', $editRecord?->employee_code ?? '') }}"
                                   placeholder="e.g. HG-0042" required>
                        </div>
                        <div>
                            <label><i class="fas fa-user"></i> Full Name</label>
                            <input name="full_name"
                                   value="{{ old('full_name', $editRecord?->full_name ?? '') }}"
                                   placeholder="First and last name" required>
                        </div>

                        {{-- Row 2: Gender + DOB --}}
                        <div>
                            <label><i class="fas fa-venus-mars"></i> Gender</label>
                            <select name="gender" required>
                                <option value="">— Select gender —</option>
                                @foreach($empGenders as $opt)
                                    <option value="{{ $opt }}"
                                        {{ old('gender', $editRecord?->gender) === $opt ? 'selected' : '' }}>
                                        {{ $opt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label><i class="fas fa-birthday-cake"></i> Date of Birth</label>
                            <input type="date" name="date_of_birth"
                                   value="{{ old('date_of_birth', $editRecord?->date_of_birth
                                       ? \Carbon\Carbon::parse($editRecord->date_of_birth)->format('Y-m-d')
                                       : '') }}">
                        </div>

                        {{-- Row 3: Nationality + Disability --}}
                        <div>
                            <label><i class="fas fa-flag"></i> Nationality</label>
                            <select name="nationality" id="nationality-select">
                                <option value="">— Select nationality —</option>
                                @foreach($empNationalities as $opt)
                                    <option value="{{ $opt }}"
                                        {{ old('nationality', $editRecord?->nationality) === $opt ? 'selected' : '' }}>
                                        {{ $opt }}
                                    </option>
                                @endforeach
                                {{-- "Other" lets staff type a custom value --}}
                                <option value="Other"
                                    {{ old('nationality', $editRecord?->nationality) === 'Other' ? 'selected' : '' }}>
                                    Other
                                </option>
                            </select>
                        </div>
                        {{-- Shown only when Other is picked --}}
                        <div id="nationality-other-wrap">
                            <label><i class="fas fa-pencil-alt"></i> Specify Nationality</label>
                            <input name="nationality_other" id="nationality-other-input"
                                   value="{{ old('nationality_other', '') }}"
                                   placeholder="e.g. Ethiopian">
                        </div>

                        <div>
                            <label><i class="fas fa-wheelchair"></i> Disability Status</label>
                            <select name="disability_status">
                                <option value="">— Select —</option>
                                @foreach($empDisability as $opt)
                                    <option value="{{ $opt }}"
                                        {{ old('disability_status', $editRecord?->disability_status) === $opt ? 'selected' : '' }}>
                                        {{ $opt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Row 4: Phone + Email --}}
                        <div>
                            <label><i class="fas fa-phone"></i> Phone Number</label>
                            <input name="phone_number"
                                   value="{{ old('phone_number', $editRecord?->phone_number ?? '') }}"
                                   placeholder="+250 7XX XXX XXX">
                        </div>
                        <div>
                            <label><i class="fas fa-envelope"></i> Email</label>
                            <input name="email" type="email"
                                   value="{{ old('email', $editRecord?->email ?? '') }}"
                                   placeholder="employee@higagroup.rw">
                        </div>

                        {{-- Address: full width --}}
                        <div class="full">
                            <label><i class="fas fa-map-marker-alt"></i> Address</label>
                            <input name="address"
                                   value="{{ old('address', $editRecord?->address ?? '') }}"
                                   placeholder="District, Province, Rwanda">
                        </div>

                        {{-- Row 5: Department + Position --}}
                        <div>
                            <label><i class="fas fa-building"></i> Department</label>
                            <select name="department" required>
                                <option value="">— Select department —</option>
                                @foreach($empDepts as $opt)
                                    <option value="{{ $opt }}"
                                        {{ old('department', $editRecord?->department) === $opt ? 'selected' : '' }}>
                                        {{ $opt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label><i class="fas fa-briefcase"></i> Position</label>
                            <select name="position" required>
                                <option value="">— Select position —</option>
                                @foreach($empPositions as $opt)
                                    <option value="{{ $opt }}"
                                        {{ old('position', $editRecord?->position) === $opt ? 'selected' : '' }}>
                                        {{ $opt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Row 6: Employment Type + Hire Date --}}
                        <div>
                            <label><i class="fas fa-user-tie"></i> Employment Type</label>
                            <select name="employment_type" required>
                                <option value="">— Select type —</option>
                                @foreach($empEmpTypes as $opt)
                                    <option value="{{ $opt }}"
                                        {{ old('employment_type', $editRecord?->employment_type) === $opt ? 'selected' : '' }}>
                                        {{ $opt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label><i class="fas fa-calendar-alt"></i> Hire Date</label>
                            <input type="date" name="hire_date"
                                   value="{{ old('hire_date', $editRecord?->hire_date
                                       ? \Carbon\Carbon::parse($editRecord->hire_date)->format('Y-m-d')
                                       : '') }}">
                        </div>

                        {{-- Row 7: Work Location (dynamic) + Status --}}
                        <div>
                            <label><i class="fas fa-warehouse"></i> Work Location</label>
                            <select name="work_location" required>
                                <option value="">— Select warehouse —</option>
                                @forelse($warehouseList as $warehouse)
                                    <option value="{{ $warehouse->name }}"
                                        {{ old('work_location', $editRecord?->work_location) === $warehouse->name ? 'selected' : '' }}>
                                        {{ $warehouse->name }}
                                        @if($warehouse->code) ({{ $warehouse->code }}) @endif
                                    </option>
                                @empty
                                    <option value="" disabled>No warehouses found — add one in Locations</option>
                                @endforelse
                            </select>
                        </div>
                        <div>
                            <label><i class="fas fa-circle"></i> Status</label>
                            <select name="status" required>
                                <option value="">— Select status —</option>
                                @foreach($empStatuses as $opt)
                                    <option value="{{ $opt }}"
                                        {{ old('status', $editRecord?->status ?? 'Active') === $opt ? 'selected' : '' }}>
                                        {{ $opt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    {{-- ════════════════════════════════
                         READ-ONLY MODULES
                    ════════════════════════════════ --}}
                    @else
                        <div class="full">
                            <p class="sub"><i class="fas fa-lock"></i> This module is ledger-driven and read-only in web view.</p>
                        </div>
                    @endif

                    @if($canCreate)
                        <div class="full actions">
                            <button class="primary" type="submit">
                                <i class="fas {{ $editRecord ? 'fa-save' : 'fa-check' }}"></i>
                                {{ $editRecord ? 'Update Record' : 'Save Record' }}
                            </button>
                            @if($editRecord)
                                <a href="{{ route('modules.show', ['module' => $module]) }}"
                                   class="secondary" style="text-decoration:none;">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            @else
                                <button class="secondary" id="cancel-form-btn" type="button">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            @endif
                        </div>
                    @endif
                </form>
            </div>
        </div>

        {{-- ── RECORDS TABLE ── --}}
        <section class="card">
            <h3 style="margin: 0 0 20px 0;">
                <i class="fas fa-list-alt" style="margin-right:8px;color:var(--brand-green-dark)"></i>
                Recent records
            </h3>

            <div class="table-toolbar">
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" id="table-search" placeholder="Search records…" autocomplete="off">
                </div>
                <span class="search-count" id="search-count"></span>
            </div>

            <div id="search-no-results" class="search-no-results">
                <i class="fas fa-search"></i>
                <strong>No matching records</strong>
                <p style="margin-top:4px;">Try a different keyword.</p>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        @if($normalizedModule === 'employees')
                            <tr>
                                <th>Employee</th>
                                <th>Gender</th>
                                <th>Date of Birth</th>
                                <th>Nationality</th>
                                <th>Disability</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Department</th>
                                <th>Position</th>
                                <th>Emp. Type</th>
                                <th>Hire Date</th>
                                <th>Work Location</th>
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
                                <th>Name</th><th>Phone</th><th>Country</th><th>Province</th>
                                <th>District</th><th>Sector</th><th>Cell</th><th>Village</th>
                                <th>Created</th><th>Actions</th>
                            </tr>
                        @elseif($module === 'locations')
                            <tr>
                                <th>Warehouse</th><th>Code</th><th>Country</th><th>Province</th>
                                <th>District</th><th>Sector</th><th>Cell</th><th>Village</th>
                                <th>Created</th><th>Actions</th>
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
                                    <td><i class="fas fa-user" style="margin-right:5px;color:var(--brand-green-dark)"></i> {{ $record->name }}</td>
                                    <td>{{ $record->phone }}</td>
                                    <td>{{ $record->country }}</td>
                                    <td>{{ $record->province }}</td>
                                    <td>{{ $record->district }}</td>
                                    <td>{{ $record->sector }}</td>
                                    <td>{{ $record->cell }}</td>
                                    <td>{{ $record->village }}</td>
                                    <td>{{ $record->created_at?->format('Y-m-d') ?? '-' }}</td>
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('modules.edit', ['module' => $module, 'id' => $record->id]) }}"
                                               class="secondary" style="text-decoration:none;">
                                                <i class="fas fa-pen"></i> Edit
                                            </a>
                                            <form method="POST"
                                                  action="{{ route('modules.destroy', ['module' => $module, 'id' => $record->id]) }}"
                                                  onsubmit="return confirm('Delete this record?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                            @elseif($normalizedModule === 'collections')
                                <tr>
                                    <td><i class="fas fa-user" style="margin-right:5px"></i> {{ $record->farmer?->name ?? '-' }}</td>
                                    <td>{{ $record->product_name ?? '-' }}</td>
                                    <td>{{ $record->location?->name ?? '-' }}</td>
                                    <td>{{ $record->collection_date?->format('Y-m-d') ?? '-' }}</td>
                                    <td>{{ $record->quantity_collected ?? '-' }}</td>
                                    <td>{{ $record->accepted_quantity ?? '-' }}</td>
                                    <td>{{ $record->quantity_rejected ?? ($record->rejected_quantity ?? '-') }}</td>
                                    <td>{{ $record->price_per_kg ?? '-' }}</td>
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('modules.edit', ['module' => $module, 'id' => $record->id]) }}"
                                               class="secondary" style="text-decoration:none;">
                                                <i class="fas fa-pen"></i> Edit
                                            </a>
                                            <form method="POST"
                                                  action="{{ route('modules.destroy', ['module' => $module, 'id' => $record->id]) }}"
                                                  onsubmit="return confirm('Delete this record?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                            @elseif($normalizedModule === 'locations')
                                <tr>
                                    <td><i class="fas fa-tag" style="margin-right:5px"></i> {{ $record->name }}</td>
                                    <td>{{ $record->code }}</td>
                                    <td>{{ $record->country }}</td>
                                    <td>{{ $record->province }}</td>
                                    <td>{{ $record->district }}</td>
                                    <td>{{ $record->sector }}</td>
                                    <td>{{ $record->cell }}</td>
                                    <td>{{ $record->village }}</td>
                                    <td>{{ $record->created_at?->format('Y-m-d') ?? '-' }}</td>
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('modules.edit', ['module' => $module, 'id' => $record->id]) }}"
                                               class="secondary" style="text-decoration:none;">
                                                <i class="fas fa-pen"></i> Edit
                                            </a>
                                            <form method="POST"
                                                  action="{{ route('modules.destroy', ['module' => $module, 'id' => $record->id]) }}"
                                                  onsubmit="return confirm('Delete this record?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                            @elseif($normalizedModule === 'employees')
                                <tr>
                                    <td>
                                        <strong>{{ $record->full_name }}</strong>
                                        <div class="sub">{{ $record->employee_code }}</div>
                                    </td>
                                    <td>{{ $record->gender ?? '-' }}</td>
                                    <td>{{ $record->date_of_birth ? \Carbon\Carbon::parse($record->date_of_birth)->format('Y-m-d') : '-' }}</td>
                                    <td>{{ $record->nationality ?? '-' }}</td>
                                    <td>{{ $record->disability_status ?? '-' }}</td>
                                    <td>{{ $record->phone_number ?? '-' }}</td>
                                    <td>{{ $record->email ?? '-' }}</td>
                                    <td>{{ $record->address ?? '-' }}</td>
                                    <td>{{ $record->department ?? '-' }}</td>
                                    <td>{{ $record->position ?? '-' }}</td>
                                    <td>{{ $record->employment_type ?? '-' }}</td>
                                    <td>{{ $record->hire_date ? \Carbon\Carbon::parse($record->hire_date)->format('Y-m-d') : '-' }}</td>
                                    <td>{{ $record->work_location ?? '-' }}</td>
                                    <td>
                                        <span class="status-badge {{ strtolower($record->status ?? 'inactive') }}">
                                            {{ $record->status ?? 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('modules.edit', ['module' => $module, 'id' => $record->id]) }}"
                                               class="secondary" style="text-decoration:none;">
                                                <i class="fas fa-pen"></i> Edit
                                            </a>
                                            <form method="POST"
                                                  action="{{ route('modules.destroy', ['module' => $module, 'id' => $record->id]) }}"
                                                  onsubmit="return confirm('Delete this record?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                            @else
                                <tr>
                                    <td>{{ $record->id ?? '-' }}</td>
                                    <td>{{ $record->created_at?->format('Y-m-d') ?? '-' }}</td>
                                </tr>
                            @endif


                        @empty
                            <tr>
                                <td colspan="15">
                                    <div class="empty-state">
                                        <i class="fas fa-folder-open"></i>
                                        <h3 style="margin-bottom:6px;">No Records Found</h3>
                                        <p>Start by adding your first record.</p>
                                    </div>
                                </td>
                            </tr>
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

<script>
(function () {
    /* ── MODAL ── */
    const modal     = document.getElementById('module-form-modal');
    const openBtn   = document.getElementById('show-form-btn');
    const closeBtn  = document.getElementById('close-form-btn');
    const cancelBtn = document.getElementById('cancel-form-btn');

    function openModal()  { modal.classList.add('is-open');    document.body.style.overflow = 'hidden'; }
    function closeModal() { modal.classList.remove('is-open'); document.body.style.overflow = '';       }

    openBtn  ?.addEventListener('click', openModal);
    closeBtn ?.addEventListener('click', closeModal);
    cancelBtn?.addEventListener('click', closeModal);

    modal?.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    /* ── NATIONALITY "OTHER" REVEAL ── */
    const natSelect   = document.getElementById('nationality-select');
    const natOtherWrap = document.getElementById('nationality-other-wrap');
    const natOtherInput = document.getElementById('nationality-other-input');

    function toggleNatOther() {
        const isOther = natSelect?.value === 'Other';
        if (natOtherWrap) natOtherWrap.style.display = isOther ? 'flex' : 'none';
        if (natOtherInput) natOtherInput.required = isOther;
    }

    natSelect?.addEventListener('change', toggleNatOther);
    toggleNatOther(); // run on load in case of old() value

    /* ── LIVE SEARCH ── */
    (function () {
        const input   = document.getElementById('table-search');
        const countEl = document.getElementById('search-count');
        const noRes   = document.getElementById('search-no-results');
        const tbody   = document.querySelector('table tbody');

        if (!input || !tbody) return;

        function getDataRows() {
            return Array.from(tbody.querySelectorAll('tr')).filter(tr =>
                tr.querySelectorAll('td').length > 1
            );
        }

        function update() {
            const rows = getDataRows();
            const q    = input.value.trim().toLowerCase();
            let visible = 0;

            rows.forEach(tr => {
                const show = !q || tr.innerText.toLowerCase().includes(q);
                tr.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            const total = rows.length;
            countEl.textContent = q
                ? `${visible} of ${total} record${total !== 1 ? 's' : ''}`
                : `${total} record${total !== 1 ? 's' : ''}`;

            noRes.style.display = (visible === 0 && q) ? 'block' : 'none';
        }

        input.addEventListener('input', update);
        update();
    })();
})();
</script>

</body>
</html>