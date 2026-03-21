<style>
    .kap-alert {
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        padding: 0.9rem 1.1rem;
        margin-bottom: 1.25rem;
        border-left: 2px solid;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.72rem;
        letter-spacing: 0.06em;
        position: relative;
        animation: kapAlertIn 0.25s ease;
    }

    @keyframes kapAlertIn {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .kap-alert-success {
        background: rgba(50, 160, 100, 0.08);
        border-color: rgba(50, 160, 100, 0.5);
        color: #7ed4a8;
    }

    .kap-alert-error {
        background: rgba(192, 80, 80, 0.08);
        border-color: rgba(192, 80, 80, 0.5);
        color: #e09090;
    }

    .kap-alert-warning {
        background: rgba(201, 168, 76, 0.08);
        border-color: rgba(201, 168, 76, 0.45);
        color: #e6c87a;
    }

    .kap-alert-info {
        background: rgba(90, 61, 138, 0.12);
        border-color: rgba(90, 61, 138, 0.5);
        color: #c4a8f0;
    }

    .kap-alert-icon {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        margin-top: 1px;
        opacity: 0.85;
    }

    .kap-alert-body {
        flex: 1;
        line-height: 1.7;
    }

    .kap-alert-label {
        font-size: 0.58rem;
        font-weight: 700;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        display: block;
        margin-bottom: 2px;
        opacity: 0.7;
    }

    .kap-alert-message {
        font-weight: 400;
        opacity: 0.9;
    }

    .kap-alert-errors {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .kap-alert-close {
        background: none;
        border: none;
        cursor: pointer;
        color: inherit;
        opacity: 0.4;
        padding: 0;
        line-height: 1;
        flex-shrink: 0;
        transition: opacity 0.2s;
        margin-top: 1px;
    }

    .kap-alert-close:hover { opacity: 0.9; }
</style>

{{-- ── Success ── --}}
@if ($message = Session::get('success'))
<div class="kap-alert kap-alert-success" role="alert">
    <span class="kap-alert-icon">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
        </svg>
    </span>
    <div class="kap-alert-body">
        <span class="kap-alert-label">Success</span>
        <span class="kap-alert-message">{{ $message }}</span>
    </div>
    <button class="kap-alert-close" data-bs-dismiss="alert" aria-label="Close">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif

{{-- ── Error ── --}}
@if ($message = Session::get('error'))
<div class="kap-alert kap-alert-error" role="alert">
    <span class="kap-alert-icon">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
        </svg>
    </span>
    <div class="kap-alert-body">
        <span class="kap-alert-label">Error</span>
        <span class="kap-alert-message">{{ $message }}</span>
    </div>
    <button class="kap-alert-close" data-bs-dismiss="alert" aria-label="Close">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif

{{-- ── Warning ── --}}
@if ($message = Session::get('warning'))
<div class="kap-alert kap-alert-warning" role="alert">
    <span class="kap-alert-icon">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
        </svg>
    </span>
    <div class="kap-alert-body">
        <span class="kap-alert-label">Warning</span>
        <span class="kap-alert-message">{{ $message }}</span>
    </div>
    <button class="kap-alert-close" data-bs-dismiss="alert" aria-label="Close">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif

{{-- ── Info ── --}}
@if ($message = Session::get('info'))
<div class="kap-alert kap-alert-info" role="alert">
    <span class="kap-alert-icon">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
        </svg>
    </span>
    <div class="kap-alert-body">
        <span class="kap-alert-label">Info</span>
        <span class="kap-alert-message">{{ $message }}</span>
    </div>
    <button class="kap-alert-close" data-bs-dismiss="alert" aria-label="Close">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif

{{-- ── Validation Errors ── --}}
@if ($errors->any())
<div class="kap-alert kap-alert-error" role="alert">
    <span class="kap-alert-icon">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
        </svg>
    </span>
    <div class="kap-alert-body">
        <span class="kap-alert-label">Please fix the following</span>
        <span class="kap-alert-errors">
            @foreach ($errors->all() as $message)
                <span class="kap-alert-message">{{ $message }}</span>
            @endforeach
        </span>
    </div>
    <button class="kap-alert-close" data-bs-dismiss="alert" aria-label="Close">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif