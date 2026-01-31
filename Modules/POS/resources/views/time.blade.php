@extends('layouts.master')

@section('title', 'POS - نظام الوقت')

@section('styles')
<style>
    #upRight { height: 550px; position: relative; display: flex; flex-direction: column; }
    #downRight { height: 400px; }
    .cat { width: 100px; background: #f1f5f9; border: 2px solid #e2e8f0; border-radius: 8px; padding: 10px; margin: 5px; transition: all 0.3s; cursor: pointer; }
    .cat:hover { background: #ec4899; color: white; }
    .cashInput { width: 60px; text-align: center; }
    .itemButton { min-width: 100px; min-height: 80px; margin: 5px; border-radius: 8px; background: #f8fafc; border: 1px solid #e2e8f0; cursor: pointer; transition: all 0.3s; }
    .itemButton:hover { background: #ec4899; color: white; transform: translateY(-2px); }
    #items { display: flex; flex-wrap: wrap; max-height: 400px; overflow-y: auto; }
</style>
@endsection

@section('content')
<nav class="navbar navbar-expand font-xs font-light p-0 bg-slate-200">
    <ul class="navbar-nav">
        <li class="nav-item"><a href="{{ url('/') }}" class="nav-link">الرئيسية</a></li>
        <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link">تسجيل الخروج</a></li>
    </ul>
</nav>

{{-- Tables Modal --}}
<div id="tables" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">اختر الطاولة</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2">
                    @foreach($tables as $table)
                        <div class="col-3">
                            <button class="btn btn-lg w-100 tab {{ $table->table_case == 0 ? 'btn-success' : 'btn-danger' }}" 
                                    data-id="{{ $table->id }}" data-bs-dismiss="modal">
                                <p>{{ $table->tname }}</p>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="pos">
    {{-- Right Panel - Order --}}
    <div class="col-md-4 bg-slate-200" id="right">
        <button class="btn btn-light float-start" id="fullscreenBtn"><i class="fas fa-vector-square"></i></button>
        
        <form action="{{ url('native/do/doadd_invoice.php') }}" method="post" id="posForm">
            @csrf
            <div class="row bg-slate-50" id="upRight0">
                <input type="hidden" name="pro_tybe" value="9">
                <input type="hidden" name="pro_serial" value="0">
                <input type="hidden" name="pro_id" value="1">
                <input type="date" name="pro_date" class="form-control form-control-sm mb-1" value="{{ date('Y-m-d') }}">
                <input type="date" name="accural_date" class="form-control form-control-sm mb-1" value="{{ date('Y-m-d') }}">
                
                <select name="store_id" class="form-select form-select-sm mb-1">
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" {{ $settings->def_pos_store == $store->id ? 'selected' : '' }}>{{ $store->aname }}</option>
                    @endforeach
                </select>
                <select name="emp_id" class="form-select form-select-sm mb-1">
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ $settings->def_pos_employee == $emp->id ? 'selected' : '' }}>{{ $emp->aname }}</option>
                    @endforeach
                </select>
                <select name="acc2_id" class="form-select form-select-sm mb-1">
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ $settings->def_pos_client == $client->id ? 'selected' : '' }}>{{ $client->aname }}</option>
                    @endforeach
                </select>
                <select name="fund_id" class="form-select form-select-sm mb-1">
                    @foreach($funds as $fund)
                        <option value="{{ $fund->id }}" {{ $settings->def_pos_fund == $fund->id ? 'selected' : '' }}>{{ $fund->aname }}</option>
                    @endforeach
                </select>
                
                <div class="row">
                    <div class="col"><button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tables">الطاولة</button></div>
                    <div class="col"><input type="text" readonly class="form-control bg-sky-200" placeholder="لا توجد طاولة" id="tableInput" name="table"></div>
                </div>
                
                <input type="text" class="form-control form-control-sm mt-2" placeholder="امسح الباركود" id="barcodeInput">
            </div>

            <div class="row bg-slate-50 d-flex flex-column" id="upRight">
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table bg-light shadow">
                        <thead>
                            <tr><td>الاسم</td><td>عدد</td><td>سعر</td><td>قيمة</td><td></td></tr>
                        </thead>
                        <tbody id="itemData"></tbody>
                    </table>
                </div>

                <div class="row bg-orange-50 mt-auto p-2">
                    <div class="col-12 mb-2">
                        <input type="text" class="form-control" name="info" id="info" placeholder="ملاحظة">
                    </div>
                    <div class="col-4"><strong>إجمالي</strong></div>
                    <div class="col-8">
                        <input class="form-control" type="text" readonly name="headtotal" id="total" value="0.00">
                        <input name="headplus" type="hidden" value="0">
                    </div>
                    <div class="col-4"><strong>خصم</strong></div>
                    <div class="col-8">
                        <input class="form-control" type="number" name="headdisc" id="discount" value="0" step="0.01">
                    </div>
                    <div class="col-4"><strong>صافي</strong></div>
                    <div class="col-8">
                        <input class="form-control form-control-lg text-success fw-bold" type="text" name="headnet" id="net_val" value="0" readonly>
                    </div>
                    <div class="col-6"><strong>المدفوع</strong></div>
                    <div class="col-6">
                        <input class="form-control" type="number" id="paid" value="0.00" step="0.01">
                    </div>
                    <div class="col-6"><strong>الباقي</strong></div>
                    <div class="col-6">
                        <input class="form-control bg-danger text-white" type="text" id="change" value="0.00" readonly>
                    </div>
                </div>
            </div>

            <div class="row" id="downRight2">
                <div class="col-6">
                    <button name="submit" type="submit" value="save" class="btn btn-success btn-lg w-100 mb-2">حفظ</button>
                </div>
                <div class="col-6">
                    <button name="submit" type="submit" value="cash" class="btn btn-primary btn-lg w-100 mb-2">حفظ وطباعة</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Left Panel - Items --}}
    <div class="col-md-8 bg-slate-200" id="left">
        <div class="row bg-yellow-50 mb-2" id="searchRow">
            <input type="text" class="form-control" id="itemSearch" placeholder="ابحث عن صنف...">
        </div>

        <div class="row mb-2" id="categories">
            <button class="cat" onclick="filterItemsByCategory(null)">الكل</button>
            @foreach($categories as $cat)
                <button class="cat" onclick="filterItemsByCategory({{ $cat->id }})">{{ $cat->gname }}</button>
            @endforeach
        </div>

        <div class="row" id="items">
            @foreach($items as $item)
                <button class="itemButton" itemid="{{ $item->barcode }}" data-category="{{ $item->group1 }}">
                    <i class="fas fa-star text-warning"></i>
                    <p class="fw-bold small mb-0">{{ $item->iname }}</p>
                    <p class="text-success mb-0">{{ $item->price1 }} ج</p>
                </button>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Table selection
