@extends('layouts.master')

@section('content')
@php
    $mainColor = $context['color'] ?? 'slate';
    $mainIcon = $context['icon'] ?? 'fa-edit';
    $pageTitle = $context['name'] ?? 'دليل الحسابات';
    
    $colorMap = [
        'azure' => ['bg' => '#f0f7ff', 'border' => '#bee3f8', 'text' => '#2b6cb0', 'btn' => '#3182ce', 'btnHover' => '#2c5282'],
        'indigo' => ['bg' => '#f5f3ff', 'border' => '#ddd6fe', 'text' => '#5b21b6', 'btn' => '#7c3aed', 'btnHover' => '#6d28d9'],
        'emerald' => ['bg' => '#ecfdf5', 'border' => '#a7f3d0', 'text' => '#065f46', 'btn' => '#10b981', 'btnHover' => '#059669'],
        'blue' => ['bg' => '#eff6ff', 'border' => '#bfdbfe', 'text' => '#1e40af', 'btn' => '#3b82f6', 'btnHover' => '#2563eb'],
        'rose' => ['bg' => '#fff1f2', 'border' => '#fecdd3', 'text' => '#9f1239', 'btn' => '#f43f5e', 'btnHover' => '#e11d48'],
        'amber' => ['bg' => '#fffbeb', 'border' => '#fde68a', 'text' => '#92400e', 'btn' => '#f59e0b', 'btnHover' => '#d97706'],
        'orange' => ['bg' => '#fff7ed', 'border' => '#fed7aa', 'text' => '#9a3412', 'btn' => '#f97316', 'btnHover' => '#ea580c'],
        'slate' => ['bg' => '#f8fafc', 'border' => '#e2e8f0', 'text' => '#1e293b', 'btn' => '#475569', 'btnHover' => '#334155'],
    ];
    
    $theme = $colorMap[$mainColor] ?? $colorMap['slate'];
@endphp

<style>
    .form-container {
        padding: 30px;
        background-color: #f8f9fc;
        min-height: 100vh;
    }
    
    .premium-card {
        background: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 4px 25px rgba(0,0,0,0.06);
        max-width: 900px;
        margin: 0 auto;
        border: 1px solid #eef2f7;
    }
    
    .card-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: {{ $theme['text'] }};
        margin-bottom: 30px;
        border-bottom: 2px solid {{ $theme['bg'] }};
        padding-bottom: 15px;
    }
    
    .form-group label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }
    
    .form-control {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 12px 18px;
        height: auto;
        font-size: 1rem;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: {{ $theme['btn'] }};
        box-shadow: 0 0 0 4px {{ $theme['bg'] }};
    }
    
    .btn-submit {
        background: {{ $theme['btn'] }};
        color: white;
        padding: 14px 35px;
        border-radius: 10px;
        font-weight: 700;
        border: none;
        transition: all 0.3s;
        width: 100%;
    }
    
    .btn-submit:hover {
        background: {{ $theme['btnHover'] }};
        transform: translateY(-2px);
    }
    
    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
        padding: 14px 35px;
        border-radius: 10px;
        font-weight: 700;
        border: none;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        width: 100%;
    }
    
    .btn-cancel:hover {
        background: #e2e8f0;
        color: #334155;
    }
    
    .toggle-section {
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        border: 1px dashed {{ $theme['border'] }};
    }
    
    .custom-checkbox {
        width: 20px;
        height: 20px;
        accent-color: {{ $theme['btn'] }};
    }
</style>

<div class="form-container">
    <div class="premium-card">
        <h2 class="card-title">
            <i class="fas {{ $mainIcon }} mr-2"></i> تعديل [ {{ $account->aname }} ]
        </h2>
        
        <form action="{{ route('accounts.update', ['acc' => $accType, 'id' => $account->id]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="code">الكود الرقمي (غير قابل للتعديل)</label>
                        <input type="text" name="code" id="code" class="form-control" value="{{ $account->code }}" readonly>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="aname">اسم الحساب / الجهة</label>
                        <input type="text" name="aname" id="aname" class="form-control @error('aname') is-invalid @enderror" value="{{ old('aname', $account->aname) }}" placeholder="ادخل الاسم الكامل للجهة" required onkeyup="checkAccountName(this.value, {{ $account->id }})">
                        <div id="check-result"></div>
                        @error('aname')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="parent_id">ينتمي إلى (الحساب الأب)</label>
                        <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror" required>
                            @foreach($parentAccounts as $pAcc)
                                <option value="{{ $pAcc->id }}" {{ $account->parent_id == $pAcc->id ? 'selected' : '' }}>{{ $pAcc->code }} - {{ $pAcc->aname }}</option>
                            @endforeach
                        </select>
                        @error('parent_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="is_basic">نوع الحساب</label>
                        <input type="text" class="form-control" value="{{ $account->is_basic ? 'حساب رئيسي (تجميعي)' : 'حساب فرعي (يقبل حركة)' }}" readonly>
                        <input type="hidden" name="is_basic" value="{{ $account->is_basic }}">
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">رقم الهاتف التواصل</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $account->phone) }}" placeholder="اختيارى">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address">العنوان</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $account->address) }}" placeholder="اختيارى">
                    </div>
                </div>
            </div>

            <div class="toggle-section mt-4 mb-4">
                <h5 class="mb-3 font-weight-bold text-muted"><i class="fas fa-cog mr-2"></i> خصائص الحساب والمميزات</h5>
                <div class="row">
                    <div class="col-md-3">
                        <label class="d-flex align-items-center gap-2">
                            <input type="checkbox" name="is_fund" value="1" class="custom-checkbox" {{ $account->is_fund ? 'checked' : '' }}>
                            <span>صندوق مالي</span>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="d-flex align-items-center gap-2">
                            <input type="checkbox" name="rentable" value="1" class="custom-checkbox" {{ $account->rentable ? 'checked' : '' }}>
                            <span>قابل للإيجار</span>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="d-flex align-items-center gap-2">
                            <input type="checkbox" name="is_stock" value="1" class="custom-checkbox" {{ $account->is_stock ? 'checked' : '' }}>
                            <span>مخزن بضاعة</span>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="d-flex align-items-center gap-2">
                            <input type="checkbox" name="secret" value="1" class="custom-checkbox" {{ $account->secret ? 'checked' : '' }}>
                            <span>حساب سري</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-8 mx-auto">
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save mr-2"></i> تحديث البيانات
                            </button>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('accounts.index', ['acc' => $accType]) }}" class="btn-cancel">
                                إلغاء
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function checkAccountName(val, id = null) {
    if (val.length < 3) return;
    $.get("{{ route('accounts.check-name') }}", { id: val, current_id: id }, function(data) {
        $("#check-result").html(data.message);
    });
}
</script>
@endsection
