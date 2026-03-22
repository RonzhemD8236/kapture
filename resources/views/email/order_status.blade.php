<!DOCTYPE html>
<html>
<head>
  <style>
    body { font-family:Georgia,serif; background:#f5f5f5; margin:0; padding:0; }
    .wrap { max-width:600px; margin:40px auto; background:#fff; border:1px solid #e0e0e0; }
    .header { background:#04030a; padding:40px; text-align:center; }
    .header h1 { color:#c9a84c; letter-spacing:12px; font-size:28px; margin:0; }
    .header p { color:#b8aece; font-style:italic; font-size:13px; margin:8px 0 0; }
    .body { padding:40px; }
    .body h2 { font-size:16px; color:#120820; letter-spacing:2px; }
    .body p { color:#555; font-size:13px; line-height:1.8; }
    table { width:100%; border-collapse:collapse; margin:24px 0; }
    th { font-size:10px; letter-spacing:2px; color:#6b5f7c; padding:8px 12px; border-bottom:2px solid #eee; text-align:left; }
    td { padding:12px; border-bottom:1px solid #f0f0f0; font-size:13px; color:#333; }
    .total-row td { font-weight:bold; color:#120820; border-top:2px solid #eee; }
    .footer { background:#04030a; padding:24px 40px; text-align:center; }
    .footer p { color:#6b5f7c; font-size:10px; letter-spacing:2px; margin:0; }

    .tracker { display:flex; justify-content:space-between; align-items:center; margin:28px 0; padding:20px; background:#f9f9f9; border:1px solid #eee; }
    .step { text-align:center; font-size:9px; letter-spacing:2px; flex:1; }
    .step-circle { width:28px; height:28px; border-radius:50%; margin:0 auto 8px; display:flex; align-items:center; justify-content:center; font-size:11px; }
    .step-active  .step-circle { background:#04030a; color:#c9a84c; border:1px solid #c9a84c; }
    .step-done    .step-circle { background:#c9a84c; color:#04030a; }
    .step-pending .step-circle { background:#f0f0f0; color:#aaa; border:1px solid #ddd; }
    .step-active  .step-label { color:#120820; font-weight:bold; }
    .step-done    .step-label { color:#c9a84c; }
    .step-pending .step-label { color:#bbb; }
    .step-line      { flex:0.5; height:1px; background:#eee; margin-bottom:20px; }
    .step-line-done { background:#c9a84c; }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="header">
      <h1>KAPTURE</h1>
      <p>Where Vision Meets Precision</p>
    </div>
    <div class="body">

      @php $status = strtolower($order->status ?? 'pending'); @endphp

      @if($status === 'pending')
        <h2>ORDER RECEIVED</h2>
        <p>Thank you for your order. We have received it and are preparing to process your instruments.</p>
      @elseif($status === 'processing')
        <h2>ORDER IN PROGRESS</h2>
        <p>Your order is currently being processed. We are carefully preparing your instruments.</p>
      @elseif($status === 'completed')
        <h2>ORDER COMPLETED</h2>
        <p>Your order has been completed. Thank you for choosing Kapture — we hope your instruments serve you well.</p>
      @elseif($status === 'cancelled')
        <h2>ORDER CANCELLED</h2>
        <p>Your order has been cancelled. If you have any questions, please contact our support team.</p>
      @endif

      {{-- PROGRESS TRACKER (hidden if cancelled) --}}
      @if($status !== 'cancelled')
        @php
          $steps = ['pending', 'processing', 'completed'];
          $currentIndex = array_search($status, $steps);
          if ($currentIndex === false) $currentIndex = 0;
        @endphp
        <div class="tracker">
          @foreach($steps as $i => $step)
            @if($i > 0)
              <div class="step-line {{ $i <= $currentIndex ? 'step-line-done' : '' }}"></div>
            @endif
            <div class="step {{ $i < $currentIndex ? 'step-done' : ($i === $currentIndex ? 'step-active' : 'step-pending') }}">
              <div class="step-circle">
                @if($i < $currentIndex) ✓ @else {{ $i + 1 }} @endif
              </div>
              <div class="step-label">{{ strtoupper($step) }}</div>
            </div>
          @endforeach
        </div>
      @endif

      <p><strong>Order #{{ $order->order_id }}</strong></p>

      {{-- ORDER TABLE --}}
      <table>
        <thead>
          <tr>
            <th>ITEM</th><th>QTY</th><th>PRICE</th><th>SUBTOTAL</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orderItems as $item)
          <tr>
            <td>{{ $item->title ?? $item->description }}</td>
            <td>{{ $item->quantity }}</td>
            <td>₱ {{ number_format($item->sell_price, 2) }}</td>
            <td>₱ {{ number_format($item->sell_price * $item->quantity, 2) }}</td>
          </tr>
          @endforeach
          <tr class="total-row">
            <td colspan="3">TOTAL</td>
            <td>₱ {{ number_format($orderTotal, 2) }}</td>
          </tr>
        </tbody>
      </table>

      @if($status !== 'cancelled')
        <p>Your order will be processed within 1–2 business days.</p>
      @endif

      {{-- DOWNLOAD RECEIPT BUTTON --}}
      <div style="text-align:center; margin:32px 0;">
        <a href="{{ url('/customer/receipt/' . $order->order_id) }}"
           style="font-family:Georgia,serif; font-size:10px; letter-spacing:4px; color:#c9a84c; border:1px solid #c9a84c; padding:14px 32px; text-decoration:none; background:#04030a; display:inline-block;">
          DOWNLOAD RECEIPT
        </a>
      </div>

    </div>
    <div class="footer">
      <p>© {{ date('Y') }} KAPTURE ATELIER — BGC, MANILA</p>
    </div>
  </div>
</body>
</html>