$('.tab').click(function() {
    $('#tableInput').val($(this).find('p').text());
});

// Fullscreen
$('#fullscreenBtn').click(function() {
    if (!document.fullscreenElement) document.documentElement.requestFullscreen();
    else document.exitFullscreen();
});

// POS Logic
const updateTotal = () => {
    let total = 0;
    $('.subtotal').each(function() { total += parseFloat($(this).val()) || 0; });
    $('#total').val(total.toFixed(2));
    updateNet();
};

const updateNet = () => {
    const total = parseFloat($('#total').val()) || 0;
    const discount = parseFloat($('#discount').val()) || 0;
    const net = total - discount;
    $('#net_val').val(net.toFixed(2));
    const paid = parseFloat($('#paid').val()) || 0;
    $('#change').val((paid - net).toFixed(2));
};

const fetchData = (barcode) => {
    if (!barcode) return;
    $.ajax({
        url: '{{ url("native/js/ajax/getbycode.php") }}',
        method: 'GET',
        data: { barcode },
        success: (response) => {
            if (response.error) alert("لا يوجد صنف");
            else addOrUpdateRow(response);
        }
    });
};

const addOrUpdateRow = (itemData) => {
    const barcode = itemData.barcode, price = parseFloat(itemData.price1);
    const $existing = $(`#itemData tr[data-itemid="${barcode}"]`);
    if ($existing.length) {
        const $qty = $existing.find('.quantityInput'), newQty = parseInt($qty.val()) + 1;
        $qty.val(newQty);
        $existing.find('.subtotal').val((newQty * price).toFixed(2));
    } else {
        const rownum = $('#itemData tr').length + 1;
        $('#itemData').append(`
            <tr data-itemid="${barcode}">
                <td><input type="hidden" value="${itemData.id}" name="itmname[]">${itemData.iname}</td>
                <td><input type="number" class="cashInput quantityInput form-control form-control-sm" value="1" name="itmqty[]" min="1"><input type="hidden" name="u_val[]" value="1"></td>
                <td><input type="number" class="cashInput priceInput form-control form-control-sm" value="${price.toFixed(2)}" name="itmprice[]"></td>
                <td><input type="hidden" name="itmdisc[]" value="0"><input type="text" class="subtotal form-control form-control-sm" value="${price.toFixed(2)}" name="itmval[]" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm delRow"><i class="fas fa-trash"></i></button></td>
            </tr>
        `);
    }
    updateTotal();
};

function filterItemsByCategory(categoryId) {
    $('.itemButton').each(function() {
        $(this).toggle(categoryId === null || $(this).data('category') == categoryId);
    });
}

$(document).ready(() => {
    $('#items').on('click', '.itemButton', function() { fetchData($(this).attr('itemid')); });
    $('#itemSearch').on('input', function() {
        const q = this.value.toLowerCase();
        $('.itemButton').each(function() { $(this).toggle($(this).text().toLowerCase().includes(q)); });
    });
    $('#itemData').on('input', '.quantityInput, .priceInput', function() {
        const $row = $(this).closest('tr');
        $row.find('.subtotal').val((parseFloat($row.find('.quantityInput').val()) * parseFloat($row.find('.priceInput').val())).toFixed(2));
        updateTotal();
    });
    $('#itemData').on('click', '.delRow', function() { $(this).closest('tr').remove(); updateTotal(); });
    $('#discount, #paid').on('input', updateNet);
    $('#barcodeInput').on('keypress', function(e) {
        if (e.which === 13) { e.preventDefault(); fetchData($(this).val()); $(this).val('').focus(); }
    }).focus();
});
</script>
@endsection
