@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>إضافة نشاط جديد</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('activities.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="title">العنوان <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="type_id">نوع النشاط <span class="text-danger">*</span></label>
                                <select class="form-control @error('type_id') is-invalid @enderror" 
                                        id="type_id" name="type_id" required>
                                    <option value="">اختر النوع</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="related_to">متعلق بـ <span class="text-danger">*</span></label>
                                <select class="form-control @error('related_to') is-invalid @enderror" 
                                        id="related_to" name="related_to" required>
                                    <option value="">اختر النوع</option>
                                    <option value="lead" {{ old('related_to') == 'lead' ? 'selected' : '' }}>عميل محتمل</option>
                                    <option value="contact" {{ old('related_to') == 'contact' ? 'selected' : '' }}>جهة اتصال</option>
                                    <option value="opportunity" {{ old('related_to') == 'opportunity' ? 'selected' : '' }}>فرصة</option>
                                </select>
                                @error('related_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="related_id">الجهة المرتبطة <span class="text-danger">*</span></label>
                                <select class="form-control @error('related_id') is-invalid @enderror" 
                                        id="related_id" name="related_id" required>
                                    <option value="">اختر الجهة</option>
                                </select>
                                @error('related_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="activity_date">تاريخ النشاط <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('activity_date') is-invalid @enderror" 
                                       id="activity_date" name="activity_date" value="{{ old('activity_date') }}" required>
                                @error('activity_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="duration">المدة (بالدقائق)</label>
                                <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                                       id="duration" name="duration" value="{{ old('duration', 0) }}" min="0">
                                @error('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">الحالة <span class="text-danger">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="planned" {{ old('status') == 'planned' ? 'selected' : '' }}>مخطط</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">الوصف</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                                <a href="{{ route('activities.index') }}" class="btn btn-secondary">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('related_to').addEventListener('change', function() {
            const relatedId = document.getElementById('related_id');
            relatedId.innerHTML = '<option value="">اختر الجهة</option>';
            
            if (this.value === 'lead') {
                @foreach($leads as $lead)
                    relatedId.innerHTML += '<option value="{{ $lead->id }}">{{ $lead->name }}</option>';
                @endforeach
            } else if (this.value === 'contact') {
                @foreach($contacts as $contact)
                    relatedId.innerHTML += '<option value="{{ $contact->id }}">{{ $contact->name }}</option>';
                @endforeach
            }
        });
    </script>

@endsection
