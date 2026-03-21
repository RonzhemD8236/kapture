{{-- resources/views/emails/order_status.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Update — Kapture</title>
</head>
<body style="margin:0;padding:0;background-color:#04030a;font-family:'Helvetica Neue',Arial,sans-serif;color:#ede8f5;-webkit-font-smoothing:antialiased;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#04030a;">
    <tr>
        <td align="center" style="padding:40px 16px;">

            {{-- ══════════════════════════════════════
                 BRAND HEADER
            ══════════════════════════════════════ --}}
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;">
                <tr>
                    <td align="center" style="padding-bottom:24px;border-bottom:1px solid rgba(201,168,76,0.25);margin-bottom:32px;">
                        <div style="height:32px;"></div>
                        {{-- KAPTURE wordmark --}}
                        <p style="margin:0;font-family:Georgia,'Times New Roman',serif;font-size:22px;font-weight:700;letter-spacing:12px;color:#e6c87a;text-transform:uppercase;text-decoration:none;">
                            K A P T U R E
                        </p>
                        <p style="margin:6px 0 0;font-size:8px;letter-spacing:6px;color:#c9a84c;text-transform:uppercase;font-weight:300;">
                            PREMIUM PHOTOGRAPHY
                        </p>
                        <div style="height:24px;"></div>
                        {{-- Gold rule --}}
                        <table width="80" cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
                            <tr><td style="height:1px;background:linear-gradient(90deg,transparent,#c9a84c,transparent);background-color:#c9a84c;"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>

            <div style="height:32px;"></div>

            {{-- ══════════════════════════════════════
                 MAIN CARD
            ══════════════════════════════════════ --}}
            <table width="600" cellpadding="0" cellspacing="0" border="0"
                   style="max-width:600px;background-color:#0f0d22;border:1px solid rgba(168,155,194,0.15);position:relative;">

                {{-- Gold top accent line --}}
                <tr>
                    <td style="height:2px;background-color:#c9a84c;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                </tr>

                <tr>
                    <td style="padding:48px 52px 44px;">

                        {{-- ── Status Icon ── --}}
                        @php
                            $statusKey = strtolower($order->status ?? 'pending');

                            $svgIcons = [
                                'pending' => '
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                    </svg>',
                                'processing' => '
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                                    </svg>',
                                'shipped' => '
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v3"/><rect x="9" y="11" width="14" height="10" rx="1"/><circle cx="12" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                    </svg>',
                                'delivered' => '
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>',
                                'cancelled' => '
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c06060" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                                    </svg>',
                            ];

                            $svgIcon = $svgIcons[$statusKey] ?? $svgIcons['pending'];

                            $iconBorderColor = $statusKey === 'cancelled' ? 'rgba(192,80,80,0.4)' : 'rgba(201,168,76,0.35)';
                            $iconBgColor     = $statusKey === 'cancelled' ? 'rgba(192,80,80,0.06)' : 'rgba(201,168,76,0.06)';

                            $titles = [
                                'pending'    => 'Order Received',
                                'processing' => 'Order Processing',
                                'shipped'    => 'Order Shipped',
                                'delivered'  => 'Order Delivered',
                                'cancelled'  => 'Order Cancelled',
                            ];
                            $subtitles = [
                                'pending'    => 'We have received your order and will begin processing shortly.',
                                'processing' => 'Your order is being carefully prepared by our team.',
                                'shipped'    => 'Your order is on its way to you.',
                                'delivered'  => 'Your order has been successfully delivered.',
                                'cancelled'  => 'Your order has been cancelled. Please contact us for assistance.',
                            ];

                            $badgeColors = [
                                'pending'    => ['bg' => 'rgba(107,100,128,0.25)', 'color' => '#b8aece', 'border' => 'rgba(107,100,128,0.4)'],
                                'processing' => ['bg' => 'rgba(90,61,138,0.3)',    'color' => '#c4a8f0', 'border' => 'rgba(90,61,138,0.5)'],
                                'shipped'    => ['bg' => 'rgba(201,168,76,0.12)',   'color' => '#e6c87a', 'border' => 'rgba(201,168,76,0.4)'],
                                'delivered'  => ['bg' => 'rgba(50,160,100,0.15)',   'color' => '#7ed4a8', 'border' => 'rgba(50,160,100,0.35)'],
                                'cancelled'  => ['bg' => 'rgba(192,80,80,0.15)',    'color' => '#e09090', 'border' => 'rgba(192,80,80,0.4)'],
                            ];

                            $badge  = $badgeColors[$statusKey] ?? $badgeColors['pending'];
                            $title  = $titles[$statusKey]    ?? 'Order Update';
                            $subtitle = $subtitles[$statusKey] ?? 'Your order status has been updated.';
                        @endphp

                        {{-- Icon circle --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" style="padding-bottom:24px;">
                                    <table cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            @if($statusKey === 'cancelled')
                                            <td align="center" valign="middle" style="width:68px;height:68px;border-radius:50%;border:1px solid rgba(192,80,80,0.4);background-color:rgba(192,80,80,0.06);">
                                            @else
                                            <td align="center" valign="middle" style="width:68px;height:68px;border-radius:50%;border:1px solid rgba(201,168,76,0.35);background-color:rgba(201,168,76,0.06);">
                                            @endif
                                                {!! $svgIcon !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            {{-- Title --}}
                            <tr>
                                <td align="center" style="padding-bottom:8px;">
                                    <h1 style="margin:0;font-family:Georgia,'Times New Roman',serif;font-size:28px;font-weight:400;color:#ffffff;letter-spacing:0.02em;line-height:1.2;">
                                        {{ $title }}
                                    </h1>
                                </td>
                            </tr>

                            {{-- Subtitle --}}
                            <tr>
                                <td align="center" style="padding-bottom:28px;">
                                    <p style="margin:0;font-size:11px;font-style:italic;color:rgba(212,207,224,0.45);letter-spacing:0.04em;line-height:1.6;">
                                        {{ $subtitle }}
                                    </p>
                                </td>
                            </tr>
                        </table>

                        {{-- Divider --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:28px;">
                            <tr><td style="height:1px;background-color:rgba(168,155,194,0.12);font-size:0;line-height:0;">&nbsp;</td></tr>
                        </table>

                        {{-- Greeting --}}
                        <p style="margin:0 0 6px;font-size:12px;line-height:1.9;color:rgba(212,207,224,0.7);text-align:center;letter-spacing:0.02em;">
                            Dear <strong style="color:#ede8f5;">{{ $customer->fname ?? 'Valued Customer' }}</strong>,
                        </p>
                        <p style="margin:0 0 28px;font-size:12px;line-height:1.9;color:rgba(212,207,224,0.7);text-align:center;letter-spacing:0.02em;">
                            This is a confirmation that the status of your order
                            <strong style="color:#e6c87a;letter-spacing:0.05em;">#{{ str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}</strong>
                            has been updated.
                        </p>

                        {{-- Status Badge --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px;">
                            <tr>
                                <td align="center">
                                    @if($statusKey === 'processing')
                                    <span style="display:inline-block;padding:7px 22px;font-size:9px;font-weight:700;letter-spacing:0.28em;text-transform:uppercase;background-color:rgba(90,61,138,0.3);color:#c4a8f0;border:1px solid rgba(90,61,138,0.5);border-radius:2px;">
                                    @elseif($statusKey === 'shipped')
                                    <span style="display:inline-block;padding:7px 22px;font-size:9px;font-weight:700;letter-spacing:0.28em;text-transform:uppercase;background-color:rgba(201,168,76,0.12);color:#e6c87a;border:1px solid rgba(201,168,76,0.4);border-radius:2px;">
                                    @elseif($statusKey === 'delivered')
                                    <span style="display:inline-block;padding:7px 22px;font-size:9px;font-weight:700;letter-spacing:0.28em;text-transform:uppercase;background-color:rgba(50,160,100,0.15);color:#7ed4a8;border:1px solid rgba(50,160,100,0.35);border-radius:2px;">
                                    @elseif($statusKey === 'cancelled')
                                    <span style="display:inline-block;padding:7px 22px;font-size:9px;font-weight:700;letter-spacing:0.28em;text-transform:uppercase;background-color:rgba(192,80,80,0.15);color:#e09090;border:1px solid rgba(192,80,80,0.4);border-radius:2px;">
                                    @else
                                    <span style="display:inline-block;padding:7px 22px;font-size:9px;font-weight:700;letter-spacing:0.28em;text-transform:uppercase;background-color:rgba(107,100,128,0.25);color:#b8aece;border:1px solid rgba(107,100,128,0.4);border-radius:2px;">
                                    @endif
                                        {{ ucfirst($order->status ?? 'Pending') }}
                                    </span>
                                </td>
                            </tr>
                        </table>

                        {{-- Divider --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:28px;">
                            <tr><td style="height:1px;background-color:rgba(168,155,194,0.12);font-size:0;line-height:0;">&nbsp;</td></tr>
                        </table>

                        {{-- ── Order Items Table ── --}}
                        @if($orderItems && $orderItems->count())
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:28px;">

                            {{-- Table header --}}
                            <tr style="border-bottom:1px solid rgba(168,155,194,0.15);">
                                <td style="padding:0 0 10px;font-size:8px;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:rgba(107,100,128,0.9);">
                                    Item
                                </td>
                                <td align="center" style="padding:0 0 10px;font-size:8px;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:rgba(107,100,128,0.9);">
                                    Qty
                                </td>
                                <td align="right" style="padding:0 0 10px;font-size:8px;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:rgba(107,100,128,0.9);">
                                    Price
                                </td>
                            </tr>

                            {{-- Spacer after header --}}
                            <tr><td colspan="3" style="height:4px;font-size:0;">&nbsp;</td></tr>

                            @foreach($orderItems as $item)
                            <tr>
                                <td style="padding:9px 0;font-size:11px;color:rgba(212,207,224,0.75);border-bottom:1px solid rgba(168,155,194,0.07);line-height:1.4;">
                                    {{ $item->description }}
                                </td>
                                <td align="center" style="padding:9px 0;font-size:11px;color:rgba(212,207,224,0.5);border-bottom:1px solid rgba(168,155,194,0.07);">
                                    {{ $item->quantity }}
                                </td>
                                <td align="right" style="padding:9px 0;font-size:11px;color:rgba(212,207,224,0.5);border-bottom:1px solid rgba(168,155,194,0.07);">
                                    &#8369;{{ number_format($item->sell_price * $item->quantity, 2) }}
                                </td>
                            </tr>
                            @endforeach

                            {{-- Total row --}}
                            <tr>
                                <td colspan="2" style="padding:14px 0 0;font-size:11px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:#ede8f5;">
                                    Order Total
                                </td>
                                <td align="right" style="padding:14px 0 0;font-family:Georgia,serif;font-size:17px;font-weight:400;color:#c9a84c;">
                                    &#8369;{{ number_format($orderTotal, 2) }}
                                </td>
                            </tr>
                        </table>
                        @endif

                        {{-- ── Order Info Cells ── --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px;">
                            <tr>
                                <td width="50%" valign="top"
                                    style="padding:16px 18px;background-color:rgba(255,255,255,0.025);border:1px solid rgba(168,155,194,0.08);">
                                    <p style="margin:0 0 6px;font-size:8px;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:#c9a84c;">
                                        Order Reference
                                    </p>
                                    <p style="margin:0;font-size:12px;color:rgba(212,207,224,0.7);letter-spacing:0.05em;">
                                        #{{ str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}
                                    </p>
                                </td>
                                <td width="4" style="font-size:0;">&nbsp;</td>
                                <td width="50%" valign="top"
                                    style="padding:16px 18px;background-color:rgba(255,255,255,0.025);border:1px solid rgba(168,155,194,0.08);">
                                    <p style="margin:0 0 6px;font-size:8px;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:#c9a84c;">
                                        Order Date
                                    </p>
                                    <p style="margin:0;font-size:12px;color:rgba(212,207,224,0.7);">
                                        {{ \Carbon\Carbon::parse($order->order_date)->format('F j, Y') }}
                                    </p>
                                </td>
                            </tr>
                        </table>

                        {{-- ── Footer Note ── --}}
                        <p style="margin:0;font-size:10px;font-style:italic;color:rgba(107,100,128,0.6);text-align:center;line-height:1.8;letter-spacing:0.02em;">
                            If you have any questions regarding your order,<br>
                            please don't hesitate to contact our support team.
                        </p>

                    </td>
                </tr>

                {{-- Gold bottom accent --}}
                <tr>
                    <td style="height:1px;background-color:rgba(201,168,76,0.15);font-size:0;line-height:0;">&nbsp;</td>
                </tr>

            </table>

            {{-- ── Email Footer ── --}}
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;">
                <tr>
                    <td align="center" style="padding:28px 0;">
                        <p style="margin:0;font-size:9px;letter-spacing:0.14em;text-transform:uppercase;color:rgba(107,100,128,0.4);">
                            &copy; {{ date('Y') }} Kapture. All rights reserved.
                        </p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>

</body>
</html>