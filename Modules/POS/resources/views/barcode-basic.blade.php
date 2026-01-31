@extends('layouts.master')

@section('title', 'نقطة البيع الأساسية')

@section('styles')
<link href="{{ asset('native/dist/css/pos.css') }}" rel="stylesheet">
<style>
    #pos-container { min-height: calc(100vh - 60px); }
    .items-grid { display: flex; flex-wrap: wrap; gap: 10px; max-height: 500px; overflow-y: auto; }
    .item-card { 
        width: 120px; padding: 15px; text-align: center; cursor: pointer;
        background: #fff; border: 1px solid #ddd; border-radius: 8px;
        transition: all 0.3s;
    }
    .item-card:hover { background: #ec4899; color: white; transform: translateY(-3px); }
    .category-btn { margin: 5px; min-width: 80px; }
    .category-btn.active { background: #0d6efd; color: white; }
</style>
@endsection

@section('content')
<div class="container-fluid py-3" id="pos-container">
    <div class="row">
        {{-- Right Panel - Order Info --}}
        <div class="col-md-4">
            <div class="card shadow h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> معلومات الطلب</h5>
                </div>
                <div class="card-body">
                    <form action="{{ url('native/do/doadd_invoice.php') }}" method="post" id="posForm">
                        @csrf
                        {{-- Hidden Fields --}}
                        <input type="hidden" name="pro_tybe" value="9">
                        <input type="hidden" name="pro_serial" value="0">
                        <input type="hidden" name="pro_id" value="1">
                        
                        {{-- Order Type --}}
                        <div class="btn-group w-100 mb-3" role="group">
                            <input type="radio" class="btn-check" id="age1" name="age" value="1" checked>
                            <label class="btn btn-outline-success" for="age1">
                                <i class="fas fa-shopping-bag"></i> تيك أواي
                            </label>
                            <input type="radio" class="btn-check" id="age2" name="age" value="2">
                            <label class="btn btn-outline-primary" for="age2">
                                <i class="fas fa-chair"></i> طاولة
                            </label>
                            <input type="radio" class="btn-check" id="age3" name="age" value="3">
                            <label class="btn btn-outline-info" for="age3">
                                <i class="fas fa-motorcycle"></i> دليفري
                            </label>
                        </div>
                        
                        {{-- Dates & Selects --}}
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <input type="date" name="pro_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-6">
                                <input type="date" name="accural_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-6">
                                <select name="store_id" class="form-select form-select-sm">
                                    @foreach($stores as $store)
                                        <option value="{{ $store->id }}" {{ $settings->def_pos_store == $store->id ? 'selected' : '' }}>
                                            {{ $store->aname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <select name="emp_id" class="form-select form-select-sm">
                                    @foreach($employees as $emp)
                                        <option value="{{ $emp->id }}" {{ $settings->def_pos_employee == $emp->id ? 'selected' : '' }}>
                                            {{ $emp->aname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <select name="acc2_id" class="form-select form-select-sm">
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ $settings->def_pos_client == $client->id ? 'selected' : '' }}>
                                            {{ $client->aname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <select name="fund_id" class="form-select form-select-sm">
                                    @foreach($funds as $fund)
                                        <option value="{{ $fund->id }}" {{ $settings->def_pos_fund == $fund->id ? 'selected' : '' }}>
                                            {{ $fund->aname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Barcode Input --}}
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-lg" id="barcodeInput" 
                                   placeholder="امسح الباركود..." style="border: 2px solid #28a745;">
                        </div>

                        {{-- Cart Table --}}
                        <div class="card mb-3">
                            <div class="card-header bg-info text-white py-2">
                                <small><i class="fas fa-shopping-cart"></i> الأصناف المُضافة</small>
                            </div>
                            <div class="card-body p-0" style="max-height: 250px; overflow-y: auto;">
                                <table class="table table-sm table-striped mb-0">
                                    <thead class="table-dark">
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
                        </div>

                        {{-- Totals --}}
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">الإجمالي</label>
                                <input type="text" class="form-control" id="total" name="headtotal" value="0.00" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">الخصم</label>
                                <input type="number" class="form-control" id="discount" name="headdisc" value="0" step="0.01">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-success">الصافي</label>
                                <input type="text" class="form-control form-control-lg text-success fw-bold" 
                                       id="net_val" name="headnet" value="0" readonly style="border: 2px solid #28a745;">
                            </div>
                        </div>

                        <input type="hidden" name="headplus" value="0">

                        {{-- Action Buttons --}}
                        <div class="row g-2">
                            <div class="col-6">
                                <button type="submit" name="submit" value="save" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-save"></i><br>حفظ
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="submit" name="submit" value="cash" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-print"></i><br>حفظ وطباعة
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Left Panel - Products --}}
        <div class="col-md-8">
            <div class="card shadow h-100">
                <div class="card-header bg-warning">
                    <input type="text" class="form-control" id="itemSearch" placeholder="ابحث عن صنف...">
                </div>
                <div class="card-body">
                    {{-- Categories --}}
                    <div class="mb-3" id="categories">
                        <button class="btn btn-primary category-btn active" onclick="filterItemsByCategory(null)">الكل</button>
                        @foreach($categories as $cat)
                            <button class="btn btn-outline-primary category-btn" onclick="filterItemsByCategory({{ $cat->id }})">
                                {{ $cat->gname }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Items Grid --}}
                    <div class="items-grid" id="items">
                        @foreach($items as $item)
                            <div class="item-card" itemid="{{ $item->barcode }}" data-category="{{ $item->group1 }}">
                                <i class="fas fa-box fa-2x mb-2"></i>
                                <p class="mb-1 fw-bold small">{{ $item->iname }}</p>
                                <p class="mb-0 text-success">{{ $item->price1 }} ج</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// POS JavaScript
const SELECTORS = {
    BARCODE_INPUT: '#barcodeInput',
    ITEM_DATA: '#itemData',
    TOTAL: '#total',
    DISCOUNT: '#discount',
    NET_VALUE: '#net_val',
    ITEM_SEARCH: '#itemSearch'
};

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
            if (response.error) {
                alert("لا يوجد صنف لهذا الباركود");
            } else {
                addOrUpdateRow(response);
            }
        },
        error: () => alert('خطأ في جلب البيانات')
    });
};

