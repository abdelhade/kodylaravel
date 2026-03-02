@extends('dashboard.layout')

@section('content')
<div class="container-fluid p-2">
    <h4 class="font-thin text-md text-white text-center"
        style="font-size:2em;padding:15px;background: linear-gradient(135deg, #26a69a 0%, #00897b 100%);border-radius: 10px 10px 0 0;margin:0;">
        تقرير المشتريات حسب المورد
    </h4>

    <div class="card" style="border-radius: 0 0 10px 10px;box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('purchases.reports.suppliers') }}" class="mb-4">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label>من</label>
                        <input type="date" name="from_date" class="form-control" value="{{ $from_date }}">
                    </div>
                    <div class="col-md-3">
                        <label>إلى</label>
                        <input type="date" name="to_date" class="form-control" value="{{ $to_date }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> بحث
                        </button>
                    </div>
                    <div class="col-md-4 text-left">
                        <button type="button" onclick="window.print()" class="btn btn-success">
                            <i class="fas fa-print"></i> طباعة
                        </button>
                        <a href="{{ route('purchases.reports.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> رجوع
                        </a>
                    </div>
                </div>
            </form>

            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-truck"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">عدد الفواتير</span>
                            <span class="info-box-number">{{ $totals['invoice_count'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">الإجمالي</span>
                            <span class="info-box-number">{{ number_format($totals['total_amount'], 2) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">الخصم</span>
                            <span class="info-box-number">{{ number_format($totals['total_discount'], 2) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">الصافي</span>
                            <span class="info-box-number">{{ number_format($totals['total_net'], 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" style="background: white;">
                    <thead style="background: linear-gradient(135deg, #26a69a 0%, #00897b 100%);color: white;">
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th width="30%">اسم المورد</th>
                            <th width="13%" class="text-center">عدد الفواتير</th>
                            <th width="13%" class="text-center">الإجمالي</th>
                            <th width="13%" class="text-center">الخصم</th>
                            <th width="13%" class="text-center">الصافي</th>
                            <th width="13%" class="text-center">متوسط الفاتورة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $index => $supplier)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ trim($supplier->supplier_name) ?: 'غير محدد' }}</td>
                                <td class="text-center">{{ $supplier->invoice_count }}</td>
                                <td class="text-center">{{ number_format($supplier->total_amount, 2) }}</td>
                                <td class="text-center" style="color: #d32f2f;">{{ number_format($supplier->total_discount, 2) }}</td>
                                <td class="text-center font-weight-bold" style="color: #00897b;">{{ number_format($supplier->total_net, 2) }}</td>
                                <td class="text-center">{{ number_format($supplier->total_net / $supplier->invoice_count, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4" style="color: #999;">
                                    <i class="fas fa-inbox" style="font-size: 2em;"></i><br>
                                    لا توجد بيانات في هذه الفترة
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, form, .info-box-icon { display: none !important; }
}
</style>
@endsection
