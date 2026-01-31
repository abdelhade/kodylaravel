@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h2 class="hadi-fade-in2 bg-zinc-200">ضبط الأرصدة الافتتاحية للمخازن</h2>
                        </div>
                        <div class="col text-left">
                            <ul style="float: left;">
                                <li>
                                    <form action="{{ route('items-start-balance.reset') }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد بالتأكيد تصفير جميع الأرصدة الافتتاحية؟')">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn bg-red-400">تصفير الرصيد الافتتاحي</button>
                                    </form>
                                    <button type="button" class="btn bg-yellow-400" id="editModeBtn" onclick="toggleEditMode()">تعديل بضاعة أول المدة</button>
                                    <button type="button" class="btn bg-green-400" id="saveBtn" onclick="document.getElementById('balanceForm').submit()" style="display: none;">حفظ</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('items-start-balance.store') }}" method="post" id="balanceForm">
                        @csrf
                        <div class="table table-responsive table-stripped" id="horsTable">
                            <table class="table" id="myTable" data-page-length="50">
                                <thead>
                                    <tr class="bg-gray-300">
                                        <th>#</th>
                                        <th>كود الصنف</th>
                                        <th>اسم الصنف</th>
                                        <th>الوحدة</th>
                                        <th>رصيد أول المدة الجديد</th>
                                        <th>رصيد أول المدة الحالي</th>
                                        <th>سعر أول المدة الجديد</th>
                                        <th>سعر أول المدة الحالي</th>
                                        <th>التسوية</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $index => $item)
                                        <tr>
                                            <th>{{ $index + 1 }}</th>
                                            <th>{{ $item->code }}</th>
                                            <th>{{ $item->iname }}</th>
                                            <th>{{ $item->unit_name }}</th>
                                            <th>
                                                <input type="number" 
                                                       name="new_balance[{{ $index }}]" 
                                                       class="form-control new-balance-input" 
                                                       value="{{ $item->current_start_balance }}" 
                                                       step="0.01" 
                                                       min="0" 
                                                       readonly
                                                       style="background-color: #f0f0f0;">
                                            </th>
                                            <th>{{ number_format($item->current_start_balance, 2) }}</th>
                                            <th>
                                                <input type="number" 
                                                       name="new_price[{{ $index }}]" 
                                                       class="form-control new-price-input" 
                                                       value="{{ $item->current_start_price }}" 
                                                       step="0.01" 
                                                       min="0" 
                                                       readonly
                                                       style="background-color: #f0f0f0;">
                                            </th>
                                            <th>{{ number_format($item->current_start_price, 2) }}</th>
                                            <th>
                                                @php
                                                    $adjustment = $item->current_start_balance - $item->current_start_balance; // Will be calculated in JS
                                                @endphp
                                                <span class="adjustment-value">0.00</span>
                                            </th>
                                            <input type="hidden" name="item_id[{{ $index }}]" value="{{ $item->id }}">
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
let editMode = false;

function toggleEditMode() {
    editMode = !editMode;
    const inputs = document.querySelectorAll('.new-balance-input, .new-price-input');
    const editBtn = document.getElementById('editModeBtn');
    const saveBtn = document.getElementById('saveBtn');
    
    if (editMode) {
        inputs.forEach(input => {
            input.removeAttribute('readonly');
            input.style.backgroundColor = '#fff';
        });
        editBtn.textContent = 'إلغاء التعديل';
        editBtn.classList.remove('bg-yellow-400');
        editBtn.classList.add('bg-gray-400');
        saveBtn.style.display = 'inline-block';
    } else {
        inputs.forEach(input => {
            input.setAttribute('readonly', 'readonly');
            input.style.backgroundColor = '#f0f0f0';
        });
        editBtn.textContent = 'تعديل بضاعة أول المدة';
        editBtn.classList.remove('bg-gray-400');
        editBtn.classList.add('bg-yellow-400');
        saveBtn.style.display = 'none';
    }
}

// Calculate adjustment on input change
document.addEventListener('DOMContentLoaded', function() {
    const balanceInputs = document.querySelectorAll('.new-balance-input');
    const priceInputs = document.querySelectorAll('.new-price-input');
    
    balanceInputs.forEach((input, index) => {
        input.addEventListener('input', function() {
            calculateAdjustment(index);
        });
    });
    
    priceInputs.forEach((input, index) => {
        input.addEventListener('input', function() {
            calculateAdjustment(index);
        });
    });
});

function calculateAdjustment(index) {
    const row = document.querySelectorAll('tbody tr')[index];
    const currentBalance = parseFloat(row.querySelector('td:nth-child(6)').textContent.replace(/,/g, '')) || 0;
    const newBalance = parseFloat(row.querySelector('.new-balance-input').value) || 0;
    const adjustment = newBalance - currentBalance;
    
    const adjustmentSpan = row.querySelector('.adjustment-value');
    if (adjustmentSpan) {
        adjustmentSpan.textContent = adjustment.toFixed(2);
        if (adjustment > 0) {
            adjustmentSpan.style.color = 'green';
        } else if (adjustment < 0) {
            adjustmentSpan.style.color = 'red';
        } else {
            adjustmentSpan.style.color = 'black';
        }
    }
}
</script>
@endsection
