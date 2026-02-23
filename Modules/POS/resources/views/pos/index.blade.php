@extends('dashboard.layout')

@section('content')

<style>
    .table thead th {
        vertical-align: middle;
        font-size: 14px;
        background: linear-gradient(45deg, #4e73df, #224abe);
        color: #fff;
    }

    .table tbody td {
        vertical-align: middle;
        font-size: 13px;
    }

    .badge {
        font-size: 12px;
        padding: 6px 10px;
    }

    .table-hover tbody tr:hover {
        background-color: #f2f6fc;
        transition: 0.3s;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">

            <div class="card shadow">
                <div class="card-header bg-white">
                    <h4 class="mb-0 font-weight-bold text-primary">
                        طلبات نقاط البيع (POS)
                    </h4>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>رقم الطلب</th>
                                    <th>التاريخ</th>
                                    <th>الإجمالي</th>
                                    <th>الخصم</th>
                                    <th>الصافي</th>
                                    <th>عدد الأصناف</th>
                                    <th>المستخدم</th>
                                    <th width="120">العمليات</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($orders as $index => $order)
                                    <tr class="shadow-sm">

                                        <td>{{ $orders->firstItem() + $index }}</td>

                                        <td>
                                            <span class="badge badge-dark">
                                                #{{ $order->id }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($order->pro_date)->format('Y-m-d') }}
                                        </td>

                                        <td class="text-success font-weight-bold">
                                            {{ number_format($order->fat_total, 2) }} ج
                                        </td>

                                        <td class="text-danger">
                                            {{ number_format($order->fat_disc, 2) }} ج
                                        </td>

                                        <td class="text-primary font-weight-bold">
                                            {{ number_format($order->fat_net, 2) }} ج
                                        </td>

                                        <td>
                                            <span class="badge badge-info">
                                                {{ $order->items_count }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge badge-secondary">
                                                {{ $order->user ?? 'غير محدد' }}
                                            </span>
                                        </td>

                                        <td>
                                            <button type="button"
                                                    class="btn btn-sm btn-info action-btn"
                                                    data-toggle="modal"
                                                    data-target="#orderModal{{ $order->id }}"
                                                    title="عرض التفاصيل">
                                                <i class="fa fa-eye text-white"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">
                                                        تفاصيل الطلب رقم #{{ $order->id }}
                                                    </h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">

                                                    <!-- معلومات الطلب -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <div class="border p-3 rounded">
                                                                <small class="text-muted d-block">التاريخ</small>
                                                                <strong>{{ $order->pro_date }}</strong>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="border p-3 rounded">
                                                                <small class="text-muted d-block">المستخدم</small>
                                                                <strong>{{ $order->user ?? 'غير محدد' }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- جدول الأصناف -->
                                                    <h6 class="mb-3 font-weight-bold">الأصناف المطلوبة</h6>

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm text-center">
                                                            <thead class="bg-light">
                                                                <tr>
                                                                    <th>اسم الصنف</th>
                                                                    <th>الكمية</th>
                                                                    <th>السعر</th>
                                                                    <th>الإجمالي</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($order->items as $item)
                                                                    <tr>
                                                                        <td>{{ $item->item_name }}</td>
                                                                        <td>{{ $item->quantity }}</td>
                                                                        <td>{{ number_format($item->price, 2) }} ج</td>
                                                                        <td>{{ number_format($item->total, 2) }} ج</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>

                                                            <tfoot class="bg-light font-weight-bold">
                                                                <tr>
                                                                    <td colspan="3">الإجمالي</td>
                                                                    <td>{{ number_format($order->fat_total, 2) }} ج</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3">الخصم</td>
                                                                    <td>{{ number_format($order->fat_disc, 2) }} ج</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3">الصافي</td>
                                                                    <td class="text-primary">
                                                                        {{ number_format($order->fat_net, 2) }} ج
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>

                                                    @if($order->info)
                                                        <div class="border p-3 mt-3 rounded bg-light">
                                                            <small class="text-muted d-block mb-2">ملاحظات:</small>
                                                            <p class="mb-0">{{ $order->info }}</p>
                                                        </div>
                                                    @endif

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button"
                                                            class="btn btn-secondary"
                                                            data-dismiss="modal">
                                                        إغلاق
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            لا توجد طلبات
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($orders->hasPages())
                        <div class="mt-3">
                            {{ $orders->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </section>
</div>

@endsection