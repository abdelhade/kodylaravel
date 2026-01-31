@extends('layouts.master')

@section('content')
<style>
    .supplier-form-container {
        padding: 30px;
        background-color: #f8f9fc;
        min-height: 100vh;
    }
    
    .supplier-card {
        background: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        max-width: 800px;
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
        background: #4c51bf;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s;
        width: 100%;
    }
    
    .btn-submit:hover {
        background: #434190;
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

<div class="supplier-form-container">
    <div class="supplier-card">
        <h2 class="card-title">
            <i class="fas fa-edit mr-2 text-warning"></i> تعديل بيانات المورد [ {{ $supplier->aname }} ]
        </h2>
        
        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="code">الكود</label>
                        <input type="text" name="code" id="code" class="form-control" value="{{ $supplier->code }}" readonly>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="aname">اسم المورد</label>
                        <input type="text" name="aname" id="aname" class="form-control @error('aname') is-invalid @enderror" value="{{ old('aname', $supplier->aname) }}" placeholder="ادخل اسم المورد" required>
                        @error('aname')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">رقم الهاتف</label>
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $supplier->phone) }}" placeholder="ادخل رقم الهاتف">
                        @error('phone')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address">العنوان</label>
                        <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $supplier->address) }}" placeholder="ادخل العنوان">
                        @error('address')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
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
                            <a href="{{ route('suppliers.index') }}" class="btn-cancel">
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
