@extends('layouts.app')

@section('title', 'SALN Form - Dashboard')

@section('styles')
<style>
    .form-section {
        background-color: var(--bg-white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        margin-bottom: 24px;
        overflow: hidden;
        transition: var(--transition);
    }

    .form-section:hover {
        box-shadow: var(--shadow-md);
    }

    .section-header {
        padding: 20px 24px;
        background-color: var(--bg-light);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: var(--transition);
        user-select: none;
    }

    .section-header:hover {
        background-color: var(--bg-gray);
    }

    .section-header h3 {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 600;
    }

    .section-toggle {
        font-size: 1.5rem;
        transition: transform 0.3s ease;
        font-weight: 300;
    }

    .section-content {
        padding: 24px;
        display: none;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .section-content.active {
        display: block;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    .form-row-3 {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    @media (max-width: 992px) {
        .form-row-3 {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 768px) {
        .form-row,
        .form-row-3 {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .section-header {
            padding: 16px 20px;
        }

        .section-content {
            padding: 20px;
        }

        .section-header h3 {
            font-size: 1rem;
        }
    }

    .repeater-item {
        background-color: var(--bg-light);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        padding: 20px;
        margin-bottom: 16px;
        position: relative;
        transition: var(--transition);
    }

    .repeater-item:hover {
        box-shadow: var(--shadow-sm);
    }

    @media (max-width: 768px) {
        .repeater-item {
            padding: 16px;
        }
    }

    .repeater-remove {
        position: absolute;
        top: 12px;
        right: 12px;
        background: var(--error-color);
        color: white;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        cursor: pointer;
        font-size: 20px;
        line-height: 1;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .repeater-remove:hover {
        transform: scale(1.1) rotate(90deg);
        box-shadow: var(--shadow-md);
    }

    .btn-add-item {
        background-color: var(--bg-light);
        border: 2px dashed var(--border-color);
        color: var(--text-secondary);
        width: 100%;
        transition: var(--transition);
        padding: 16px;
    }

    .btn-add-item:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        background-color: rgba(77, 159, 255, 0.05);
        transform: translateY(-2px);
    }

    .status-indicator {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 16px;
        font-size: 12px;
        font-weight: 600;
        background-color: var(--warning-color);
        color: white;
        transition: var(--transition);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .saved-indicator {
        background-color: var(--success-color);
        animation: pulse 0.5s ease;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Mobile-friendly navbar adjustments */
    @media (max-width: 992px) {
        .navbar-left {
            order: 2;
        }
        
        .navbar-right {
            order: 1;
            width: 100%;
            justify-content: flex-end;
        }

        .desktop-only {
            display: none !important;
        }
    }

    @media (min-width: 993px) {
        .mobile-only {
            display: none !important;
        }
    }

    @media (max-width: 768px) {
        .navbar .btn {
            padding: 8px 12px;
            font-size: 13px;
        }

        .navbar-left,
        .navbar-right {
            gap: 8px;
        }
    }

    /* Header improvements */
    header {
        box-shadow: var(--shadow-sm);
    }

    /* Footer improvements */
    footer {
        box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.05);
    }

    /* Improved form inputs in dark mode */
    [data-theme="dark"] input,
    [data-theme="dark"] select,
    [data-theme="dark"] textarea {
        background-color: var(--bg-gray);
        border-color: var(--border-color);
    }

    /* Checkbox styling */
    input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--primary-color);
    }

    /* Better label for checkbox */
    label:has(input[type="checkbox"]) {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-weight: 400;
    }
</style>
@endsection

@section('content')
<!-- Inactivity Notice Modal -->
@if(session('inactivity_notice'))
<div class="modal active" id="inactivity-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Session Expired</h3>
        </div>
        <div class="modal-body">
            <p>Your account has been inactive for over 5 days. For privacy reasons, your previously entered SALN data has been deleted.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="closeInactivityModal()">
                Continue & Start Fresh
            </button>
        </div>
    </div>
</div>
@endif

<!-- Header -->
<header style="background-color: var(--bg-white); border-bottom: 1px solid var(--border-color); padding: 12px 0; box-shadow: var(--shadow-sm);">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--primary-color);">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
                <div>
                    <h3 style="margin: 0; font-size: 1.125rem; font-weight: 700;">SALN Filing System</h3>
                    <p style="margin: 0; font-size: 12px; color: var(--text-muted); display: none;" class="desktop-only">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <div style="display: flex; gap: 8px; align-items: center;">
                <span style="font-size: 12px; color: var(--text-muted); display: none;" class="desktop-only">{{ Auth::user()->email }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="padding: 8px 16px; font-size: 14px;">
                        <span class="desktop-only">Logout</span>
                        <span class="mobile-only">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<!-- Navigation Bar -->
<nav class="navbar" style="top: auto; position: sticky;">
    <div class="container">
        <div class="navbar-content">
            <div class="navbar-left">
                <form action="{{ route('form.new') }}" method="POST" style="display: inline;" onsubmit="return confirm('Start a new entry? Current form will be archived.');">
                    @csrf
                    <button type="submit" class="btn btn-secondary">New Entry</button>
                </form>
                <label for="import-file" class="btn btn-secondary" style="cursor: pointer; margin: 0;">
                    Import JSON
                </label>
                <form id="import-form" action="{{ route('form.import') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                    @csrf
                    <input type="file" id="import-file" name="file" accept=".json" onchange="this.form.submit()">
                </form>
                <button type="button" class="btn btn-secondary" onclick="exportJson()">Export JSON</button>
                <button type="button" class="btn btn-success" onclick="saveForm()">Save</button>
                <form action="{{ route('form.generate.pdf') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">Generate PDF</button>
                </form>
            </div>
            <div class="navbar-right">
                <span class="status-indicator" id="save-status">Draft</span>
            </div>
        </div>
    </div>
</nav>

<div class="container" style="padding-top: 32px; padding-bottom: 80px;">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error)
                <p style="margin: 0;">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <h2 style="margin: 0;">SALN Form 2025</h2>
        <!-- <span class="status-indicator" id="save-status">Draft</span> -->
    </div>

    <form id="saln-form">
        <!-- Form Metadata Section -->
        <div class="form-section">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>Form Information</h3>
                <span class="section-toggle">−</span>
            </div>
            <div class="section-content active">
                <div class="form-row">
                    <div class="form-group">
                        <label>Compliance Type *</label>
                        <select name="form_metadata[compliance_type]" required>
                            <option value="">Select</option>
                            <option value="ASSUMPTION">Assumption</option>
                            <option value="ANNUAL">Annual</option>
                            <option value="EXIT">Exit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>As of Date *</label>
                        <input type="date" name="form_metadata[as_of_date]" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Filing Type *</label>
                        <select name="form_metadata[filing_type]" required>
                            <option value="">Select</option>
                            <option value="JOINT">Joint</option>
                            <option value="SEPARATE">Separate</option>
                            <option value="NOT_APPLICABLE">Not Applicable</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>CSC Resolution No.</label>
                        <input type="text" name="form_metadata[csc_resolution_no]">
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Information Section -->
        <div class="form-section">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>Personal Information</h3>
                <span class="section-toggle">−</span>
            </div>
            <div class="section-content active">
                <div class="form-row-3">
                    <div class="form-group">
                        <label>Last Name *</label>
                        <input type="text" name="declarant[personal_information][last_name]" required>
                    </div>
                    <div class="form-group">
                        <label>First Name *</label>
                        <input type="text" name="declarant[personal_information][first_name]" required>
                    </div>
                    <div class="form-group">
                        <label>Middle Initial</label>
                        <input type="text" name="declarant[personal_information][middle_initial]" maxlength="5">
                    </div>
                </div>
                <div class="form-group">
                    <label>Position *</label>
                    <input type="text" name="declarant[personal_information][position]" required>
                </div>
                <div class="form-group">
                    <label>Agency/Office *</label>
                    <input type="text" name="declarant[personal_information][agency_office]" required>
                </div>
                <div class="form-group">
                    <label>Office Address *</label>
                    <textarea name="declarant[personal_information][office_address]" rows="2" required></textarea>
                </div>

                <h4 style="margin-top: 24px; margin-bottom: 16px;">Government ID</h4>
                <div class="form-row">
                    <div class="form-group">
                        <label>ID Type</label>
                        <input type="text" name="declarant[personal_information][government_id][type]" placeholder="e.g., Driver's License">
                    </div>
                    <div class="form-group">
                        <label>ID Number</label>
                        <input type="text" name="declarant[personal_information][government_id][id_number]">
                    </div>
                </div>
                <div class="form-group">
                    <label>Date Issued</label>
                    <input type="date" name="declarant[personal_information][government_id][date_issued]">
                </div>
            </div>
        </div>

        <!-- Spouse Information Section -->
        <div class="form-section">
            <div class="section-header" onclick="toggleSection(this)">
<h3>Spouse Information</h3>
                <span class="section-toggle">+</span>
            </div>
            <div class="section-content">
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="has_spouse" onchange="toggleSpouseFields(this)"> I have a spouse
                    </label>
                </div>
                <div id="spouse-fields" style="display: none;">
                    <div class="form-row-3">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="spouse[last_name]">
                        </div>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="spouse[first_name]">
                        </div>
                        <div class="form-group">
                            <label>Middle Initial</label>
                            <input type="text" name="spouse[middle_initial]" maxlength="5">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="spouse[is_public_official]"> Is a public official
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Position</label>
                        <input type="text" name="spouse[position]">
                    </div>
                    <div class="form-group">
                        <label>Agency/Office</label>
                        <input type="text" name="spouse[agency_office]">
                    </div>
                </div>
            </div>
        </div>

        <!-- Children Section -->
        <div class="form-section">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>Children Below 18</h3>
                <span class="section-toggle">+</span>
            </div>
            <div class="section-content">
                <div id="children-list"></div>
                <button type="button" class="btn btn-add-item" onclick="addChild()">+ Add Child</button>
            </div>
        </div>

        <!-- Real Properties Section -->
        <div class="form-section">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>Real Properties</h3>
                <span class="section-toggle">+</span>
            </div>
            <div class="section-content">
                <div id="real-properties-list"></div>
                <button type="button" class="btn btn-add-item" onclick="addRealProperty()">+ Add Real Property</button>
            </div>
        </div>

        <!-- Personal Properties Section -->
        <div class="form-section">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>Personal Properties</h3>
                <span class="section-toggle">+</span>
            </div>
            <div class="section-content">
                <div id="personal-properties-list"></div>
                <button type="button" class="btn btn-add-item" onclick="addPersonalProperty()">+ Add Personal Property</button>
            </div>
        </div>

        <!-- Liabilities Section -->
        <div class="form-section">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>Liabilities</h3>
                <span class="section-toggle">+</span>
            </div>
            <div class="section-content">
                <div id="liabilities-list"></div>
                <button type="button" class="btn btn-add-item" onclick="addLiability()">+ Add Liability</button>
            </div>
        </div>

        <!-- Business Interests Section -->
        <div class="form-section">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>Business Interests & Financial Connections</h3>
                <span class="section-toggle">+</span>
            </div>
            <div class="section-content">
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="business_interests[has_business_interest]" onchange="toggleBusinessFields(this)"> 
                        I have business interests or financial connections
                    </label>
                </div>
                <div id="business-fields" style="display: none;">
                    <div id="business-list"></div>
                    <button type="button" class="btn btn-add-item" onclick="addBusiness()">+ Add Business Interest</button>
                </div>
            </div>
        </div>

        <!-- Relatives in Government Section -->
        <div class="form-section">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>Relatives in Government Service</h3>
                <span class="section-toggle">+</span>
            </div>
            <div class="section-content">
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="relatives_in_government[has_relatives]" onchange="toggleRelativesFields(this)"> 
                        I have relatives in government service
                    </label>
                </div>
                <div id="relatives-fields" style="display: none;">
                    <div id="relatives-list"></div>
                    <button type="button" class="btn btn-add-item" onclick="addRelative()">+ Add Relative</button>
                </div>
            </div>
        </div>

        <!-- Certification Section -->
        <div class="form-section">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>Certification</h3>
                <span class="section-toggle">+</span>
            </div>
            <div class="section-content">
                <div class="form-group">
                    <label>Date Signed</label>
                    <input type="date" name="certification[date_signed]">
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="certification[authorization_to_verify]" required>
                        I authorize the Ombudsman or his/her authorized representative to verify my SALN statements
                    </label>
                </div>
            </div>
        </div>
    </form>

    <div class="privacy-notice">
        <p style="font-weight: 500; margin-bottom: 8px;">
            🔒 Privacy Reminder
        </p>
        <p style="font-size: 14px; color: var(--text-secondary); margin: 0;">
            Your data will be automatically deleted after 5 days of inactivity. 
            Export your data locally (JSON) if you need to keep a backup.
        </p>
    </div>
</div>

<!-- Footer -->
<footer style="background-color: var(--bg-light); border-top: 1px solid var(--border-color); padding: 32px 0; margin-top: 48px; box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.05);">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">
                © {{ date('Y') }} SALN Filing System | <a href="#" style="color: var(--text-muted); text-decoration: underline;">Privacy Policy</a> | <a href="#" style="color: var(--text-muted); text-decoration: underline;">Help</a>
            </p>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">
                <strong>Last saved:</strong> <span id="last-saved-time">Never</span>
            </p>
        </div>
    </div>
</footer>

@section('scripts')
<script>
let childCounter = 0;
let realPropertyCounter = 0;
let personalPropertyCounter = 0;
let liabilityCounter = 0;
let businessCounter = 0;
let relativeCounter = 0;

function closeInactivityModal() {
    document.getElementById('inactivity-modal').classList.remove('active');
}

function toggleSection(header) {
    const content = header.nextElementSibling;
    const toggle = header.querySelector('.section-toggle');
    
    if (content.classList.contains('active')) {
        content.classList.remove('active');
        toggle.textContent = '+';
    } else {
        content.classList.add('active');
        toggle.textContent = '−';
    }
}

function toggleSpouseFields(checkbox) {
    document.getElementById('spouse-fields').style.display = checkbox.checked ? 'block' : 'none';
}

function toggleBusinessFields(checkbox) {
    document.getElementById('business-fields').style.display = checkbox.checked ? 'block' : 'none';
}

function toggleRelativesFields(checkbox) {
    document.getElementById('relatives-fields').style.display = checkbox.checked ? 'block' : 'none';
}

function addChild() {
    const html = `
        <div class="repeater-item" id="child-${childCounter}">
            <button type="button" class="repeater-remove" onclick="removeItem('child-${childCounter}')">×</button>
            <div class="form-row">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="children_below_18[${childCounter}][name]">
                </div>
                <div class="form-group">
                    <label>Age</label>
                    <input type="number" name="children_below_18[${childCounter}][age]" min="0" max="17">
                </div>
            </div>
        </div>
    `;
    document.getElementById('children-list').insertAdjacentHTML('beforeend', html);
    childCounter++;
}

function addRealProperty() {
    const html = `
        <div class="repeater-item" id="real-property-${realPropertyCounter}">
            <button type="button" class="repeater-remove" onclick="removeItem('real-property-${realPropertyCounter}')">×</button>
            <div class="form-group">
                <label>Description</label>
                <input type="text" name="assets[real_properties][${realPropertyCounter}][description]" placeholder="e.g., House and Lot">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Kind</label>
                    <select name="assets[real_properties][${realPropertyCounter}][kind]">
                        <option value="">Select</option>
                        <option value="RESIDENTIAL">Residential</option>
                        <option value="COMMERCIAL">Commercial</option>
                        <option value="INDUSTRIAL">Industrial</option>
                        <option value="AGRICULTURAL">Agricultural</option>
                        <option value="MIXED_USE">Mixed Use</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="assets[real_properties][${realPropertyCounter}][exact_location]">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Assessed Value (₱)</label>
                    <input type="number" name="assets[real_properties][${realPropertyCounter}][assessed_value]" step="0.01" min="0">
                </div>
                <div class="form-group">
                    <label>Fair Market Value (₱)</label>
                    <input type="number" name="assets[real_properties][${realPropertyCounter}][fair_market_value]" step="0.01" min="0">
                </div>
            </div>
            <h5 style="margin: 16px 0 12px;">Acquisition Details</h5>
            <div class="form-row-3">
                <div class="form-group">
                    <label>Year Acquired</label>
                    <input type="number" name="assets[real_properties][${realPropertyCounter}][acquisition][year]" min="1900" max="2100">
                </div>
                <div class="form-group">
                    <label>Mode</label>
                    <select name="assets[real_properties][${realPropertyCounter}][acquisition][mode]">
                        <option value="">Select</option>
                        <option value="PURCHASE">Purchase</option>
                        <option value="INHERITANCE">Inheritance</option>
                        <option value="DONATION">Donation</option>
                        <option value="OTHER">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Cost (₱)</label>
                    <input type="number" name="assets[real_properties][${realPropertyCounter}][acquisition][cost]" step="0.01" min="0">
                </div>
            </div>
        </div>
    `;
    document.getElementById('real-properties-list').insertAdjacentHTML('beforeend', html);
    realPropertyCounter++;
}

function addPersonalProperty() {
    const html = `
        <div class="repeater-item" id="personal-property-${personalPropertyCounter}">
            <button type="button" class="repeater-remove" onclick="removeItem('personal-property-${personalPropertyCounter}')">×</button>
            <div class="form-group">
                <label>Description</label>
                <input type="text" name="assets[personal_properties][${personalPropertyCounter}][description]" placeholder="e.g., Toyota Fortuner 2023">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Year Acquired</label>
                    <input type="number" name="assets[personal_properties][${personalPropertyCounter}][acquisition_year]" min="1900" max="2100">
                </div>
                <div class="form-group">
                    <label>Acquisition Cost (₱)</label>
                    <input type="number" name="assets[personal_properties][${personalPropertyCounter}][acquisition_cost]" step="0.01" min="0">
                </div>
            </div>
        </div>
    `;
    document.getElementById('personal-properties-list').insertAdjacentHTML('beforeend', html);
    personalPropertyCounter++;
}

function addLiability() {
    const html = `
        <div class="repeater-item" id="liability-${liabilityCounter}">
            <button type="button" class="repeater-remove" onclick="removeItem('liability-${liabilityCounter}')">×</button>
            <div class="form-row-3">
                <div class="form-group">
                    <label>Nature</label>
                    <input type="text" name="liabilities[${liabilityCounter}][nature]" placeholder="e.g., Home Loan">
                </div>
                <div class="form-group">
                    <label>Creditor Name</label>
                    <input type="text" name="liabilities[${liabilityCounter}][creditor_name]">
                </div>
                <div class="form-group">
                    <label>Outstanding Balance (₱)</label>
                    <input type="number" name="liabilities[${liabilityCounter}][outstanding_balance]" step="0.01" min="0">
                </div>
            </div>
        </div>
    `;
    document.getElementById('liabilities-list').insertAdjacentHTML('beforeend', html);
    liabilityCounter++;
}

function addBusiness() {
    const html = `
        <div class="repeater-item" id="business-${businessCounter}">
            <button type="button" class="repeater-remove" onclick="removeItem('business-${businessCounter}')">×</button>
            <div class="form-group">
                <label>Entity Name</label>
                <input type="text" name="business_interests[entries][${businessCounter}][entity_name]">
            </div>
            <div class="form-group">
                <label>Business Address</label>
                <input type="text" name="business_interests[entries][${businessCounter}][business_address]">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Nature of Interest</label>
                    <input type="text" name="business_interests[entries][${businessCounter}][nature_of_interest]" placeholder="e.g., Stockholder, Partner">
                </div>
                <div class="form-group">
                    <label>Date Acquired</label>
                    <input type="date" name="business_interests[entries][${businessCounter}][date_acquired]">
                </div>
            </div>
        </div>
    `;
    document.getElementById('business-list').insertAdjacentHTML('beforeend', html);
    businessCounter++;
}

function addRelative() {
    const html = `
        <div class="repeater-item" id="relative-${relativeCounter}">
            <button type="button" class="repeater-remove" onclick="removeItem('relative-${relativeCounter}')">×</button>
            <div class="form-row">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="relatives_in_government[entries][${relativeCounter}][relative_name]">
                </div>
                <div class="form-group">
                    <label>Relationship</label>
                    <input type="text" name="relatives_in_government[entries][${relativeCounter}][relationship]" placeholder="e.g., Spouse, Parent, Sibling">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Position</label>
                    <input type="text" name="relatives_in_government[entries][${relativeCounter}][position]">
                </div>
                <div class="form-group">
                    <label>Agency/Office</label>
                    <input type="text" name="relatives_in_government[entries][${relativeCounter}][agency_office]">
                </div>
            </div>
        </div>
    `;
    document.getElementById('relatives-list').insertAdjacentHTML('beforeend', html);
    relativeCounter++;
}

function removeItem(id) {
    document.getElementById(id).remove();
}

async function saveForm() {
    const form = document.getElementById('saln-form');
    const formData = new FormData(form);
    const data = {};
    
    // Convert FormData to nested object
    for (let [key, value] of formData.entries()) {
        setNestedValue(data, key, value);
    }

    const statusIndicator = document.getElementById('save-status');
    statusIndicator.textContent = 'Saving...';

    try {
        const response = await fetch('{{ route("form.save") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ form_data: data })
        });

        const result = await response.json();

        if (result.success) {
            statusIndicator.textContent = 'Saved';
            statusIndicator.classList.add('saved-indicator');
            
            // Update last saved time
            document.getElementById('last-saved-time').textContent = new Date().toLocaleString();
            
            setTimeout(() => {
                statusIndicator.classList.remove('saved-indicator');
                statusIndicator.textContent = 'Draft';
            }, 2000);
        }
    } catch (error) {
        console.error('Save error:', error);
        alert('Failed to save. Please try again.');
        statusIndicator.textContent = 'Error';
        setTimeout(() => {
            statusIndicator.textContent = 'Draft';
        }, 2000);
    }
}

function setNestedValue(obj, path, value) {
    const keys = path.match(/[^\[\]]+/g);
    let current = obj;
    
    for (let i = 0; i < keys.length - 1; i++) {
        const key = keys[i];
        if (!current[key]) {
            current[key] = isNaN(keys[i + 1]) ? {} : [];
        }
        current = current[key];
    }
    
    current[keys[keys.length - 1]] = value;
}

async function exportJson() {
    try {
        const response = await fetch('{{ route("form.export") }}', {
            headers: {
                'Accept': 'application/json',
            }
        });

        const data = await response.json();
        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `saln-${new Date().toISOString().split('T')[0]}.json`;
        a.click();
        URL.revokeObjectURL(url);
    } catch (error) {
        console.error('Export error:', error);
        alert('No data to export.');
    }
}

// Auto-save every 2 minutes
setInterval(() => {
    saveForm();
}, 120000);

// Function to populate form fields with data
function populateForm(data) {
    if (!data) return;
    
    console.log('Loading form data:', data);
    
    // Populate simple fields
    function setFieldValue(name, value) {
        if (value === null || value === undefined) return;
        
        const field = document.querySelector(`[name="${name}"]`);
        if (field) {
            if (field.type === 'checkbox') {
                field.checked = !!value;
                // Trigger change event for conditional fields
                if (field.onchange) field.onchange();
            } else {
                field.value = value;
            }
        }
    }
    
    // Form Metadata
    if (data.form_metadata) {
        setFieldValue('form_metadata[compliance_type]', data.form_metadata.compliance_type);
        setFieldValue('form_metadata[as_of_date]', data.form_metadata.as_of_date);
        setFieldValue('form_metadata[filing_type]', data.form_metadata.filing_type);
        setFieldValue('form_metadata[csc_resolution_no]', data.form_metadata.csc_resolution_no);
    }
    
    // Personal Information
    if (data.declarant?.personal_information) {
        const pi = data.declarant.personal_information;
        setFieldValue('declarant[personal_information][last_name]', pi.last_name);
        setFieldValue('declarant[personal_information][first_name]', pi.first_name);
        setFieldValue('declarant[personal_information][middle_initial]', pi.middle_initial);
        setFieldValue('declarant[personal_information][position]', pi.position);
        setFieldValue('declarant[personal_information][agency_office]', pi.agency_office);
        setFieldValue('declarant[personal_information][office_address]', pi.office_address);
        
        if (pi.government_id) {
            setFieldValue('declarant[personal_information][government_id][type]', pi.government_id.type);
            setFieldValue('declarant[personal_information][government_id][id_number]', pi.government_id.id_number);
            setFieldValue('declarant[personal_information][government_id][date_issued]', pi.government_id.date_issued);
        }
    }
    
    // Spouse Information
    if (data.spouse) {
        const hasSpouseCheckbox = document.querySelector('[name="has_spouse"]');
        if (hasSpouseCheckbox) {
            hasSpouseCheckbox.checked = true;
            toggleSpouseFields(hasSpouseCheckbox);
        }
        setFieldValue('spouse[last_name]', data.spouse.last_name);
        setFieldValue('spouse[first_name]', data.spouse.first_name);
        setFieldValue('spouse[middle_initial]', data.spouse.middle_initial);
        setFieldValue('spouse[is_public_official]', data.spouse.is_public_official);
        setFieldValue('spouse[position]', data.spouse.position);
        setFieldValue('spouse[agency_office]', data.spouse.agency_office);
    }
    
    // Children
    if (data.children_below_18 && Array.isArray(data.children_below_18)) {
        data.children_below_18.forEach((child, index) => {
            addChild();
            setFieldValue(`children_below_18[${index}][name]`, child.name);
            setFieldValue(`children_below_18[${index}][age]`, child.age);
        });
    }
    
    // Real Properties
    if (data.assets?.real_properties && Array.isArray(data.assets.real_properties)) {
        data.assets.real_properties.forEach((prop, index) => {
            addRealProperty();
            setFieldValue(`assets[real_properties][${index}][description]`, prop.description);
            setFieldValue(`assets[real_properties][${index}][kind]`, prop.kind);
            setFieldValue(`assets[real_properties][${index}][exact_location]`, prop.exact_location);
            setFieldValue(`assets[real_properties][${index}][assessed_value]`, prop.assessed_value);
            setFieldValue(`assets[real_properties][${index}][fair_market_value]`, prop.fair_market_value);
            
            if (prop.acquisition) {
                setFieldValue(`assets[real_properties][${index}][acquisition][year]`, prop.acquisition.year);
                setFieldValue(`assets[real_properties][${index}][acquisition][mode]`, prop.acquisition.mode);
                setFieldValue(`assets[real_properties][${index}][acquisition][cost]`, prop.acquisition.cost);
            }
        });
    }
    
    // Personal Properties
    if (data.assets?.personal_properties && Array.isArray(data.assets.personal_properties)) {
        data.assets.personal_properties.forEach((prop, index) => {
            addPersonalProperty();
            setFieldValue(`assets[personal_properties][${index}][description]`, prop.description);
            setFieldValue(`assets[personal_properties][${index}][acquisition_year]`, prop.acquisition_year);
            setFieldValue(`assets[personal_properties][${index}][acquisition_cost]`, prop.acquisition_cost);
        });
    }
    
    // Liabilities
    if (data.liabilities && Array.isArray(data.liabilities)) {
        data.liabilities.forEach((liability, index) => {
            addLiability();
            setFieldValue(`liabilities[${index}][nature]`, liability.nature);
            setFieldValue(`liabilities[${index}][creditor_name]`, liability.creditor_name);
            setFieldValue(`liabilities[${index}][outstanding_balance]`, liability.outstanding_balance);
        });
    }
    
    // Business Interests
    if (data.business_interests) {
        const hasBusiness = data.business_interests.has_business_interest;
        const hasBusinessCheckbox = document.querySelector('[name="business_interests[has_business_interest]"]');
        if (hasBusinessCheckbox && hasBusiness) {
            hasBusinessCheckbox.checked = true;
            toggleBusinessFields(hasBusinessCheckbox);
            
            if (data.business_interests.entries && Array.isArray(data.business_interests.entries)) {
                data.business_interests.entries.forEach((business, index) => {
                    addBusiness();
                    setFieldValue(`business_interests[entries][${index}][entity_name]`, business.entity_name);
                    setFieldValue(`business_interests[entries][${index}][business_address]`, business.business_address);
                    setFieldValue(`business_interests[entries][${index}][nature_of_interest]`, business.nature_of_interest);
                    setFieldValue(`business_interests[entries][${index}][date_acquired]`, business.date_acquired);
                });
            }
        }
    }
    
    // Relatives in Government
    if (data.relatives_in_government) {
        const hasRelatives = data.relatives_in_government.has_relatives;
        const hasRelativesCheckbox = document.querySelector('[name="relatives_in_government[has_relatives]"]');
        if (hasRelativesCheckbox && hasRelatives) {
            hasRelativesCheckbox.checked = true;
            toggleRelativesFields(hasRelativesCheckbox);
            
            if (data.relatives_in_government.entries && Array.isArray(data.relatives_in_government.entries)) {
                data.relatives_in_government.entries.forEach((relative, index) => {
                    addRelative();
                    setFieldValue(`relatives_in_government[entries][${index}][relative_name]`, relative.relative_name);
                    setFieldValue(`relatives_in_government[entries][${index}][relationship]`, relative.relationship);
                    setFieldValue(`relatives_in_government[entries][${index}][position]`, relative.position);
                    setFieldValue(`relatives_in_government[entries][${index}][agency_office]`, relative.agency_office);
                });
            }
        }
    }
    
    // Certification
    if (data.certification) {
        setFieldValue('certification[date_signed]', data.certification.date_signed);
        setFieldValue('certification[authorization_to_verify]', data.certification.authorization_to_verify);
    }
    
    console.log('Form data loaded successfully');
}

// Load existing form data if available
@if($form && $form->form_data)
    const existingData = @json($form->form_data);
    // Delay loading to ensure all DOM elements are ready
    setTimeout(() => {
        populateForm(existingData);
        document.getElementById('last-saved-time').textContent = new Date('{{ $form->updated_at }}').toLocaleString();
    }, 100);
@endif
</script>
@endsection
@endsection
