@extends('dashboard.layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">طلبات نقاط البيع</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active">طلبات POS</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">قائمة الطلبات</h3>
                <div class="card-tools">
                    <a href="{{ route('pos.barcode') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> طلب جديد
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>رقم الفاتورة</th>
                                <th>التاريخ</th>
                                <th>العميل</th>
                                <th>النوع</th>
                                <th>الإجمالي</th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $index => $order)
                            <tr>
                                <td>{{ $orders->firstItem() + $index }}</td>
                                <td><strong>{{ $order->id }}</strong></td>
                                <td>
                                    {{ \Carbon\Carbon::parse($order->pro_date)->format('Y-m-d') }}
                                    <br>
                                    <small class="text-muted">
                                        <i class="far fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($order->crtime)->format('h:i A') }}
                                    </small>
                                </td>
                                <td>{{ $order->client_name ?? 'غير محدد' }}</td>
                                <td>
                                    @if($order->age == 1)
                                        <span class="badge badge-info">تيك اواي</span>
                                    @elseif($order->age == 2)
                                        <span class="badge badge-primary">طاولة</span>
                                    @else
                                        <span class="badge badge-secondary">غير محدد</span>
                                    @endif
                                </td>
                                <td><strong class="text-success">{{ number_format($order->fat_net, 2) }} ج.م</strong></td>
                                <td>
                                    <span class="badge badge-success">مكتمل</span>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm" onclick="showOrderDetails({{ $order->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('pos.print', $order->id) }}" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm" onclick="deleteOrder({{ $order->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">لا توجد طلبات</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</section>

<!-- Modal لعرض تفاصيل الفاتورة -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">تفاصيل الفاتورة</h5>
                <button type="button" class="close text-white" onclick="closeModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="orderDetailsContent">
                <div class="text-center">
                    <i class="fas fa-spinner fa-spin fa-3x"></i>
                    <p>جاري التحميل...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">إغلاق</button>
                <button type="button" class="btn btn-primary" onclick="printInvoice()">
                    <i class="fas fa-print"></i> طباعة
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.invoice-box {
    max-width: 800px;
    margin: auto;
    padding: 20px;
    border: 1px solid #eee;
    font-size: 14px;
    line-height: 24px;
    font-family: 'Cairo', sans-serif;
}

.invoice-header {
    border-bottom: 2px solid #333;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.invoice-details {
    margin-bottom: 20px;
}

.invoice-table {
    width: 100%;
    border-collapse: collapse;
}

.invoice-table th,
.invoice-table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}

.invoice-table th {
    background-color: #f8f9fa;
    font-weight: bold;
}

.invoice-total {
    margin-top: 20px;
    text-align: left;
}

.invoice-total table {
    margin-right: auto;
    width: 300px;
}
</style>

<script>
function showOrderDetails(orderId) {
    $('#orderDetailsModal').modal('show');
    
    $.ajax({
        url: '/pos/order/' + orderId + '/details',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                renderInvoice(response.order, response.details);
            } else {
                $('#orderDetailsContent').html('<div class="alert alert-danger">حدث خطأ في تحميل البيانات</div>');
            }
        },
        error: function() {
            $('#orderDetailsContent').html('<div class="alert alert-danger">حدث خطأ في الاتصال بالخادم</div>');
        }
    });
}

function renderInvoice(order, details) {
    let itemsHtml = '';
    details.forEach((item, index) => {
        itemsHtml += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.item_name}</td>
                <td>${item.quantity}</td>
                <td>${parseFloat(item.price).toFixed(2)}</td>
                <td>${parseFloat(item.total).toFixed(2)}</td>
            </tr>
        `;
    });

    let invoiceHtml = `
        <div class="invoice-box" id="invoiceToPrint">
            <div class="invoice-header">
                <h2 class="text-center mb-3">فاتورة نقطة بيع</h2>
                <div class="row">
                    <div class="col-6">
                        <strong>رقم الفاتورة:</strong> ${order.id}<br>
                        <strong>التاريخ:</strong> ${order.pro_date}<br>
                        <strong>الوقت:</strong> ${new Date(order.crtime).toLocaleTimeString('ar-EG', {hour: '2-digit', minute: '2-digit', hour12: true})}
                    </div>
                    <div class="col-6 text-left">
                        <strong>العميل:</strong> ${order.client_name || 'غير محدد'}<br>
                        <strong>النوع:</strong> ${order.age == 1 ? 'تيك اواي' : 'طاولة'}<br>
                        <strong>المستخدم:</strong> ${order.user}
                    </div>
                </div>
            </div>

            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الصنف</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    ${itemsHtml}
                </tbody>
            </table>

            <div class="invoice-total">
                <table class="table">
                    <tr>
                        <td><strong>الإجمالي:</strong></td>
                        <td class="text-left"><strong>${parseFloat(order.fat_total).toFixed(2)} ج.م</strong></td>
                    </tr>
                    <tr>
                        <td><strong>الخصم:</strong></td>
                        <td class="text-left">${parseFloat(order.fat_disc).toFixed(2)} ج.م</td>
                    </tr>
                    <tr class="table-success">
                        <td><strong>الصافي:</strong></td>
                        <td class="text-left"><strong>${parseFloat(order.fat_net).toFixed(2)} ج.م</strong></td>
                    </tr>
                </table>
            </div>

            ${order.info ? `<div class="mt-3"><strong>ملاحظات:</strong> ${order.info}</div>` : ''}
        </div>
    `;

    $('#orderDetailsContent').html(invoiceHtml);
}

function printInvoice() {
    let printContent = document.getElementById('invoiceToPrint').innerHTML;
    let originalContent = document.body.innerHTML;
    
    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;
    location.reload();
}

function closeModal() {
    $('#orderDetailsModal').modal('hide');
}

function deleteOrder(orderId) {
    if (!confirm('هل أنت متأكد من حذف هذا الطلب؟')) {
        return;
    }

    $.ajax({
        url: '/pos/order/' + orderId,
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                alert(response.message);
                location.reload();
            } else {
                alert('حدث خطأ: ' + response.message);
            }
        },
        error: function() {
            alert('حدث خطأ في الاتصال بالخادم');
        }
    });
}
</script>
@endsection
