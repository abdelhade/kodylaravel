@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تعديل الفرصة</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('opportunities.update') }}?id={{ $opportunity->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">العنوان <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                               id="title" name="title" value="{{ old('title', $opportunity->title) }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lead_id">العميل المحتمل <span class="text-danger">*</span></label>
                                        <select class="form-control @error('lead_id') is-invalid @enderror" 
                                                id="lead_id" name="lead_id" required>
                                            <option value="">اختر العميل المحتمل</option>
                                            @foreach($leads as $lead)
                                                <option value="{{ $lead->id }}" {{ old('lead_id', $opportunity->lead_id) == $lead->id ? 'selected' : '' }}>
                                                    {{ $lead->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('lead_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stage_id">المرحلة <span class="text-danger">*</span></label>
                                        <select class="form-control @error('stage_id') is-invalid @enderror" 
                                                id="stage_id" name="stage_id" required>
                                            <option value="">اختر المرحلة</option>
                                            @foreach($stages as $stage)
                                                <option value="{{ $stage->id }}" {{ old('stage_id', $opportunity->stage_id) == $stage->id ? 'selected' : '' }}>
                                                    {{ $stage->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('stage_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount">المبلغ</label>
                                        <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                                               id="amount" name="amount" value="{{ old('amount', $opportunity->amount) }}">
                                        @error('amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="probability">احتمالية النجاح (%)</label>
                                        <input type="number" min="0" max="100" class="form-control @error('probability') is-invalid @enderror" 
                                               id="probability" name="probability" value="{{ old('probability', $opportunity->probability) }}">
                                        @error('probability')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expected_close_date">تاريخ الإغلاق المتوقع</label>
                                        <input type="date" class="form-control @error('expected_close_date') is-invalid @enderror" 
                                               id="expected_close_date" name="expected_close_date" value="{{ old('expected_close_date', $opportunity->expected_close_date) }}">
                                        @error('expected_close_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">الوصف</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4">{{ old('description', $opportunity->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">تحديث</button>
                                <a href="{{ route('opportunities.index') }}" class="btn btn-secondary">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
