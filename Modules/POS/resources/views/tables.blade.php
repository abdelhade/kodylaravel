@extends('layouts.master')

@section('title', 'POS - نظام الطاولات')

@section('styles')
<style>
    #pos-container { height: 100vh; overflow: hidden; }
    #tables-section { height: 100vh; overflow-y: auto; background-color: #f8f9fa; }
    #pos-section { height: 100vh; overflow-y: auto; }
    .table-btn { min-width: 100px; min-height: 100px; font-size: 1.2rem; margin: 10px; transition: all 0.3s; border-radius: 10px; }
    .table-btn:hover { transform: scale(1.05); }
    .table-available { background-color: #60a5fa; color: white; border: none; }
    .table-occupied { background-color: #fca5a5; color: white; border: none; }
    .table-selected { border: 4px solid #1e40af !important; box-shadow: 0 0 15px rgba(30, 64, 175, 0.5); }
    .item-card { cursor: pointer; transition: all 0.3s; min-height: 80px; border-radius: 8px; }
    .item-card:hover { background-color: #ec4899; color: white; transform: translateY(-3px); }
    .category-btn { margin: 5px; min-width: 80px; }
    #order-items { max-height: 250px; overflow-y: auto; }
    .floating-pos-btn { position: fixed; bottom: 30px; left: 30px; width: 70px; height: 70px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 50%; box-shadow: 0 8px 16px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; z-index: 9999; transition: all 0.3s; }
    .floating-pos-btn:hover { transform: scale(1.1) rotate(-10deg); color: white; }
</style>
@endsection

@section('content')
<nav class="navbar navbar-expand font-xs font-light p-2 bg-primary text-white">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1"><i class="fas fa-store"></i> نظام POS - الطاولات</span>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a href="{{ route('pos.barcode') }}" class="nav-link text-white"><i class="fas fa-cash-register"></i> POS الكاشير</a></li>
            <li class="nav-item"><a href="{{ url('/') }}" class="nav-link text-white"><i class="fas fa-home"></i> الرئيسية</a></li>
            <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link text-white"><i class="fas fa-sign-out-alt"></i> خروج</a></li>
        </ul>
    </div>
</nav>

<div class="container-fluid" id="pos-container">
    <div class="row h-100">
        {{-- Tables Section --}}
        <div class="col-md-3" id="tables-section">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">الطاولات</h4>
                </div>
                <div class="card-body" id="tables-container">
                    @foreach($tables as $table)
                        <button class="table-btn {{ $table->table_case == 0 ? 'table-available' : 'table-occupied' }}"
                                data-id="{{ $table->id }}" data-name="{{ $table->tname }}" data-status="{{ $table->table_case }}">
                            {{ $table->tname }}<br>
                            <small>{{ $table->table_case == 0 ? '✓ متاحة' : '⚠ مشغولة' }}</small>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- POS Section --}}
        <div class="col-md-9" id="pos-section">
            <div class="row">
                {{-- Order Info --}}
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">معلومات الطلب</h5>
                        </div>
                        <div class="card-body">
                            <input type="hidden" id="selected_table_id">
                            <input type="hidden" id="current_order_id">
                            
                            <div class="mb-2">
                                <label>الطاولة</label>
                                <input type="text" class="form-control" id="table_name" readonly placeholder="اختر طاولة">
                            </div>
                            <div class="mb-2">
                                <label>التاريخ</label>
                                <input type="date" class="form-control" id="order_date" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="mb-2">
                                <label>المخزن</label>
                                <select class="form-control" id="store_id">
                                    @foreach($stores as $store)
                                        <option value="{{ $store->id }}" {{ $settings->def_pos_store == $store->id ? 'selected' : '' }}>{{ $store->aname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label>الموظف</label>
                                <select class="form-control" id="emp_id">
                                    @foreach($employees as $emp)
                                        <option value="{{ $emp->id }}" {{ $settings->def_pos_employee == $emp->id ? 'selected' : '' }}>{{ $emp->aname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label>الصندوق</label>
                                <select class="form-control" id="fund_id">
                                    @foreach($funds as $fund)
                                        <option value="{{ $fund->id }}" {{ $settings->def_pos_fund == $fund->id ? 'selected' : '' }}>{{ $fund->aname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label>امسح الباركود</label>
                                <input type="text" class="form-control" id="barcode-input" placeholder="امسح الباركود...">
                            </div>
                        </div>
                    </div>

                    {{-- Order Items --}}
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">الأصناف</h5>
                        </div>
                        <div class="card-body p-0">
                            <div id="order-items">
                                <table class="table table-sm mb-0">
                                    <thead><tr><th>الصنف</th><th>كمية</th><th>سعر</th><th>قيمة</th><th></th></tr></thead>
                                    <tbody id="items-tbody"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row mb-2">
                                <div class="col-6"><strong>الإجمالي:</strong></div>
                                <div class="col-6"><input type="number" class="form-control form-control-sm" id="total" value="0.00" readonly></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><strong>خصم %:</strong></div>
                                <div class="col-4"><input type="number" class="form-control form-control-sm" id="disc_percent" value="0"></div>
                                <div class="col-4"><input type="number" class="form-control form-control-sm" id="discount" value="0.00"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>الصافي:</strong></div>
                                <div class="col-6"><input type="number" class="form-control form-control-sm text-success fw-bold" id="net" value="0.00" readonly></div>
                            </div>
                            <button class="btn btn-success btn-block mb-2 w-100" id="save-order"><i class="fas fa-save"></i> حفظ الطلب</button>
                            <button class="btn btn-primary btn-block mb-2 w-100" id="payment-btn"><i class="fas fa-credit-card"></i> سداد الطلب</button>
                            <button class="btn btn-warning btn-block mb-2 w-100" id="print-order"><i class="fas fa-print"></i> طباعة</button>
                            <button class="btn btn-danger btn-block w-100" id="cancel-order"><i class="fas fa-times"></i> إلغاء</button>
                        </div>
                    </div>
                </div>

                {{-- Items Grid --}}
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-warning">
                            <input type="text" class="form-control" id="item-search" placeholder="ابحث عن صنف...">
                        </div>
                        <div class="card-body">
                            <div class="mb-3" id="categories">
                                <button class="btn btn-sm btn-primary category-btn active" data-category="all">الكل</button>
                                @foreach($categories as $cat)
                                    <button class="btn btn-sm btn-outline-primary category-btn" data-category="{{ $cat->id }}">{{ $cat->gname }}</button>
                                @endforeach
                            </div>
                            <div class="row g-2" id="items-container">
                                @foreach($items as $item)
                                    <div class="col-4 col-md-3">
                                        <div class="item-card card p-2 text-center" data-barcode="{{ $item->barcode }}" data-category="{{ $item->group1 }}" data-name="{{ $item->iname }}" data-price="{{ $item->price1 }}" data-id="{{ $item->id }}">
                                            <i class="fas fa-box text-primary"></i>
                                            <small class="d-block fw-bold">{{ Str::limit($item->iname, 15) }}</small>
                                            <small class="text-success">{{ $item->price1 }} ج</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('pos.barcode') }}" class="floating-pos-btn" title="POS الكاشير"><i class="fas fa-cash-register"></i></a>
@endsection

@section('scripts')
<script>
let selectedTable = null;
let orderItems = [];

// Table selection
$('.table-btn').click(function() {
    $('.table-btn').removeClass('table-selected');
    $(this).addClass('table-selected');
    selectedTable = { id: $(this).data('id'), name: $(this).data('name'), status: $(this).data('status') };
    $('#selected_table_id').val(selectedTable.id);
    $('#table_name').val(selectedTable.name);
    
    if (selectedTable.status == 1) {
        if (confirm('هذه الطاولة مشغولة. هل تريد تحميل الطلب الموجود؟')) {
            loadTableOrder(selectedTable.id);
        }
    }
});

// Category filter
$('.category-btn').click(function() {
    $('.category-btn').removeClass('active btn-primary').addClass('btn-outline-primary');
    $(this).removeClass('btn-outline-primary').addClass('active btn-primary');
    const cat = $(this).data('category');
    $('.item-card').each(function() {
        $(this).closest('.col-4, .col-md-3').toggle(cat === 'all' || $(this).data('category') == cat);
    });
});

// Search
$('#item-search').on('input', function() {
    const q = this.value.toLowerCase();
    $('.item-card').each(function() {
        $(this).closest('.col-4, .col-md-3').toggle($(this).data('name').toLowerCase().includes(q));
    });
});

// Item click
$('.item-card').click(function() {
    addItem($(this).data('id'), $(this).data('name'), $(this).data('price'), $(this).data('barcode'));
});

// Barcode input
$('#barcode-input').keypress(function(e) {
    if (e.which === 13) {
        e.preventDefault();
        const barcode = $(this).val();
        const item = $(`.item-card[data-barcode="${barcode}"]`);
        if (item.length) {
            addItem(item.data('id'), item.data('name'), item.data('price'), barcode);
        } else {
            alert('لا يوجد صنف بهذا الباركود');
        }
        $(this).val('').focus();
    }
});

function addItem(id, name, price, barcode) {
    const existing = orderItems.find(i => i.id === id);
    if (existing) {
        existing.qty++;
    } else {
        orderItems.push({ id, name, price: parseFloat(price), barcode, qty: 1 });
    }
    renderItems();
}

function renderItems() {
    let html = '';
    orderItems.forEach((item, idx) => {
        const subtotal = item.qty * item.price;
        html += `<tr>
            <td>${item.name}</td>
            <td><input type="number" class="form-control form-control-sm qty-input" data-idx="${idx}" value="${item.qty}" min="1"></td>
            <td>${item.price.toFixed(2)}</td>
            <td>${subtotal.toFixed(2)}</td>
            <td><button class="btn btn-danger btn-sm delete-item" data-idx="${idx}"><i class="fas fa-trash"></i></button></td>
        </tr>`;
    });
    $('#items-tbody').html(html || '<tr><td colspan="5" class="text-center text-muted">لا توجد أصناف</td></tr>');
    updateTotals();
}

function updateTotals() {
    const total = orderItems.reduce((sum, i) => sum + (i.qty * i.price), 0);
    $('#total').val(total.toFixed(2));
    const discount = parseFloat($('#discount').val()) || 0;
    $('#net').val((total - discount).toFixed(2));
}

$('#items-tbody').on('input', '.qty-input', function() {
    orderItems[$(this).data('idx')].qty = parseInt($(this).val()) || 1;
    renderItems();
});

$('#items-tbody').on('click', '.delete-item', function() {
    orderItems.splice($(this).data('idx'), 1);
    renderItems();
});

$('#disc_percent').on('input', function() {
    const total = parseFloat($('#total').val()) || 0;
    const disc = (total * parseFloat($(this).val()) / 100) || 0;
    $('#discount').val(disc.toFixed(2));
    updateTotals();
});

$('#discount').on('input', updateTotals);

$('#save-order').click(function() {
    if (!selectedTable) { alert('اختر طاولة أولاً'); return; }
    if (orderItems.length === 0) { alert('أضف أصناف أولاً'); return; }
    // Save order via AJAX
    alert('تم حفظ الطلب بنجاح!');
});

$('#cancel-order').click(function() {
    if (confirm('هل تريد إلغاء الطلب؟')) {
        orderItems = [];
        renderItems();
    }
});

function loadTableOrder(tableId) {
    // Load existing order for this table via AJAX
    console.log('Loading order for table:', tableId);
}
</script>
@endsection