const addOrUpdateRow = (itemData) => {
    const barcode = itemData.barcode;
    const price = parseFloat(itemData.price1);
    const $existingRow = $(`${SELECTORS.ITEM_DATA} tr[data-itemid="${barcode}"]`);

    if ($existingRow.length > 0) {
        const $qtyInput = $existingRow.find('.quantityInput');
        const newQty = parseInt($qtyInput.val()) + 1;
        $qtyInput.val(newQty);
        $existingRow.find('.subtotal').val((newQty * price).toFixed(2));
    } else {
        const rownum = $(`${SELECTORS.ITEM_DATA} tr`).length + 1;
        const newRow = `
            <tr data-itemid="${barcode}">
                <td>${rownum}</td>
                <td><input type="hidden" value="${itemData.id}" name="itmname[]">${itemData.iname}</td>
                <td><input type="number" class="form-control form-control-sm quantityInput" value="1" name="itmqty[]" min="1"><input type="hidden" name="u_val[]" value="1"></td>
                <td><input type="number" class="form-control form-control-sm priceInput" value="${price.toFixed(2)}" name="itmprice[]" step="0.01"></td>
                <td><input type="hidden" name="itmdisc[]" value="0"><input type="text" class="form-control form-control-sm subtotal" value="${price.toFixed(2)}" name="itmval[]" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm delRow"><i class="fas fa-trash"></i></button></td>
            </tr>
        `;
        $(SELECTORS.ITEM_DATA).append(newRow);
    }
    updateTotal();
};

function filterItemsByCategory(categoryId) {
    $('.item-card').each(function() {
        const itemCat = $(this).data('category');
        $(this).toggle(categoryId === null || itemCat == categoryId);
    });
    $('.category-btn').removeClass('active btn-primary').addClass('btn-outline-primary');
    if (categoryId === null) {
        $('.category-btn:first').removeClass('btn-outline-primary').addClass('active btn-primary');
    }
}

$(document).ready(() => {
    // Item click
    $('#items').on('click', '.item-card', function() {
        fetchData($(this).attr('itemid'));
    });

    // Search
    $(SELECTORS.ITEM_SEARCH).on('input', function() {
        const query = this.value.toLowerCase();
        $('.item-card').each(function() {
            $(this).toggle($(this).text().toLowerCase().includes(query));
        });
    });

    // Quantity/Price change
    $(SELECTORS.ITEM_DATA).on('input', '.quantityInput, .priceInput', function() {
        const $row = $(this).closest('tr');
        const qty = parseFloat($row.find('.quantityInput').val()) || 0;
        const price = parseFloat($row.find('.priceInput').val()) || 0;
        $row.find('.subtotal').val((qty * price).toFixed(2));
        updateTotal();
    });

    // Delete row
    $(SELECTORS.ITEM_DATA).on('click', '.delRow', function() {
        $(this).closest('tr').remove();
        updateTotal();
    });

    // Discount change
    $(SELECTORS.DISCOUNT).on('input', updateNetValue);

    // Barcode input
    $(SELECTORS.BARCODE_INPUT).on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            fetchData($(this).val());
            $(this).val('').focus();
        }
    }).focus();
});
</script>
@endsection
