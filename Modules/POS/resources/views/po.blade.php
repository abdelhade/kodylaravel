@extends('layouts.master')

@section('title', 'POS - أوامر الشراء')

@section('styles')
<style>
    body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    #pos { min-height: 100vh; padding: 20px; }
    #left, #right { background: rgba(255,255,255,0.95); border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); padding: 20px; height: calc(100vh - 40px); overflow: hidden; }
    #right { display: flex; flex-direction: column; }
    .cat { background: linear-gradient(45deg, #667eea, #764ba2); color: white; border: none; border-radius: 20px; padding: 12px 20px; font-weight: 600; transition: all 0.3s; margin: 5px; }
    .cat:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(102,126,234,0.4); }
    .items-grid { height: calc(100% - 150px); overflow-y: auto; display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px; padding: 10px; }
    .itemButton { background: white; border: 2px solid #e9ecef; border-radius: 15px; padding: 15px; text-align: center; transition: all 0.3s; cursor: pointer; }
    .itemButton:hover { transform: translateY(-5px); border-color: #667eea; background: linear-gradient(135deg, #667eea, #764ba2); color: white; }
    .table thead { background: linear-gradient(45deg, #667eea, #764ba2); color: white; }
    .payment-section { background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 20px; border-radius: 15px; margin-top: 15px; }
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-thumb { background: linear-gradient(45deg, #667eea, #764ba2); border-radius: 10px; }
</style>
@endsection

@section('content')
<nav class="navbar navbar-expand font-xs font-light p-0 bg-slate-200">
    <ul class="navbar-nav">
        <li class="nav-item"><a href="{{ url('/') }}" class="nav-link">الرئيسية</a></li>
        <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link">تسجيل الخروج</a></li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row h-100" id="pos">
        {{-- Left Panel - Products --}}
        <div class="col-lg-8">
            <div id="left">
                <div class="row mb-3" id="searchRow">
                    <input type="text" class="form-control" id="itemSearch" placeholder="ابحث عن صنف...">
                </div>
                <div class="row mb-3" id="categories">
                    <button class="cat" onclick="filterItemsByCategory(null)">الكل</button>
                    @foreach($categories as $cat)
                        <button class="cat" onclick="filterItemsByCategory({{ $cat->id }})">{{ $cat->gname }}</button>
                    @endforeach
                </div>
                <div class="items-grid" id="items">
                    @foreach($items as $item)
                        <button class="itemButton" itemid="{{ $item->barcode }}" data-category="{{ $item->group1 }}">
                            <div class="itemlogo"><i class="fas fa-box fa-2x text-primary"></i></div>
                            <div class="itemname">
                                <p class="fw-bold mb-1">{{ $item->iname }}</p>
                                <p class="text-success mb-0">{{ $item->price1 }} ج</p>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right Panel - Cart & Payment --}}
        <div class="col-lg-4">
            <div id="right">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 text-dark fw-bold"><i class="fas fa-shopping-cart text-primary"></i> سلة المشتريات</h4>
                    <button class="btn btn-light" id="fullscreenBtn"><i class="fas fa-expand"></i></button>
                </div>

                <form action="{{ url('native/do/doadd_invoice.php') }}" method="post" id="posForm">
                    @csrf
                    <input type="hidden" name="pro_tybe" value="11">
                    
                    {{-- Hidden selects for PO --}}
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <select name="store_id" class="form-select form-select-sm">
                                @foreach($stores as $store)
                                    <option value="{{ $store->id }}" {{ $settings->def_pos_store == $store->id ? 'selected' : '' }}>{{ $store->aname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <select name="emp_id" class="form-select form-select-sm">
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}" {{ $settings->def_pos_employee == $emp->id ? 'selected' : '' }}>{{ $emp->aname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <select name="acc2_id" class="form-select form-select-sm">
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->aname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <select name="fund_id" class="form-select form-select-sm">
                                @foreach($funds as $fund)
                                    <option value="{{ $fund->id }}" {{ $settings->def_pos_fund == $fund->id ? 'selected' : '' }}>{{ $fund->aname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Cart Section --}}
                    <div class="cart-section flex-grow-1" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm table-striped mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>الصنف</th>
                                    <th>كمية</th>
                                    <th>سعر</th>
                                    <th>قيمة</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="itemData"></tbody>
                        </table>
                    </div>

                    {{-- Payment Section --}}
                    <div class="payment-section">
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="small">الإجمالي</label>
                                <input type="text" class="form-control" id="total" name="headtotal" value="0.00" readonly>
                            </div>
                            <div class="col-6">
                                <label class="small">الخصم</label>
                                <input type="number" class="form-control" id="discount" name="headdisc" value="0" step="0.01">
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="small">الصافي</label>
                            <input type="text" class="form-control form-control-lg fw-bold" id="net_val" name="headnet" value="0" readonly style="border: 2px solid gold;">
                        </div>
                        <input type="hidden" name="headplus" value="0">
                        <div class="row g-2">
                            <div class="col-6">
                                <button type="submit" name="submit" value="save" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-save"></i> حفظ
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="submit" name="submit" value="cash" class="btn btn-warning btn-lg w-100">
                                    <i class="fas fa-print"></i> طباعة
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Add Client Modal --}}
<div class="modal fade" id="addclmodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">إضافة عميل جديد</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addClientForm">
                    <div class="mb-3"><label>اسم العميل</label><input type="text" class="form-control" name="clname" required></div>
                    <div class="mb-3"><label>تليفون</label><input type="text" class="form-control" name="phone" required></div>
                    <div class="mb-3"><label>عنوان</label><input type="text" class="form-control" name="address"></div>
                    <button type="submit" class="btn btn-success w-100">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const SELECTORS = { BARCODE_INPUT: '#barcodeInput', ITEM_DATA: '#itemData', TOTAL: '#total', DISCOUNT: '#discount', NET_VALUE: '#net_val', ITEM_SEARCH: '#itemSearch' };

const updateTotal = () => {
    let total = 0;
    $('.subtotal').each(function() { total += parseFloat($(this).val()) || 0; });
    $(SELECTORS.TOTAL).val(total.toFixed(2));
    updateNetValue();
};

const updateNetValue = () => {
    const total = parseFloat($(SELECTORS.TOTAL).val()) || 0;
    const discount = parseFloat($(SELECTORS.DISCOUNT).val()) || 0;
    $(SELECTORS.NET_VALUE).val((total - discount).toFixed(2));
};

const fetchData = (barcode) => {
    if (!barcode) return;
    $.ajax({
        url: '{{ url("native/js/ajax/getbycode.php") }}',
        method: 'GET',
        data: { barcode },
        success: (response) => {
            if (response.error) alert("لا يوجد صنف لهذا الباركود");
            else addOrUpdateRow(response);
        },
        error: () => alert('خطأ في جلب البيانات')
    });
};

const addOrUpdateRow = (itemData) => {
    const barcode = itemData.barcode, price = parseFloat(itemData.price1);
    const $existingRow = $(`${SELECTORS.ITEM_DATA} tr[data-itemid="${barcode}"]`);
    if ($existingRow.length > 0) {
        const $qty = $existingRow.find('.quantityInput'), newQty = parseInt($qty.val()) + 1;
        $qty.val(newQty);
        $existingRow.find('.subtotal').val((newQty * price).toFixed(2));
    } else {
        const rownum = $(`${SELECTORS.ITEM_DATA} tr`).length + 1;
        $(SELECTORS.ITEM_DATA).append(`
            <tr data-itemid="${barcode}">
                <td>${rownum}</td>
                <td><input type="hidden" value="${itemData.id}" name="itmname[]">${itemData.iname}</td>
                <td><input type="number" class="form-control form-control-sm quantityInput" value="1" name="itmqty[]" min="1"><input type="hidden" name="u_val[]" value="1"></td>
                <td><input type="number" class="form-control form-control-sm priceInput" value="${price.toFixed(2)}" name="itmprice[]" step="0.01"></td>
                <td><input type="hidden" name="itmdisc[]" value="0"><input type="text" class="form-control form-control-sm subtotal" value="${price.toFixed(2)}" name="itmval[]" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm delRow"><i class="fas fa-trash"></i></button></td>
            </tr>
        `);
    }
    updateTotal();
};

function filterItemsByCategory(categoryId) {
    $('.itemButton').each(function() {
        const itemCat = $(this).data('category');
        $(this).toggle(categoryId === null || itemCat == categoryId);
    });
}

$(document).ready(() => {
    $('#items').on('click', '.itemButton', function() { fetchData($(this).attr('itemid')); });
    $(SELECTORS.ITEM_SEARCH).on('input', function() {
        const q = this.value.toLowerCase();
        $('.itemButton').each(function() { $(this).toggle($(this).text().toLowerCase().includes(q)); });
    });
    $(SELECTORS.ITEM_DATA).on('input', '.quantityInput, .priceInput', function() {
        const $row = $(this).closest('tr');
        $row.find('.subtotal').val((parseFloat($row.find('.quantityInput').val()) * parseFloat($row.find('.priceInput').val())).toFixed(2));
        updateTotal();
    });
    $(SELECTORS.ITEM_DATA).on('click', '.delRow', function() { $(this).closest('tr').remove(); updateTotal(); });
    $(SELECTORS.DISCOUNT).on('input', updateNetValue);
    
    $('#fullscreenBtn').click(function() {
        if (!document.fullscreenElement) document.documentElement.requestFullscreen();
        else document.exitFullscreen();
    });
});
</script>
@endsection
