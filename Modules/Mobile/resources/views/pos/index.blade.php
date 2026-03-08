@extends('dashboard.layout')

@section('content')
<style>
    /* تحسين responsive للموبايل */
    @media (max-width: 768px) {
        .card-body {
            padding: 10px !important;
        }
        
        .form-control, .form-control-lg {
            font-size: 16px !important; /* منع الزوم في iOS */
        }
        
        select.form-control {
            width: 100% !important;
            max-width: 100% !important;
        }
        
        .table {
            font-size: 14px;
        }
        
        .table th, .table td {
            padding: 8px 4px;
        }
        
        .btn-lg {
            padding: 12px 20px;
            font-size: 16px;
        }
        
        .input-group-append .btn {
            padding: 12px 15px;
        }
    }
    
    /* تحسين عرض الجدول */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .qty-input {
        width: 80px;
        text-align: center;
    }
    
    /* تحسين الـ select boxes */
    select.form-control {
        appearance: auto;
        -webkit-appearance: menulist;
        -moz-appearance: menulist;
        background-color: white;
        border: 1px solid #ced4da;
        padding: 8px 12px;
    }
</style>

<div class="container-fluid py-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-cash-register mr-2"></i>
                        نقطة بيع متنقلة
                    </h3>
                </div>
                <div class="card-body">
                    
                    <!-- بحث المنتج -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" id="searchInput" class="form-control form-control-lg" 
                                       placeholder="ابحث بالباركود أو اسم المنتج..." autofocus>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="searchBtn">
                                        <i class="fas fa-search"></i> بحث
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- جدول المنتجات المضافة -->
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered" id="itemsTable">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40%">المنتج</th>
                                    <th width="15%">السعر</th>
                                    <th width="15%">الكمية</th>
                                    <th width="15%">الإجمالي</th>
                                    <th width="15%">حذف</th>
                                </tr>
                            </thead>
                            <tbody id="itemsBody">
                                <tr id="emptyRow">
                                    <td colspan="5" class="text-center text-muted">
                                        لم يتم إضافة منتجات بعد
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- الإجماليات -->
                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th>الإجمالي:</th>
                                    <td class="text-right"><span id="totalAmount">0.00</span> جنيه</td>
                                </tr>
                                <tr>
                                    <th>الخصم:</th>
                                    <td>
                                        <input type="number" id="discountInput" class="form-control form-control-sm" 
                                               value="0" min="0" step="0.01">
                                    </td>
                                </tr>
                                <tr class="table-success">
                                    <th>الصافي:</th>
                                    <td class="text-right"><strong><span id="netAmount">0.00</span> جنيه</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- بيانات الفاتورة -->
                    <div class="row mt-3">
                        <div class="col-12 col-md-4 mb-2">
                            <div class="form-group">
                                <label>المخزن</label>
                                <select id="storeSelect" class="select form-control " required>
                                    <option value="">اختر المخزن</option>
                                    @foreach($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->aname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-2">
                            <div class="form-group">
                                <label>العميل</label>
                                <select id="clientSelect" class="form-control" required>
                                    <option value="">اختر العميل</option>
                                    @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->aname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-2">
                            <div class="form-group">
                                <label>الصندوق</label>
                                <select id="fundSelect" class="form-control" required>
                                    <option value="">اختر الصندوق</option>
                                    @foreach($funds as $fund)
                                    <option value="{{ $fund->id }}">{{ $fund->aname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- أزرار الحفظ -->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <button type="button" id="saveBtn" class="btn btn-success btn-lg px-4 mb-2">
                                <i class="fas fa-save"></i> حفظ الفاتورة
                            </button>
                            <button type="button" id="clearBtn" class="btn btn-secondary btn-lg px-4 mb-2 ml-2">
                                <i class="fas fa-times"></i> إلغاء
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
let items = [];

$(document).ready(function() {
    // البحث عند الضغط على Enter
    $('#searchInput').on('keypress', function(e) {
        if (e.which === 13) {
            searchProduct();
        }
    });

    // البحث عند الضغط على زر البحث
    $('#searchBtn').on('click', searchProduct);

    // حساب الصافي عند تغيير الخصم
    $('#discountInput').on('input', calculateTotals);

    // حفظ الفاتورة
    $('#saveBtn').on('click', saveInvoice);

    // مسح الفاتورة
    $('#clearBtn').on('click', clearInvoice);
});

function searchProduct() {
    const search = $('#searchInput').val().trim();
    
    if (!search) {
        alert('يرجى إدخال باركود أو اسم المنتج');
        return;
    }

    $.ajax({
        url: '{{ route("mobile.pos.search") }}',
        method: 'POST',
        data: {
            search: search,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                addItem(response.item);
                $('#searchInput').val('').focus();
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('حدث خطأ في البحث');
        }
    });
}

function addItem(item) {
    // التحقق من وجود المنتج
    const existingIndex = items.findIndex(i => i.id === item.id);
    
    if (existingIndex !== -1) {
        // زيادة الكمية
        items[existingIndex].quantity++;
    } else {
        // إضافة منتج جديد
        items.push({
            id: item.id,
            name: item.name,
            price: parseFloat(item.price),
            quantity: 1,
            u_val: parseFloat(item.u_val),
            unit: item.unit
        });
    }
    
    renderItems();
}

function renderItems() {
    const tbody = $('#itemsBody');
    tbody.empty();
    
    if (items.length === 0) {
        tbody.append(`
            <tr id="emptyRow">
                <td colspan="5" class="text-center text-muted">
                    لم يتم إضافة منتجات بعد
                </td>
            </tr>
        `);
    } else {
        items.forEach((item, index) => {
            const total = item.price * item.quantity;
            tbody.append(`
                <tr>
                    <td>${item.name}</td>
                    <td>${item.price.toFixed(2)}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm qty-input" 
                               data-index="${index}" value="${item.quantity}" min="1" step="0.01">
                    </td>
                    <td class="text-right">${total.toFixed(2)}</td>
                    <td class="text-center">
                        <button class="btn btn-danger btn-sm remove-btn" data-index="${index}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
    }
    
    // تفعيل أحداث الكمية والحذف
    $('.qty-input').on('input', function() {
        const index = $(this).data('index');
        items[index].quantity = parseFloat($(this).val()) || 1;
        calculateTotals();
    });
    
    $('.remove-btn').on('click', function() {
        const index = $(this).data('index');
        items.splice(index, 1);
        renderItems();
    });
    
    calculateTotals();
}

function calculateTotals() {
    let total = 0;
    
    items.forEach(item => {
        total += item.price * item.quantity;
    });
    
    const discount = parseFloat($('#discountInput').val()) || 0;
    const net = total - discount;
    
    $('#totalAmount').text(total.toFixed(2));
    $('#netAmount').text(net.toFixed(2));
}

function saveInvoice() {
    if (items.length === 0) {
        alert('يرجى إضافة منتجات للفاتورة');
        return;
    }
    
    const storeId = $('#storeSelect').val();
    const clientId = $('#clientSelect').val();
    const fundId = $('#fundSelect').val();
    
    if (!storeId || !clientId || !fundId) {
        alert('يرجى اختيار المخزن والعميل والصندوق');
        return;
    }
    
    const discount = parseFloat($('#discountInput').val()) || 0;
    
    $.ajax({
        url: '{{ route("mobile.pos.save") }}',
        method: 'POST',
        data: {
            store_id: storeId,
            client_id: clientId,
            fund_id: fundId,
            items: JSON.stringify(items),
            discount: discount,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                alert(response.message + '\nرقم الفاتورة: ' + response.invoice_id);
                clearInvoice();
            } else {
                alert(response.message);
            }
        },
        error: function(xhr) {
            const response = xhr.responseJSON;
            alert(response?.message || 'حدث خطأ في حفظ الفاتورة');
        }
    });
}

function clearInvoice() {
    items = [];
    renderItems();
    $('#searchInput').val('');
    $('#discountInput').val(0);
    $('#searchInput').focus();
}
</script>
@endsection
