@extends('dashboard.layout')

@section('content')

    <div class="container-fluid p-2">
        <input type="hidden" name="pro_tybe" value="{{ $pro_tybe }}">
        <h4 class="font-thin text-md text-center text-white"
            style="font-size:2em;padding:15px;background: linear-gradient(135deg, #26a69a 0%, #00897b 100%);border-radius: 10px 10px 0 0;margin:0;">
            {{ $invoice_title }}
        </h4>

        <div class="card" style="border-radius: 0 0 10px 10px;box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div class="card-body p-3">
                <form
                    action="{{ $is_edit_mode ? route('purchases.update', $invoice_data->id ?? 0) : route('purchases.store') }}"
                    method="POST" id="purchaseForm">
                    @csrf
                    @if ($is_edit_mode)
                        @method('PUT')
                    @endif

                    <input type="hidden" name="pro_tybe" value="{{ $pro_tybe }}">

                    <!-- رأس الفاتورة -->
                    <div class="row mb-3" style="background: #f5f5f5;padding: 15px;border-radius: 8px;">
                        <div class="col-md-2">
                            <label style="font-weight: 600;color: #00897b;">رقم الفاتورة</label>
                            <input type="text" name="pro_serial" class="form-control"
                                value="{{ $is_edit_mode && isset($invoice_data->pro_serial) ? $invoice_data->pro_serial : '' }}"
                                placeholder="اختياري">
                        </div>

                        <div class="col-md-2">
                            <label style="font-weight: 600;color: #00897b;">التاريخ</label>
                            <input type="date" name="pro_date" class="form-control"
                                value="{{ $is_edit_mode && isset($invoice_data->pro_date) ? $invoice_data->pro_date : date('Y-m-d') }}"
                                required>
                        </div>

                        <div class="col-md-2">
                            <label style="font-weight: 600;color: #00897b;">تاريخ الاستحقاق</label>
                            <input type="date" name="accural_date" class="form-control"
                                value="{{ $is_edit_mode && isset($invoice_data->accural_date) ? $invoice_data->accural_date : '' }}">
                        </div>

                        <div class="col-md-2">
                            <label style="font-weight: 600;color: #00897b;">المورد</label>
                            <select name="acc2_id" class="form-control" required style="border: 2px solid #26a69a;">
                                <option value="">اختر المورد</option>
                                @foreach (DB::table('acc_head')->where('isdeleted', 0)->where('code', 'like', '211%')->orderBy('aname')->get() as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ $is_edit_mode && isset($invoice_data->acc2) && $invoice_data->acc2 == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->aname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label style="font-weight: 600;color: #00897b;">المخزن</label>
                            <select name="store_id" class="form-control" id="storeSelect" required
                                style="border: 2px solid #26a69a;">
                                <option value="">اختر المخزن</option>
                                @foreach (DB::table('acc_head')->where('isdeleted', 0)->where('code', 'like', '123%')->orderBy('aname')->get() as $store)
                                    <option value="{{ $store->id }}"
                                        {{ $is_edit_mode && isset($invoice_data->store_id) && $invoice_data->store_id == $store->id ? 'selected' : '' }}>
                                        {{ $store->aname }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="storeInventory"
                                style="color: #00897b;font-weight: 600;margin-top: 5px;display: block;"></small>
                        </div>

                        <div class="col-md-2">
                            <label style="font-weight: 600;color: #00897b;">الموظف</label>
                            <select name="emp_id" class="form-control" style="border: 2px solid #26a69a;">
                                <option value="">اختر الموظف</option>
                                @php
                                    $employees = DB::table('employees')->where('isdeleted', 0)->get();
                                    if ($employees->isEmpty()) {
                                        // إذا لم يوجد موظفين، أضف خيار افتراضي
                                        echo '<option value="1">موظف افتراضي</option>';
                                    }
                                @endphp
                                @foreach ($employees as $emp)
                                    <option value="{{ $emp->id }}"
                                        {{ $is_edit_mode && isset($invoice_data->emp_id) && $invoice_data->emp_id == $emp->id ? 'selected' : '' }}>
                                        {{ $emp->name ?? 'موظف بدون اسم' }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($employees->isEmpty())
                                <small class="text-warning">لا يوجد موظفين، سيتم استخدام الموظف الافتراضي</small>
                            @endif
                        </div>
                    </div>

                    <!-- جدول الأصناف -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="itemsTable" style="background: white;">
                            <thead style="background: linear-gradient(135deg, #26a69a 0%, #00897b 100%);color: white;">
                                <tr>
                                    <th width="3%" class="text-center">م</th>
                                    <th width="30%">اسم الصنف</th>
                                    <th width="10%">الوحدة</th>
                                    <th width="10%">الكمية</th>
                                    <th width="12%">السعر</th>
                                    <th width="10%">الخصم</th>
                                    <th width="12%">القيمة</th>
                                    <th width="3%">حذف</th>
                                </tr>
                            </thead>
                            <tbody id="itemsBody">
                                @if ($is_edit_mode)
                                    @foreach (DB::table('fat_details')->where('fat_id', $invoice_data->id)->get() as $index => $detail)
                                        @php
                                            $item = DB::table('myitems')->where('id', $detail->item_id)->first();
                                            $units = DB::table('item_units')
                                                ->join('myunits', 'item_units.unit_id', '=', 'myunits.id')
                                                ->where('item_units.item_id', $detail->item_id)
                                                ->where('item_units.isdeleted', 0)
                                                ->select('item_units.id', 'myunits.uname', 'item_units.u_val', 'item_units.cost_price')
                                                ->get();
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                <select name="itmname[]" class="form-control item-select" required>
                                                    @foreach (DB::table('myitems')->where('isdeleted', 0)->get() as $item_option)
                                                        @php
                                                            $item_units = DB::table('item_units')
                                                                ->join('myunits', 'item_units.unit_id', '=', 'myunits.id')
                                                                ->where('item_units.item_id', $item_option->id)
                                                                ->where('item_units.isdeleted', 0)
                                                                ->select('item_units.id', 'myunits.uname', 'item_units.u_val', 'item_units.cost_price')
                                                                ->get();
                                                        @endphp
                                                        <option value="{{ $item_option->id }}"
                                                            data-price="{{ $item_option->cost_price }}"
                                                            data-name="{{ $item_option->itm_name ?? ($item_option->itmname ?? 'صنف') }}"
                                                            data-units='@json($item_units)'
                                                            {{ $detail->item_id == $item_option->id ? 'selected' : '' }}>
                                                            {{ $item_option->iname ?? ($item_option->name2 ?? 'صنف') }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="unit_id[]" class="form-control item-unit">
                                                    <option value="1" data-uval="1">اختر الوحدة</option>
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->id }}" data-uval="{{ $unit->u_val }}" data-price="{{ $unit->cost_price }}">
                                                            {{ $unit->uname }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="u_val[]" class="unit-uval" value="1">
                                            </td>
                                            <td><input type="number" name="itmqty[]" class="form-control item-qty"
                                                    value="{{ $detail->quantity }}" step="0.01" required></td>
                                            <td><input type="number" name="itmprice[]" class="form-control item-price"
                                                    value="{{ $detail->price }}" step="0.01" required></td>
                                            <td><input type="number" name="itmdisc[]" class="form-control item-disc"
                                                    value="0" step="0.01"></td>
                                            <td><input type="number" class="form-control item-total"
                                                    value="{{ $detail->total }}" readonly
                                                    style="background: #e8f5e9;font-weight: bold;"></td>
                                            <td class="text-center"><button type="button"
                                                    class="btn btn-danger btn-sm remove-row">×</button></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>
                                            <select name="itmname[]" class="form-control item-select" required>
                                                <option value="">اختر الصنف</option>
                                                @foreach (DB::table('myitems')->where('isdeleted', 0)->get() as $item)
                                                    @php
                                                        $units = DB::table('item_units')
                                                            ->join('myunits', 'item_units.unit_id', '=', 'myunits.id')
                                                            ->where('item_units.item_id', $item->id)
                                                            ->where('item_units.isdeleted', 0)
                                                            ->select(
                                                                'item_units.id',
                                                                'myunits.uname',
                                                                'item_units.u_val',
                                                                'item_units.cost_price',
                                                            )
                                                            ->get();
                                                    @endphp
                                                    <option value="{{ $item->id }}"
                                                        data-price="{{ $item->cost_price }}"
                                                        data-name="{{ $item->iname ?? 'صنف' }}"
                                                        data-units='@json($units)'>
                                                        {{ $item->iname ?? 'صنف' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="u_val[]" value="1">
                                        </td>
                                        <td>
                                            <select name="unit_id[]" class="form-control item-unit">
                                                <option value="1" data-uval="1">اختر الوحدة</option>
                                            </select>
                                            <input type="hidden" name="u_val[]" class="unit-uval" value="1">
                                        </td>
                                        <td><input type="number" name="itmqty[]" class="form-control item-qty"
                                                value="1" step="0.01" required></td>
                                        <td><input type="number" name="itmprice[]" class="form-control item-price"
                                                value="0" step="0.01" required></td>
                                        <td><input type="number" name="itmdisc[]" class="form-control item-disc"
                                                value="0" step="0.01"></td>
                                        <td><input type="number" class="form-control item-total" value="0" readonly
                                                style="background: #e8f5e9;font-weight: bold;"></td>
                                        <td class="text-center"><button type="button"
                                                class="btn btn-danger btn-sm remove-row">×</button></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success" id="addRow"
                            style="background: #26a69a;border: none;">
                            <i class="fas fa-plus"></i> إضافة صنف
                        </button>
                    </div>

                    <!-- الإجماليات والملاحظات -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-weight: 600;">ملاحظات</label>
                                <textarea name="info" class="form-control" rows="4" placeholder="أضف ملاحظات هنا...">{{ $is_edit_mode && isset($invoice_data->info) ? $invoice_data->info : '' }}</textarea>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="showOldInvoices">
                                <label class="form-check-label" for="showOldInvoices">
                                    إظهار الفواتير السابقة
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div style="background: #f5f5f5;padding: 20px;border-radius: 8px;">
                                <div class="row mb-2">
                                    <div class="col-3" style="direction: rtl"><strong>الإجمالي:</strong></div>
                                    <div class='col-8'>
                                        <input type="number" name="headtotal" id="headtotal"
                                            class="form-control text-center" value="0" readonly
                                            style="background: white;font-weight: bold;font-size: 1.1em;">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class='col-3'><strong>الخصم:</strong></div>

                                    <div class='col-8'>
                                        <input type="number" name="headdisc" id="headdisc"
                                            class="form-control text-center" value="0" step="0.01">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class='col-3' style="direction: rtl"><strong>الإضافي:</strong></div>
                                    <div class='col-8'>
                                        <input type="number" name="headplus" id="headplus"
                                            class="form-control text-center" value="0" step="0.01">
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid #26a69a;margin:15px">
                                <div class="row">
                                    <div class='col-3' style="direction: rtl"><strong
                                            style="font-size: 1.2em;color: #00897b;">الصافي:</strong></div>
                                    <div class='col-8'>
                                        <input type="number" name="headnet" id="headnet"
                                            class="form-control text-center" value="0" readonly
                                            style="background: #26a69a;color: white;font-weight: bold;font-size: 1.3em;border: none;">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class='col-3' style="direction: rtl"><strong>المدفوع:</strong></div>
                                    <div class='col-8'>
                                        <input type="number" name="paid" id="paid"
                                            class="form-control text-center" value="0" step="0.01">
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class='col-3' style="direction: rtl"><strong>الصندوق:</strong></div>
                                    <div class='col-8'>
                                        <select name="fund_id" class="form-control">
                                            <option value="">اختر الصندوق</option>
                                            @foreach (DB::table('acc_head')->where('isdeleted', 0)->where('code', 'like', '121%')->orderBy('aname')->get() as $fund)
                                                <option value="{{ $fund->id }}">{{ $fund->aname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class='col-3' style="direction: rtl"><strong
                                            style="color: #d32f2f;">الباقي:</strong>
                                    </div>
                                    <div class='col-8'>
                                        <input type="number" id="remaining" class="form-control text-center"
                                            value="0" readonly
                                            style="background: #ffebee;font-weight: bold;color: #d32f2f;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- أزرار الحفظ -->
                    <div class="row mt-4">
                        <div class="col-md-12 text-center">
                            <button type="submit" name="submit" value="save" class="btn btn-lg"
                                style="background: #26a69a;color: white;padding: 12px 40px;border: none;border-radius: 25px;font-size: 1.1em;">
                                <i class="fas fa-save"></i> حفظ (F12)
                            </button>
                            <button type="submit" name="submit" value="print" class="btn btn-lg"
                                style="background: #00897b;color: white;padding: 12px 40px;border: none;border-radius: 25px;font-size: 1.1em;margin-right: 10px;">
                                <i class="fas fa-print"></i> حفظ وطباعة (F11)
                            </button>
                            <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-lg"
                                style="padding: 12px 40px;border-radius: 25px;font-size: 1.1em;margin-right: 10px;">
                                <i class="fas fa-times"></i> إلغاء
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Store inventory data
            const storeInventoryData = {};

            // Fetch store inventory
            function loadStoreInventory() {
                const storeId = document.getElementById('storeSelect').value;
                if (!storeId) {
                    document.getElementById('storeInventory').textContent = '';
                    return;
                }

                fetch(`/api/store-inventory/${storeId}`)
                    .then(response => response.json())
                    .then(data => {
                        let inventory = '';
                        if (data.items && data.items.length > 0) {
                            inventory = 'محتويات المخزن: ' + data.items.map(item =>
                                `${item.name} (${item.qty})`).join(' | ');
                        }
                        document.getElementById('storeInventory').textContent = inventory;
                    })
                    .catch(err => console.log('Store inventory not available'));
            }

            document.getElementById('storeSelect').addEventListener('change', loadStoreInventory);

            // Initialize Select2 for item selects
            $(document).ready(function() {
                $('.item-select').select2({
                    placeholder: 'اختر الصنف',
                    allowClear: true,
                    width: '100%',
                    language: {
                        noResults: function() {
                            return 'لم يتم العثور على نتائج';
                        },
                        searching: function() {
                            return 'جاري البحث...';
                        }
                    }
                });

                // Handle Select2 change event
                $(document).on('select2:select', '.item-select', function(e) {
                    let select = e.target;
                    let option = select.options[select.selectedIndex];
                    let price = option.getAttribute('data-price') || 0;
                    let units = JSON.parse(option.getAttribute('data-units') || '[]');
                    let row = $(select).closest('tr')[0];

                    row.querySelector('.item-price').value = price;

                    // تحديث قائمة الوحدات
                    let unitSelect = row.querySelector('.item-unit');
                    unitSelect.innerHTML = '<option value="1" data-uval="1">اختر الوحدة</option>';
                    units.forEach(unit => {
                        unitSelect.innerHTML +=
                            `<option value="${unit.id}" data-uval="${unit.u_val}" data-price="${unit.cost_price}">${unit.uname}</option>`;
                    });

                    // Update u_val when unit changes
                    $(unitSelect).off('change').on('change', function() {
                        const selectedOption = this.options[this.selectedIndex];
                        const uval = selectedOption.getAttribute('data-uval') || 1;
                        $(this).closest('tr').find('.unit-uval').val(uval);
                    });

                    calculateRowTotal(row);
                });
            });

            // Item search functionality
            const itemSearch = document.getElementById('itemSearch');

            if (itemSearch) {
                itemSearch.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const selects = document.querySelectorAll('.item-select');

                    selects.forEach(select => {
                        const options = select.querySelectorAll('option');
                        options.forEach(option => {
                            if (option.value === '') return;
                            const itemName = (option.getAttribute('data-name') || option
                                .textContent).toLowerCase();
                            option.style.display = itemName.includes(searchTerm) ? '' :
                                'none';
                        });
                    });
                });
            }

            // حساب الإجماليات
            function calculateTotals() {
                let total = 0;
                document.querySelectorAll('.item-total').forEach(function(el) {
                    total += parseFloat(el.value) || 0;
                });

                document.getElementById('headtotal').value = total.toFixed(2);

                let disc = parseFloat(document.getElementById('headdisc').value) || 0;
                let plus = parseFloat(document.getElementById('headplus').value) || 0;
                let net = total - disc + plus;

                document.getElementById('headnet').value = net.toFixed(2);

                // حساب الباقي
                let paid = parseFloat(document.getElementById('paid').value) || 0;
                let remaining = net - paid;
                document.getElementById('remaining').value = remaining.toFixed(2);
            }

            // حساب إجمالي الصنف
            function calculateRowTotal(row) {
                let qty = parseFloat(row.querySelector('.item-qty').value) || 0;
                let price = parseFloat(row.querySelector('.item-price').value) || 0;
                let disc = parseFloat(row.querySelector('.item-disc').value) || 0;
                let total = qty * (price - disc);
                row.querySelector('.item-total').value = total.toFixed(2);
                calculateTotals();
            }

            // عند تغيير الصنف
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('item-select')) {
                    let option = e.target.options[e.target.selectedIndex];
                    let price = option.getAttribute('data-price') || 0;
                    let units = JSON.parse(option.getAttribute('data-units') || '[]');
                    let row = e.target.closest('tr');

                    row.querySelector('.item-price').value = price;

                    // تحديث قائمة الوحدات
                    let unitSelect = row.querySelector('.item-unit');
                    unitSelect.innerHTML = '<option value="">اختر الوحدة</option>';
                    units.forEach(unit => {
                        unitSelect.innerHTML +=
                            `<option value="${unit.id}" data-uval="${unit.u_val}" data-price="${unit.cost_price}">${unit.uname}</option>`;
                    });

                    calculateRowTotal(row);
                }
            });

            // عند تغيير الكمية أو السعر أو الخصم
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('item-qty') ||
                    e.target.classList.contains('item-price') ||
                    e.target.classList.contains('item-disc')) {
                    calculateRowTotal(e.target.closest('tr'));
                }

                if (e.target.id === 'headdisc' || e.target.id === 'headplus' || e.target.id === 'paid') {
                    calculateTotals();
                }
            });

            // إضافة صنف جديد
            document.getElementById('addRow').addEventListener('click', function() {
                let tbody = document.getElementById('itemsBody');
                let rowCount = tbody.querySelectorAll('tr').length + 1;
                let firstRow = tbody.querySelector('tr');
                let newRow = firstRow.cloneNode(true);

                newRow.querySelector('td:first-child').textContent = rowCount;
                newRow.querySelectorAll('input').forEach(function(input) {
                    if (!input.classList.contains('item-total') && input.type !== 'text') {
                        input.value = input.classList.contains('item-qty') ? '1' : '0';
                    } else if (input.classList.contains('item-total')) {
                        input.value = '0';
                    }
                });

                // Destroy select2 before cloning
                $(newRow).find('.item-select').select2('destroy');
                newRow.querySelector('select').selectedIndex = 0;

                tbody.appendChild(newRow);

                // Reinitialize select2 for new row
                $(newRow).find('.item-select').select2({
                    placeholder: 'اختر الصنف',
                    allowClear: true,
                    width: '100%'
                });
            });

            // حذف صنف
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-row')) {
                    let tbody = document.getElementById('itemsBody');
                    if (tbody.querySelectorAll('tr').length > 1) {
                        e.target.closest('tr').remove();
                        calculateTotals();

                        // إعادة ترقيم الصفوف
                        tbody.querySelectorAll('tr').forEach(function(row, index) {
                            row.querySelector('td:first-child').textContent = index + 1;
                        });
                    }
                }
            });

            // اختصارات لوحة المفاتيح
            document.addEventListener('keydown', function(e) {
                if (e.key === 'F12') {
                    e.preventDefault();
                    document.querySelector('button[value="save"]').click();
                } else if (e.key === 'F11') {
                    e.preventDefault();
                    document.querySelector('button[value="print"]').click();
                }
            });

            // حساب الإجماليات عند التحميل
            calculateTotals();
        });
    </script>
@endsection
