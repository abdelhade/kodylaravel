@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid p-0 m-0">
            
            @php
                $invoice_types = [
                    'buy' => 4,
                    'rebuy' => 11,
                    'po' => 12
                ];
                
                $invoice_names = [
                    4 => 'فاتورة مشتريات',
                    11 => 'فاتورة مردود مشتريات', 
                    12 => 'أمر شراء'
                ];
                
                $pro_type = $invoice_types[$type] ?? 4;
                $invoice_title = $invoice_names[$pro_type] ?? 'فاتورة مشتريات';
                
                $bg_class = in_array($pro_type, [4]) ? 'bg-primary' : 'bg-danger';
            @endphp
            
            <input type="hidden" name="pro_tybe" value="{{ $pro_type }}">
            
            <div class="text-center mb-4">
                <h4 class="text-white {{ $bg_class }} p-3 rounded">
                    {{ $invoice_title }}
                </h4>
            </div>

            <div class="card">
                <div class="card-body p-0 m-0">
                    
                    <!-- صف إضافة صنف جديد -->
                    <div class="row bg-light p-2 mb-3">
                        <div class="col-md-3">
                            <input type="text" id="item_search" class="form-control" placeholder="ابحث عن صنف...">
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="item_qty" class="form-control" placeholder="الكمية" step="0.01">
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="item_price" class="form-control" placeholder="السعر" step="0.01">
                        </div>
                        <div class="col-md-2">
                            <select id="item_unit" class="form-control">
                                <option value="1">قطعة</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-success" onclick="addItem()">
                                <i class="fas fa-plus"></i> إضافة
                            </button>
                        </div>
                    </div>

                    <form action="#" method="post" id="invoiceForm">
                        @csrf
                        <input type="hidden" name="pro_tybe" value="{{ $pro_type }}">
                        
                        <!-- رأس الفاتورة -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label>المورد</label>
                                <select name="client_id" class="form-control" required>
                                    <option value="">اختر المورد</option>
                                    <!-- سيتم تحميل الموردين من قاعدة البيانات -->
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>التاريخ</label>
                                <input type="date" name="invoice_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>رقم الفاتورة</label>
                                <input type="text" name="invoice_number" class="form-control" placeholder="رقم الفاتورة">
                            </div>
                            <div class="col-md-3">
                                <label>المخزن</label>
                                <select name="store_id" class="form-control" required>
                                    <option value="">اختر المخزن</option>
                                    <!-- سيتم تحميل المخازن من قاعدة البيانات -->
                                </select>
                            </div>
                        </div>

                        <!-- جدول الأصناف -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="itemsTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th>م</th>
                                        <th>الصنف</th>
                                        <th>الكمية</th>
                                        <th>الوحدة</th>
                                        <th>السعر</th>
                                        <th>الإجمالي</th>
                                        <th>عمليات</th>
                                    </tr>
                                </thead>
                                <tbody id="itemsTableBody">
                                    <!-- سيتم إضافة الأصناف هنا -->
                                </tbody>
                            </table>
                        </div>

                        <!-- ذيل الفاتورة -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>ملاحظات</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="ملاحظات إضافية..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6"><strong>المجموع الفرعي:</strong></div>
                                            <div class="col-6 text-end" id="subtotal">0.00</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">خصم:</div>
                                            <div class="col-6">
                                                <input type="number" name="discount" class="form-control form-control-sm" value="0" step="0.01" onchange="calculateTotal()">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">ضريبة:</div>
                                            <div class="col-6">
                                                <input type="number" name="tax" class="form-control form-control-sm" value="0" step="0.01" onchange="calculateTotal()">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-6"><strong>الإجمالي النهائي:</strong></div>
                                            <div class="col-6 text-end"><strong id="total">0.00</strong></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> حفظ الفاتورة
                            </button>
                            <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
let itemCounter = 0;

function addItem() {
    const search = document.getElementById('item_search').value;
    const qty = document.getElementById('item_qty').value;
    const price = document.getElementById('item_price').value;
    const unit = document.getElementById('item_unit').value;
    
    if (!search || !qty || !price) {
        alert('يرجى ملء جميع الحقول');
        return;
    }
    
    itemCounter++;
    const total = (parseFloat(qty) * parseFloat(price)).toFixed(2);
    
    const row = `
        <tr id="row_${itemCounter}">
            <td>${itemCounter}</td>
            <td>${search}</td>
            <td>${qty}</td>
            <td>قطعة</td>
            <td>${price}</td>
            <td>${total}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${itemCounter})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
            <input type="hidden" name="items[${itemCounter}][name]" value="${search}">
            <input type="hidden" name="items[${itemCounter}][qty]" value="${qty}">
            <input type="hidden" name="items[${itemCounter}][price]" value="${price}">
            <input type="hidden" name="items[${itemCounter}][total]" value="${total}">
        </tr>
    `;
    
    document.getElementById('itemsTableBody').insertAdjacentHTML('beforeend', row);
    
    // مسح الحقول
    document.getElementById('item_search').value = '';
    document.getElementById('item_qty').value = '';
    document.getElementById('item_price').value = '';
    
    calculateTotal();
}

function removeItem(id) {
    document.getElementById(`row_${id}`).remove();
    calculateTotal();
}

function calculateTotal() {
    let subtotal = 0;
    const rows = document.querySelectorAll('#itemsTableBody tr');
    
    rows.forEach(row => {
        const totalCell = row.querySelector('td:nth-child(6)');
        if (totalCell) {
            subtotal += parseFloat(totalCell.textContent) || 0;
        }
    });
    
    const discount = parseFloat(document.querySelector('input[name="discount"]').value) || 0;
    const tax = parseFloat(document.querySelector('input[name="tax"]').value) || 0;
    
    const total = subtotal - discount + tax;
    
    document.getElementById('subtotal').textContent = subtotal.toFixed(2);
    document.getElementById('total').textContent = total.toFixed(2);
}
</script>
@endsection