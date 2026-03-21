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
  </style>
</head>
<body>
  <div class="wrap">
    <div class="header">
      <h1>KAPTURE</h1>
      <p>Where Vision Meets Precision</p>
    </div>
    <div class="body">
      <h2>ORDER CONFIRMED</h2>
      <p>Thank you for your order. We are preparing your instruments with the utmost care.</p>
      <p><strong>Order #{{ $order->order_id }}</strong></p>
      <table>
        <thead>
          <tr>
            <th>ITEM</th><th>QTY</th><th>PRICE</th><th>SUBTOTAL</th>
          </tr>
        </thead>
        <tbody>
          @foreach($cart as $item)
          <tr>
            <td>{{ $item['title'] }}</td>
            <td>{{ $item['quantity'] }}</td>
            <td>₱ {{ number_format($item['sell_price'], 2) }}</td>
            <td>₱ {{ number_format($item['sell_price'] * $item['quantity'], 2) }}</td>
          </tr>
          @endforeach
          <tr class="total-row">
            <td colspan="3">TOTAL</td>
            <td>₱ {{ number_format($total, 2) }}</td>
          </tr>
        </tbody>
      </table>
      <p>Your order will be processed within 1–2 business days.</p>

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