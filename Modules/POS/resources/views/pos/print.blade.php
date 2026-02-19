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
            padding: 20px;
            direction: rtl;
        }
        .invoice {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .invoice-info div {
            flex: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .totals {
            text-align: left;
            font-size: 18px;
            font-weight: bold;
        }
        .totals div {
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #333;
        }
        @media print {
            body {
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
        <div class="header">
            <h1>فاتورة مبيعات - POS</h1>
            <p>رقم الفاتورة: {{ $order->id }}</p>
        </div>

        <div class="invoice-info">
            <div>
                <strong>التاريخ:</strong> {{ $order->pro_date }}<br>
                <strong>الوقت:</strong> {{ \Carbon\Carbon::parse($order->crtime)->format('h:i A') }}
            </div>
            <div style="text-align: left;">
                <strong>المستخدم:</strong> {{ $order->user }}
            </div>
        </div>

        @if($order->info)
        <div style="margin-bottom: 20px;">
            <strong>ملاحظات:</strong> {{ $order->info }}
        </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th width="40%">الصنف</th>
                    <th width="15%">الكمية</th>
                    <th width="15%">السعر</th>
                    <th width="20%">الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ number_format($item->quantity, 2) }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div>الإجمالي: {{ number_format($order->fat_total, 2) }} ج.م</div>
            <div>الخصم: {{ number_format($order->fat_disc, 2) }} ج.م</div>
            <div style="font-size: 22px; color: #000;">الصافي: {{ number_format($order->fat_net, 2) }} ج.م</div>
        </div>

        <div class="footer">
            <p>شكراً لتعاملكم معنا</p>
            <p style="font-size: 12px; margin-top: 10px;">تم الطباعة في: {{ now()->format('Y-m-d h:i A') }}</p>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 30px; font-size: 16px; cursor: pointer;">
            طباعة
        </button>
        <button onclick="window.close()" style="padding: 10px 30px; font-size: 16px; cursor: pointer; margin-right: 10px;">
            إغلاق
        </button>
    </div>

    <script>
        // طباعة تلقائية عند فتح الصفحة
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
