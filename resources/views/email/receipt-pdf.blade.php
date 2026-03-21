<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: Georgia, serif;
    background: #04030a;
    color: #ede8f5;
    padding: 0;
  }

  /* PAGE BACKGROUND */
  .page {
    background: #04030a;
    min-height: 100vh;
    padding: 48px 52px;
    position: relative;
  }

  /* CORNER ACCENTS */
  .corner { position: absolute; width: 32px; height: 32px; }
  .corner-tl { top: 24px; left: 24px; border-top: 1px solid #c9a84c; border-left: 1px solid #c9a84c; }
  .corner-tr { top: 24px; right: 24px; border-top: 1px solid #c9a84c; border-right: 1px solid #c9a84c; }
  .corner-bl { bottom: 24px; left: 24px; border-bottom: 1px solid #c9a84c; border-left: 1px solid #c9a84c; }
  .corner-br { bottom: 24px; right: 24px; border-bottom: 1px solid #c9a84c; border-right: 1px solid #c9a84c; }

  /* HEADER */
  .header { text-align: center; padding-bottom: 32px; margin-bottom: 32px; border-bottom: 1px solid #2a0e50; }
  .brand { font-size: 36px; letter-spacing: 14px; color: #c9a84c; font-family: Georgia, serif; font-weight: normal; }
  .brand-sub { font-size: 10px; letter-spacing: 5px; color: #6b5f7c; margin-top: 6px; font-style: italic; }
  .receipt-label {
    display: inline-block;
    margin-top: 20px;
    font-size: 9px;
    letter-spacing: 6px;
    color: #9333ea;
    border: 1px solid #2a0e50;
    padding: 6px 20px;
    background: rgba(42,14,80,0.3);
  }

  /* GOLD DIVIDER */
  .divider {
    height: 1px;
    background: linear-gradient(to right, transparent, #c9a84c, transparent);
    margin: 28px 0;
  }
  .divider-thin {
    height: 1px;
    background: #2a0e50;
    margin: 20px 0;
  }

  /* SECTION TITLE */
  .section-title {
    font-size: 9px;
    letter-spacing: 5px;
    color: #c9a84c;
    margin-bottom: 14px;
    padding-bottom: 8px;
    border-bottom: 1px solid #2a0e50;
  }

  /* INFO GRID */
  .info-grid { width: 100%; margin-bottom: 8px; }
  .info-grid td { font-size: 11px; padding: 5px 0; vertical-align: top; }
  .info-label { color: #6b5f7c; letter-spacing: 1px; width: 40%; }
  .info-value { color: #ede8f5; text-align: right; }

  /* TWO COLUMN LAYOUT */
  .two-col { width: 100%; margin-bottom: 28px; }
  .two-col td { width: 50%; vertical-align: top; padding-right: 24px; }
  .two-col td:last-child { padding-right: 0; padding-left: 24px; border-left: 1px solid #2a0e50; }

  /* ITEMS TABLE */
  .items-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
  .items-table thead tr { border-bottom: 1px solid #2a0e50; }
  .items-table th {
    font-size: 8px;
    letter-spacing: 3px;
    color: #6b5f7c;
    padding: 10px 8px;
    text-align: left;
    font-weight: normal;
  }
  .items-table th:last-child { text-align: right; }
  .items-table td {
    padding: 12px 8px;
    font-size: 11px;
    color: #b8aece;
    border-bottom: 1px solid rgba(42,14,80,0.5);
    vertical-align: top;
  }
  .items-table td:last-child { text-align: right; color: #ede8f5; }
  .items-table .item-name { color: #ede8f5; font-size: 12px; }
  .items-table .item-price { color: #b8aece; font-size: 10px; }

  /* TOTAL BLOCK */
  .total-block {
    margin-top: 20px;
    border: 1px solid #2a0e50;
    background: rgba(42,14,80,0.2);
    padding: 16px 20px;
  }
  .total-row-inner { width: 100%; }
  .total-row-inner td { padding: 5px 0; font-size: 11px; }
  .total-row-inner .label { color: #6b5f7c; letter-spacing: 1px; }
  .total-row-inner .value { text-align: right; color: #b8aece; }
  .grand-total td { padding-top: 12px !important; border-top: 1px solid #2a0e50; margin-top: 8px; }
  .grand-total .label { font-size: 10px; letter-spacing: 3px; color: #c9a84c; }
  .grand-total .value { font-size: 16px; color: #c9a84c; font-family: Georgia, serif; }

  /* STATUS BADGE */
  .status-badge {
    display: inline-block;
    font-size: 8px;
    letter-spacing: 3px;
    padding: 4px 12px;
    border: 1px solid #5b1a8a;
    color: #9333ea;
    background: rgba(91,26,138,0.15);
  }

  /* FOOTER */
  .footer {
    text-align: center;
    margin-top: 40px;
    padding-top: 24px;
    border-top: 1px solid #2a0e50;
  }
  .footer p { font-size: 9px; letter-spacing: 3px; color: #6b5f7c; margin-bottom: 6px; }
  .footer .tagline { font-style: italic; font-size: 10px; color: #2a0e50; letter-spacing: 2px; }
</style>
</head>
<body>
<div class="page">

  <!-- Corner accents -->
  <div class="corner corner-tl"></div>
  <div class="corner corner-tr"></div>
  <div class="corner corner-bl"></div>
  <div class="corner corner-br"></div>

  <!-- HEADER -->
  <div class="header">
    <div class="brand">KAPTURE</div>
    <div class="brand-sub">Where Vision Meets Precision</div>
    <div class="receipt-label">OFFICIAL RECEIPT</div>
  </div>

  <!-- ORDER + CUSTOMER INFO -->
  <table class="two-col">
    <tr>
      <!-- Order Details -->
      <td>
        <div class="section-title">ORDER DETAILS</div>
        <table class="info-grid">
          <tr>
            <td class="info-label">ORDER NO.</td>
            <td class="info-value" style="color:#c9a84c;">#{{ str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}</td>
          </tr>
          <tr>
            <td class="info-label">DATE</td>
            <td class="info-value">{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</td>
          </tr>
          <tr>
            <td class="info-label">STATUS</td>
            <td class="info-value"><span class="status-badge">{{ strtoupper($order->status) }}</span></td>
          </tr>
          <tr>
            <td class="info-label">PAYMENT</td>
            <td class="info-value">{{ strtoupper($order->payment_method ?? 'COD') }}</td>
          </tr>
        </table>
      </td>

      <!-- Customer Details -->
      <td>
        <div class="section-title">CUSTOMER DETAILS</div>
        <table class="info-grid">
          <tr>
            <td class="info-label">NAME</td>
            <td class="info-value">{{ $customer->fname }} {{ $customer->lname }}</td>
          </tr>
          <tr>
            <td class="info-label">PHONE</td>
            <td class="info-value">{{ $customer->phone ?? '—' }}</td>
          </tr>
          <tr>
            <td class="info-label">ADDRESS</td>
            <td class="info-value">{{ $customer->addressline ?? '—' }}</td>
          </tr>
          <tr>
            <td class="info-label">TOWN</td>
            <td class="info-value">{{ $customer->town ?? '—' }}, {{ $customer->zipcode ?? '' }}</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <div class="divider"></div>

  <!-- ITEMS -->
  <div class="section-title">ITEMS ORDERED</div>
  <table class="items-table">
    <thead>
      <tr>
        <th style="width:45%">ITEM</th>
        <th style="width:15%; text-align:center;">QTY</th>
        <th style="width:20%; text-align:right;">UNIT PRICE</th>
        <th style="width:20%">SUBTOTAL</th>
      </tr>
    </thead>
    <tbody>
      @foreach($cart as $item)
      <tr>
        <td class="item-name">{{ $item['title'] }}</td>
        <td style="text-align:center; color:#9333ea;">{{ $item['quantity'] }}</td>
        <td style="text-align:right;">PHP {{ number_format($item['sell_price'], 2) }}</td>
        <td>PHP {{ number_format($item['sell_price'] * $item['quantity'], 2) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <!-- TOTAL -->
  <div class="total-block">
    <table class="total-row-inner">
      <tr>
        <td class="label">SUBTOTAL</td>
        <td class="value">PHP {{ number_format($total, 2) }}</td>
      </tr>
      <tr>
        <td class="label">SHIPPING</td>
        <td class="value">FREE</td>
      </tr>
      <tr class="grand-total">
        <td class="label">TOTAL AMOUNT</td>
        <td class="value">PHP {{ number_format($total, 2) }}</td>
      </tr>
    </table>
  </div>

  <div class="divider"></div>

  <!-- FOOTER -->
  <div class="footer">
    <p>THANK YOU FOR YOUR ORDER</p>
    <p>YOUR INSTRUMENTS ARE BEING PREPARED WITH THE UTMOST CARE</p>
    <p style="margin-top:12px;">© {{ date('Y') }} KAPTURE ATELIER &mdash; BGC, MANILA</p>
    <p class="tagline">Where Vision Meets Precision</p>
  </div>

</div>
</body>
</html>