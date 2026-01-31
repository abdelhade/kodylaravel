@extends('layouts.master')

@section('content')
<style>
    .client-form-container {
        padding: 30px;
        background-color: #f8f9fc;
        min-height: 100vh;
    }
    
    .client-card {
        background: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        max-width: 1000px;
        margin: 0 auto;
        border: 1px solid #eef2f7;
    }
    
    .card-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 30px;
        border-bottom: 2px solid #f7fafc;
        padding-bottom: 15px;
    }
    
    .form-group label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }
    
    .form-control {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 12px 15px;
        height: auto;
        font-size: 1rem;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    }
    
    .btn-submit {
        background: #2d3748;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s;
        width: 100%;
    }
    
    .btn-submit:hover {
        background: #1a202c;
        transform: translateY(-1px);
    }
    
    .btn-cancel {
        background: #edf2f7;
        color: #4a5568;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        width: 100%;
    }
    
    .btn-cancel:hover {
        background: #e2e8f0;
        color: #2d3748;
    }
</style>

<div class="client-form-container">
    <div class="client-card">
        <h2 class="card-title">
            <i class="fas fa-user-plus mr-2"></i> عميل جديد
        </h2>
        
        <form action="{{ route('clients.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">الاسم</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="ادخل اسم العميل" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">رقم الهاتف</label>
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="ادخل رقم الهاتف">
                        @error('phone')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="city">المدينة</label>
                        <select name="city" id="city" class="form-control @error('city') is-invalid @enderror">
                            <option value="">اختر المدينة</option>
                            @foreach($towns as $town)
                                <option value="{{ $town->id }}" {{ old('city') == $town->id ? 'selected' : '' }}>{{ $town->name }}</option>
                            @endforeach
                        </select>
                        @error('city')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address">العنوان</label>
                        <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" placeholder="ادخل العنوان">
                        @error('address')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="gender">النوع</label>
                        <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>ذكر</option>
                            <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>انثى</option>
                        </select>
                        @error('gender')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="height">الطول (سم)</label>
                        <input type="number" name="height" id="height" class="form-control @error('height') is-invalid @enderror" value="{{ old('height') }}" placeholder="ادخل الطول">
                        @error('height')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="weight">الوزن (كجم)</label>
                        <input type="number" name="weight" id="weight" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight') }}" placeholder="ادخل الوزن">
                        @error('weight')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dateofbirth">تاريخ الميلاد</label>
                        <input type="date" name="dateofbirth" id="dateofbirth" class="form-control @error('dateofbirth') is-invalid @enderror" value="{{ old('dateofbirth') }}">
                        @error('dateofbirth')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ref">رقم الرفيق / المرجع</label>
                        <input type="text" name="ref" id="ref" class="form-control @error('ref') is-invalid @enderror" value="{{ old('ref') }}" placeholder="رقم الرفيق">
                        @error('ref')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="diseses">امراض مزمنة</label>
                        <textarea name="diseses" id="diseses" rows="4" class="form-control @error('diseses') is-invalid @enderror" placeholder="ادخل الامراض المزمنة ان وجدت">{{ old('diseses') }}</textarea>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="info">ملاحظات اخرى</label>
                        <textarea name="info" id="info" rows="4" class="form-control @error('info') is-invalid @enderror" placeholder="ملاحظات اضافية">{{ old('info') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-8 mx-auto">
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save mr-2"></i> حفظ البيانات
                            </button>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('clients.index') }}" class="btn-cancel">
                                إلغاء
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
