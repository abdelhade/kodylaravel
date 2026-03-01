<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة رقم {{ $order->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            width: 250px;
            margin: 0 auto;
            padding: 5px;
            font-size: 10px;
            direction: rtl;
            background: white;
        }
        .invoice {
            width: 100%;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .header h1 {
            font-size: 14px;
            margin-bottom: 3px;
            font-weight: bold;
        }
        .header .invoice-number {
            font-size: 11px;
            font-weight: bold;
            margin-top: 3px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 9px;
        }
        .info-row strong {
            font-weight: bold;
        }
        .section-title {
            font-weight: bold;
            font-size: 10px;
            margin: 8px 0 4px 0;
            padding: 3px 0;
            border-bottom: 1px solid #000;
        }
        .customer-info {
            background: #f5f5f5;
            padding: 5px;
            margin: 5px 0;
            border-radius: 3px;
            font-size: 9px;
        }
        .customer-info p {
            margin: 2px 0;
            line-height: 1.3;
        }
        .order-type {
            text-align: center;
            padding: 4px;
            margin: 5px 0;
            font-weight: bold;
            font-size: 10px;
            border: 1px solid #000;
            border-radius: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 9px;
        }
        table th {
            background: #000;
            color: white;
            padding: 4px 2px;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
        }
        table td {
            border-bottom: 1px dotted #ccc;
            padding: 4px 2px;
            text-align: center;
        }
        .item-name {
            text-align: right !important;
            font-weight: bold;
        }
        .totals {
            border-top: 2px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
            font-size: 10px;
        }
        .totals-row.final {
            font-size: 12px;
            font-weight: bold;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 5px 0;
            margin-top: 5px;
        }
        .payment-section {
            background: #f5f5f5;
            padding: 5px;
            margin: 8px 0;
            border: 1px dashed #000;
            font-size: 9px;
        }
        .payment-section h3 {
            font-size: 10px;
            margin-bottom: 4px;
            text-align: center;
        }
        .payment-row {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
            padding-top: 8px;
            border-top: 2px dashed #000;
            font-size: 9px;
        }
        .footer .thank-you {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .barcode {
            text-align: center;
            margin: 8px 0;
            font-family: 'Courier New', monospace;
            font-size: 16px;
            letter-spacing: 2px;
        }
        @media print {
            body {
                width: 250px;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice">
        <!-- Header -->
        <div class="header">
            <h1>فاتورة مبيعات</h1>
            <div class="invoice-number">رقم: {{ $order->id }}</div>
        </div>

        <!-- Date & Time -->
        <div class="info-row">
            <span><strong>التاريخ:</strong> {{ \Carbon\Carbon::parse($order->pro_date)->format('Y-m-d') }}</span>
        </div>
        <div class="info-row">
            <span><strong>الوقت:</strong> {{ \Carbon\Carbon::parse($order->crtime)->format('h:i A') }}</span>
        </div>
        <div class="info-row">
            <span><strong>الكاشير:</strong> {{ $order->user }}</span>
        </div>

        <!-- Order Type -->
        <div class="order-type">
            @if($order->age == 1)
                تيك أواي
            @elseif($order->age == 2)
                طاولة
            @elseif($order->age == 3)
                دليفري
            @else
                نقدي
            @endif
        </div>

        <!-- Customer Info -->
        @php
            $customer = DB::table('acc_head')->where('id', $order->acc1)->first();
            $deliveryInfo = null;
            if ($order->age == 3 && $order->info) {
                preg_match('/ديليفري - (.+?) \| موبايل: (.+?) \| عنوان: (.+?)(?:\||$)/', $order->info, $matches);
                if (count($matches) >= 4) {
                    $deliveryInfo = [
                        'name' => $matches[1],
                        'phone' => $matches[2],
                        'address' => $matches[3]
                    ];
                }
            }
        @endphp
        
        @if($deliveryInfo || $customer)
        <div class="section-title">معلومات العميل</div>
        <div class="customer-info">
            @if($deliveryInfo)
                <p><strong>الاسم:</strong> {{ $deliveryInfo['name'] }}</p>
                <p><strong>موبايل:</strong> {{ $deliveryInfo['phone'] }}</p>
                <p><strong>العنوان:</strong> {{ $deliveryInfo['address'] }}</p>
            @elseif($customer)
                <p><strong>الاسم:</strong> {{ $customer->aname }}</p>
                @if($customer->phone)
                    <p><strong>هاتف:</strong> {{ $customer->phone }}</p>
                @endif
            @endif
        </div>
        @endif

        <!-- Items Table -->
        <div class="section-title">الأصناف</div>
        <table>
            <thead>
                <tr>
                    <th width="40%">الصنف</th>
                    <th width="15%">كمية</th>
                    <th width="20%">سعر</th>
                    <th width="25%">إجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $index => $item)
                <tr>
                    <td class="item-name">{{ $item->item_name }}</td>
                    <td>{{ number_format($item->quantity, 1) }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td><strong>{{ number_format($item->total, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <div class="totals-row">
                <span>الإجمالي:</span>
                <span>{{ number_format($order->fat_total, 2) }} ج.م</span>
            </div>
            @if($order->fat_disc > 0)
            <div class="totals-row">
                <span>الخصم:</span>
                <span>{{ number_format($order->fat_disc, 2) }} ج.م</span>
            </div>
            @endif
            <div class="totals-row final">
                <span>الصافي:</span>
                <span>{{ number_format($order->fat_net, 2) }} ج.م</span>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="payment-section">
            <h3>معلومات الدفع</h3>
            <div class="payment-row">
                <span>المستحق:</span>
                <span><strong>{{ number_format($order->fat_net, 2) }} ج.م</strong></span>
            </div>
            <div class="payment-row">
                <span>طريقة الدفع:</span>
                <span>نقدي</span>
            </div>
            <div class="payment-row">
                <span>الحالة:</span>
                <span><strong>مدفوع</strong></span>
            </div>
        </div>

        <!-- Barcode -->
        <div class="barcode">
            *{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}*
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="thank-you">شكراً لتعاملكم معنا</p>
            <p>نتمنى زيارتكم مرة أخرى</p>
            <p style="margin-top: 5px; font-size: 8px;">
                {{ now()->format('Y-m-d h:i A') }}
            </p>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 15px;">
        <button onclick="window.print()" style="padding: 8px 20px; font-size: 12px; cursor: pointer; background: #000; color: white; border: none; border-radius: 3px; margin-left: 5px;">
            طباعة
        </button>
        <button onclick="window.close()" style="padding: 8px 20px; font-size: 12px; cursor: pointer; background: #666; color: white; border: none; border-radius: 3px;">
            إغلاق
        </button>
    </div>

    <script>
        window.onload = function() {
            // طباعة تلقائية بعد تحميل الصفحة
            setTimeout(function() {
                window.print();
            }, 300);
        }
    </script>
</body>
</html>
