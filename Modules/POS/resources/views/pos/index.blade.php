@extends('dashboard.layout')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">طلبات الـ POS</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>رقم الطلب</th>
                            <th>التاريخ</th>
                            <th>الإجمالي</th>
                            <th>الخصم</th>
                            <th>الصافي</th>
                            <th>عدد الأصناف</th>
                            <th>المستخدم</th>
                            <th>التفاصيل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->pro_date }}</td>
                            <td>{{ number_format($order->fat_total, 2) }}</td>
                            <td>{{ number_format($order->fat_disc, 2) }}</td>
                            <td class="fw-bold text-success">{{ number_format($order->fat_net, 2) }}</td>
                            <td><span class="badge bg-info text-dark">{{ $order->items_count }}</span></td>
                            <td>{{ $order->user }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                    عرض الأصناف
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">تفاصيل الطلب رقم #{{ $order->id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-sm">
                                            <thead>
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
                                                    <td>{{ number_format($item->price, 2) }}</td>
                                                    <td>{{ number_format($item->total, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="mt-3 p-2 bg-light border">
                                            <strong>ملاحظات:</strong> {{ $order->info ?? 'لا يوجد' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection