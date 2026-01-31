@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body" id="horsReport">
                    <h1>تقرير المبيعات أصناف</h1>

                    <!-- نموذج الفلترة -->
                    <form method="GET" class="row mb-4">
                        <div class="col-md-4">
                            <label>من تاريخ:</label>
                            <input type="date" name="from" class="form-control" value="{{ $from ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <label>إلى تاريخ:</label>
                            <input type="date" name="to" class="form-control" value="{{ $to ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <label style="visibility: hidden;">عرض</label>
                            <button type="submit" class="btn btn-primary btn-block">فلتر</button>
                        </div>
                    </form>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>فلتر الكمية (JS):</label>
                            <select id="qtyFilter" class="form-control">
                                <option value="all">عرض الكل</option>
                                <option value="greater">أكبر من صفر</option>
                                <option value="less">أقل من أو يساوي صفر</option>
                                <option value="equal">يساوي صفر</option>
                            </select>
                        </div>
                    </div>

                    <!-- جدول البيانات -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="myTable" data-page-length="100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الكود</th>
                                    <th>اسم الصنف</th>
                                    <th>ك المبيعات</th>
                                    <th>ق المبيعات</th>
                                    <th>متوسط البيع</th>
                                    <th>س البيع</th>
                                    <th>س ش متوسط</th>
                                    <th>الربح</th>
                                    <th>الربح/ المبيعات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $x = 0; @endphp
                                @foreach($itemsData as $item)
                                    @php $x++; @endphp
                                    <tr>
                                        <td class="text-center">{{ $x }}</td>
                                        <td class="text-center">{{ $item['code'] }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-light btn-block" href="{{ route('items-summary', ['id' => $item['id']]) }}">
                                                {{ $item['iname'] }}
                                            </a>
                                        </td>
                                        <td class="text-center qty">{{ $item['qty'] }}</td>
                                        <td class="text-center val">{{ $item['value'] }}</td>
                                        <td class="text-center price">0</td>
                                        <td class="text-center price1">{{ $item['price1'] }}</td>
                                        <td class="text-center cost_price">{{ $item['cost_price'] }}</td>
                                        <td class="text-center profit">0</td>
                                        <td class="text-center salesprofit">0%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    <!-- يمكن إضافة ملاحظات أو روابط هنا -->
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.price').each(function() {
            var $row = $(this).closest('tr');
            var val = parseFloat($row.find('.val').text()) || 0;
            var qty = parseFloat($row.find('.qty').text()) || 0;
            var costPrice = parseFloat($row.find('.cost_price').text()) || 0;
            var price1 = parseFloat($row.find('.price1').text()) || 0;

            if (qty > 0) {
                var price = val / qty;
                $row.find('.price').text(price.toFixed(2));

                // تغيير لون حسب مقارنة متوسط البيع مع السعر الأساسي
                $row.find('.price').removeClass('bg-red-100 bg-green-100');
                if (price > price1) {
                    $row.find('.price').addClass('bg-green-100'); // ربح
                } else {
                    $row.find('.price').addClass('bg-red-100'); // خسارة
                }

                // حساب الربح
                var profit = (price - costPrice) * qty;
                $row.find('.profit').text(profit.toFixed(2));

                // نسبة الربح إلى المبيعات
                var salesProfit = (val > 0) ? (profit / val) * 100 : 0;
                $row.find('.salesprofit').text(salesProfit.toFixed(2) + '%');
            } else {
                $row.find('.price').text('0');
                $row.find('.profit').text('0');
                $row.find('.salesprofit').text('0%');
            }
        });
    });
</script>
<script>
    $('#qtyFilter').on('change', function() {
        var filter = $(this).val();

        $('#myTable tbody tr').each(function() {
            var qty = parseFloat($(this).find('.qty').text()) || 0;
            var show = true;

            if (filter === 'greater' && qty <= 0) show = false;
            if (filter === 'less' && qty >= 0) show = false;
            if (filter === 'equal' && qty != 0) show = false;

            $(this).toggle(show);
        });
    });
</script>
@endsection
