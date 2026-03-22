@extends('layouts.admin-base')

@section('body')

<style>
    .kapture-page { background: var(--kapture-black); min-height: 100vh; padding: 3rem 2.5rem; font-family: 'Montserrat', sans-serif; color: var(--kapture-text); }

    .page-header { margin-bottom: 3rem; padding-bottom: 2rem; border-bottom: 1px solid var(--kapture-border); }
    .page-eyebrow { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; }
    .page-eyebrow::before, .page-eyebrow::after { content: ''; flex: 0 0 40px; height: 1px; background: var(--kapture-gold); }
    .page-eyebrow span { font-size: 0.85rem; font-weight: 500; letter-spacing: 0.2em; text-transform: uppercase; color: var(--kapture-gold); }
    .page-title { font-family: 'Cormorant Garamond', serif; font-size: 3rem; font-weight: 300; color: #fff; margin: 0; line-height: 1.1; }
    .page-subtitle { font-size: 0.85rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--kapture-muted); margin-top: 0.5rem; font-style: italic; }

    /* Equal height columns */
    .kap-two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: stretch; }

    .kap-panel { border: 1px solid var(--kapture-border-subtle); padding: 2rem; background: rgba(255,255,255,0.01); display: flex; flex-direction: column; }
    .kap-panel-title { font-size: 0.6rem; font-weight: 500; letter-spacing: 0.25em; text-transform: uppercase; color: var(--kapture-gold); margin-bottom: 1.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--kapture-border-subtle); }

    /* Info rows */
    .kap-info-row { display: flex; flex-direction: column; margin-bottom: 1.4rem; }
    .kap-info-label { font-size: 0.58rem; font-weight: 500; letter-spacing: 0.2em; text-transform: uppercase; color: var(--kapture-gold); margin-bottom: 0.3rem; }
    .kap-info-value { font-family: 'Cormorant Garamond', serif; font-size: 1.15rem; color: var(--kapture-text); }

    /* Order items */
    .kap-items-list { flex: 1; }
    .kap-item-row { display: grid; grid-template-columns: 70px 1fr auto auto; gap: 1rem; align-items: center; padding: 1rem 0; border-bottom: 1px solid var(--kapture-border-subtle); }
    .kap-item-img { width: 70px; height: 70px; object-fit: cover; border: 1px solid var(--kapture-border-subtle); display: block; }
    .kap-item-name { font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; color: #fff; }
    .kap-item-price { font-size: 0.85rem; color: var(--kapture-gold-light); text-align: right; white-space: nowrap; }
    .kap-item-qty { font-size: 0.75rem; color: var(--kapture-muted); text-align: right; white-space: nowrap; letter-spacing: 0.05em; }

    /* Bottom section of left panel */
    .kap-bottom { margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--kapture-border); }
    .kap-order-status-row { display: flex; justify-content: space-between; align-items: baseline; padding-bottom: 0.75rem; }
    .kap-order-status-label { font-size: 0.58rem; font-weight: 500; letter-spacing: 0.2em; text-transform: uppercase; color: var(--kapture-gold); }
    .kap-order-status-value { font-family: 'Cormorant Garamond', serif; font-size: 1.15rem; }
    .status-pending    { color: #a89bc2; }
    .status-processing { color: var(--kapture-gold); }
    .status-completed  { color: #7cc47c; }
    .status-cancelled  { color: #c06060; }
    .kap-total-row { display: flex; justify-content: space-between; align-items: center; padding-top: 0.75rem; border-top: 1px solid var(--kapture-border); }
    .kap-total-label { font-size: 0.65rem; font-weight: 500; letter-spacing: 0.2em; text-transform: uppercase; color: var(--kapture-gold); }
    .kap-total-value { font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; color: #fff; }

    /* Right panel stretches content, form pushed to bottom */
    .kap-shipping-content { }
    .kap-form-section { margin-top: auto; padding-top: 1.25rem; border-top: 1px solid var(--kapture-border-subtle); display: flex; flex-direction: column; flex: 1; }
    .kap-form-section form { display: flex; flex-direction: column; flex: 1; }

    .kap-field { margin-bottom: 1.6rem; }
    .kap-label { display: block; font-size: 0.62rem; font-weight: 500; letter-spacing: 0.22em; text-transform: uppercase; color: var(--kapture-gold); margin-bottom: 0.55rem; }
    .kap-select { width: 100%; background: transparent; border: none; border-bottom: 1px solid var(--kapture-border-subtle); color: var(--kapture-text); font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; padding: 0.45rem 0; outline: none; cursor: pointer; transition: border-color 0.3s; appearance: none; -webkit-appearance: none; }
    .kap-select:focus { border-bottom-color: var(--kapture-gold); color: #fff; }
    .kap-select option { background: var(--kapture-deep); color: var(--kapture-text); }

    .kap-btn-row { display: flex; gap: 0.75rem; margin-top: auto; padding-top: 1.75rem; }
    .btn-kap-submit { flex: 1; background: var(--kapture-gold); border: 1px solid var(--kapture-gold); color: var(--kapture-black); font-family: 'Montserrat', sans-serif; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.2em; text-transform: uppercase; padding: 0.8rem; cursor: pointer; transition: all 0.3s; }
    .btn-kap-submit:hover { background: var(--kapture-gold-light); border-color: var(--kapture-gold-light); }
    .btn-kap-back { flex: 1; background: transparent; border: 1px solid var(--kapture-border-subtle); color: var(--kapture-muted); font-family: 'Montserrat', sans-serif; font-size: 0.75rem; letter-spacing: 0.2em; text-transform: uppercase; padding: 0.8rem; text-decoration: none; text-align: center; transition: all 0.3s; display: block; }
    .btn-kap-back:hover { border-color: var(--kapture-muted); color: var(--kapture-text); text-decoration: none; }

    @media (max-width: 768px) { .kap-two-col { grid-template-columns: 1fr; } .kap-item-row { grid-template-columns: 60px 1fr; } }
</style>

<div class="kapture-page">

    <div class="page-header">
        <div class="page-eyebrow"><span>Order Management</span></div>
        <h1 class="page-title">Order #{{ $customer->orderinfo_id }}</h1>
        <p class="page-subtitle">Customer Transaction — Details</p>
    </div>

    <div class="kap-two-col">

        {{-- LEFT: Order Items --}}
        <div class="kap-panel">
            <p class="kap-panel-title">Order Items</p>

            <div class="kap-items-list">
                @foreach ($orders as $order)
                    <div class="kap-item-row">
                        <img class="kap-item-img"
                             src="{{ $order->img_path !== 'default.jpg' ? asset('storage/' . $order->img_path) : asset('images/default.jpg') }}"
                             alt="{{ $order->title ?? $order->description }}">
                        <span class="kap-item-name">{{ $order->title ?? $order->description }}</span>
                        <span class="kap-item-price">₱ {{ number_format($order->sell_price, 2) }}</span>
                        <span class="kap-item-qty">× {{ $order->quantity }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Status below the gold line, above total --}}
            <div class="kap-bottom">
                <div class="kap-order-status-row">
                    <span class="kap-order-status-label">Order Status</span>
                    <span class="kap-order-status-value status-{{ strtolower($customer->status) }}">
                        {{ $customer->status }}
                    </span>
                </div>

                <div class="kap-total-row">
                    <span class="kap-total-label">Order Total</span>
                    <span class="kap-total-value">₱ {{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- RIGHT: Shipping Info + Update Status --}}
        <div class="kap-panel">
            <p class="kap-panel-title">Shipping Information</p>

            <div class="kap-shipping-content">
                <div class="kap-info-row">
                    <span class="kap-info-label">Customer Name</span>
                    <span class="kap-info-value">{{ $customer->lname }}, {{ $customer->fname }}</span>
                </div>

                <div class="kap-info-row">
                    <span class="kap-info-label">Phone</span>
                    <span class="kap-info-value">{{ $customer->phone }}</span>
                </div>

                <div class="kap-info-row">
                    <span class="kap-info-label">Address</span>
                    <span class="kap-info-value">{{ $customer->addressline }}</span>
                </div>
            </div>

            <div class="kap-form-section">
                <form action="{{ route('admin.orderUpdate', $customer->orderinfo_id) }}" method="POST">
                    @csrf

                    <div class="kap-field">
                        <label class="kap-label">New Status</label>
                        <select name="status" class="kap-select">
                        <option value="pending"    {{ $customer->status === 'pending'    ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $customer->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed"  {{ $customer->status === 'completed'  ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled"  {{ $customer->status === 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    </div>

                    <div class="kap-btn-row">
                        <button type="submit" class="btn-kap-submit">
                            <i class="bi bi-check2"></i> Update Status
                        </button>
                        <a href="{{ route('admin.orders') }}" class="btn-kap-back">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection