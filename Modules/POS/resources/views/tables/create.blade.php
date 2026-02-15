@extends('layouts.master')

@section('title', 'إضافة طاولة')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-plus me-2"></i>إضافة طاولة جديدة</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pos.tables.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="tname" class="form-label">اسم الطاولة</label>
                            <input type="text" class="form-control @error('tname') is-invalid @enderror" 
                                   id="tname" name="tname" value="{{ old('tname') }}" required>
                            @error('tname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="table_case" class="form-label">الحالة</label>
                            <select class="form-select @error('table_case') is-invalid @enderror" 
                                    id="table_case" name="table_case" required>
                                <option value="">اختر الحالة</option>
                                <option value="0" {{ old('table_case') == 0 ? 'selected' : '' }}>متاحة</option>
                                <option value="1" {{ old('table_case') == 1 ? 'selected' : '' }}>محجوزة</option>
                                <option value="2" {{ old('table_case') == 2 ? 'selected' : '' }}>صيانة</option>
                            </select>
                            @error('table_case')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i>حفظ
                            </button>
                            <a href="{{ route('pos.tables.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
