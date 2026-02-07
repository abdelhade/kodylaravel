@extends('dashboard.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-0">ضبط الأرصدة الافتتاحية للمخازن</h3>
                <small class="text-muted">مراجعة وتعديل أرصدة أول المدة للأصناف</small>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('items-start-balance.reset') }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد بالتأكيد تصفير جميع الأرصدة الافتتاحية؟')">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-trash-restore me-1"></i> تصفير الرصيد
                    </button>
                </form>
                <button type="button" class="btn btn-success btn-sm" id="editModeBtn" onclick="toggleEditMode()">
                    <i class="fas fa-edit me-1"></i> تعديل
                </button>
                <button type="button" class="btn btn-success btn-sm" id="saveBtn" onclick="document.getElementById('balanceForm').submit()" style="display: none;">
                    <i class="fas fa-save me-1"></i> حفظ
                </button>
            </div>
        </div>
        
        <div class="card shadow-sm border-0">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('items-start-balance.store') }}" method="post" id="balanceForm">
                    @csrf
                    <div class="table-responsive">
                        <table id="horsTable" class="table table-striped table-hover align-middle text-center">
                            <thead>
                                <tr class="bg-light">
                                    <th>م</th>
                                    <th>كود الصنف</th>
                                    <th>اسم الصنف</th>
                                    <th>الوحدة</th>
                                    <th>رصيد جديد</th>
                                    <th>رصيد حالي</th>
                                    <th>سعر جديد</th>
                                    <th>سعر حالي</th>
                                    <th>التسوية</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td><b>{{ $item->iname }}</b></td>
                                        <td>{{ $item->unit_name }}</td>
                                        <td>
                                            <input type="number" 
                                                   name="new_balance[{{ $index }}]" 
                                                   class="form-control form-control-sm new-balance-input" 
                                                   value="{{ $item->current_start_balance }}" 
                                                   step="0.01" 
                                                   min="0" 
                                                   readonly
                                                   style="background-color: #f0f0f0;">
                                        </td>
                                        <td><b>{{ number_format($item->current_start_balance, 2) }}</b></td>
                                        <td>
                                            <input type="number" 
                                                   name="new_price[{{ $index }}]" 
                                                   class="form-control form-control-sm new-price-input" 
                                                   value="{{ $item->current_start_price }}" 
                                                   step="0.01" 
                                                   min="0" 
                                                   readonly
                                                   style="background-color: #f0f0f0;">
                                        </td>
                                        <td><b>{{ number_format($item->current_start_price, 2) }}</b></td>
                                        <td>
                                            <span class="adjustment-value">0.00</span>
                                        </td>
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
        editBtn.innerHTML = '<i class="fas fa-times me-1"></i> إلغاء';
        editBtn.classList.remove('btn-warning');
        editBtn.classList.add('btn-secondary');
        saveBtn.style.display = 'inline-block';
    } else {
        inputs.forEach(input => {
            input.setAttribute('readonly', 'readonly');
            input.style.backgroundColor = '#f0f0f0';
        });
        editBtn.innerHTML = '<i class="fas fa-edit me-1"></i> تعديل';
        editBtn.classList.remove('btn-secondary');
        editBtn.classList.add('btn-warning');
        saveBtn.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const balanceInputs = document.querySelectorAll('.new-balance-input');
    
    balanceInputs.forEach((input, index) => {
        input.addEventListener('input', function() {
            calculateAdjustment(index);
        });
    });
});

function calculateAdjustment(index) {
    const row = document.querySelectorAll('tbody tr')[index];
    const currentBalanceText = row.querySelector('td:nth-child(6) b').textContent.replace(/,/g, '');
    const currentBalance = parseFloat(currentBalanceText) || 0;
    const newBalance = parseFloat(row.querySelector('.new-balance-input').value) || 0;
    const adjustment = newBalance - currentBalance;
    
    const adjustmentSpan = row.querySelector('.adjustment-value');
    if (adjustmentSpan) {
        adjustmentSpan.textContent = adjustment.toFixed(2);
        if (adjustment > 0) {
            adjustmentSpan.style.color = 'green';
            adjustmentSpan.style.fontWeight = 'bold';
        } else if (adjustment < 0) {
            adjustmentSpan.style.color = 'red';
            adjustmentSpan.style.fontWeight = 'bold';
        } else {
            adjustmentSpan.style.color = 'black';
            adjustmentSpan.style.fontWeight = 'normal';
        }
    }
}
</script>
@endsection
