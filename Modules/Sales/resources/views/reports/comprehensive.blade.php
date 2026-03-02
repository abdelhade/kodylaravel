@extends('dashboard.layout')

@section('content')
    <div class="container-fluid p-2">
        <h4 class="font-thin text-md text-white text-center"
            style="font-size:2em;padding:15px;background: linear-gradient(135deg, #26a69a 0%, #00897b 100%);border-radius: 10px 10px 0 0;margin:0;">
            تقرير المبيعات الشامل
        </h4>

        <div class="card" style="border-radius: 0 0 10px 10px;box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div class="card-body p-3">
                <form method="GET" action="{{ route('sales.reports') }}" class="mb-4">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label style="font-weight: 600;color: #00897b;">من</label>
                            <input type="date" name="from" class="form-control" value="{{ $from }}" required>
                        </div>
                        <div class="col-md-4">
                            <label style="font-weight: 600;color: #00897b;">إلى</label>
                            <input type="date" name="to" class="form-control" value="{{ $to }}" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-block"
                                style="background: linear-gradient(135deg, #26a69a 0%, #00897b 100%);border: none;padding: 10px;">
                                <i class="fas fa-search"></i> بحث
                            </button>
                        </div>
                    </div>
                </form>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-center" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);border: none;">
                            <div class="card-body">
                                <h6 style="color: #1976d2;margin-bottom: 5px;">عدد العمليات</h6>
                                <h3 style="color: #0d47a1;margin: 0;">{{ $totals['count'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);border: none;">
                            <div class="card-body">
                                <h6 style="color: #388e3c;margin-bottom: 5px;">الإجمالي</h6>
                                <h3 style="color: #1b5e20;margin: 0;">{{ number_format($totals['total'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center" style="background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);border: none;">
                            <div class="card-body">
                                <h6 style="color: #f57c00;margin-bottom: 5px;">الخصم</h6>
                                <h3 style="color: #e65100;margin: 0;">{{ number_format($totals['discount'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center" style="background: linear-gradient(135deg, #e0f2f1 0%, #b2dfdb 100%);border: none;">
                            <div class="card-body">
                                <h6 style="color: #00897b;margin-bottom: 5px;">الصافي</h6>
                                <h3 style="color: #004d40;margin: 0;font-weight: bold;">{{ number_format($totals['net'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" style="background: white;">
                        <thead style="background: linear-gradient(135deg, #26a69a 0%, #00897b 100%);color: white;">
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                <th width="10%">الوقت و التاريخ</th>
                                <th width="10%">اسم العملية</th>
                                <th width="15%">الحساب</th>
                                <th width="15%">الحساب المقابل</th>
                                <th width="10%" class="text-center">قيمة العملية</th>
                                <th width="10%" class="text-center">الخصم</th>
                                <th width="10%" class="text-center">صافي العملية</th>
                                <th width="10%" class="text-center">الربح</th>
                                <th width="5%" class="text-center">معرفة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($operations as $operation)
                                <tr style="border-bottom: 1px solid #e0e0e0;">
                                    <td class="text-center">{{ $operation->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($operation->pro_date)->format('Y-m-d') }}</td>
                                    <td>
                                        @if($operation->pro_tybe == 3)
                                            <span class="badge badge-success">مبيعات</span>
                                        @elseif($operation->pro_tybe == 9)
                                            <span class="badge badge-info">POS</span>
                                        @elseif($operation->pro_tybe == 11)
                                            <span class="badge badge-warning">مردود مبيعات</span>
                                        @endif
                                    </td>
                                    <td>{{ $operation->account_name ?? '-' }}</td>
                                    <td>{{ $operation->client_name ?? '-' }}</td>
                                    <td class="text-center">{{ number_format($operation->fat_total, 2) }}</td>
                                    <td class="text-center" style="color: #d32f2f;">{{ number_format($operation->fat_disc, 2) }}</td>
                                    <td class="text-center font-weight-bold" style="color: #00897b;">{{ number_format($operation->fat_net, 2) }}</td>
                                    <td class="text-center">0.00</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info" onclick="viewDetails({{ $operation->id }})" title="عرض التفاصيل">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4" style="color: #999;">
                                        <i class="fas fa-inbox" style="font-size: 2em;"></i><br>
                                        لا توجد عمليات في هذه الفترة
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot style="background: #f5f5f5;font-weight: bold;">
                            <tr>
                                <td colspan="5" class="text-left">الإجمالي</td>
                                <td class="text-center">{{ number_format($totals['total'], 2) }}</td>
                                <td class="text-center" style="color: #d32f2f;">{{ number_format($totals['discount'], 2) }}</td>
                                <td class="text-center" style="color: #00897b;">{{ number_format($totals['net'], 2) }}</td>
                                <td class="text-center">0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="text-center mt-3" style="color: #666;">
                    عرض {{ $totals['count'] }} من {{ $totals['count'] }} عملية
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewDetails(id) {
            window.location.href = `/sales/edit/${id}`;
        }
    </script>
@endsection
