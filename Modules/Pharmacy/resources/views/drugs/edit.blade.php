@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">تعديل دواء</h3>
                </div>
                <form id="validate_form" role="form" action="{{ route('drugs.update', ['id' => $drug->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="name">اسم الدواء <span class="text-danger">*</span></label>
                            <input name="name" data-parsley-trigger="keyup" required id="name" type="text" class="form-control" value="{{ old('name', $drug->name) }}" placeholder="أدخل اسم الدواء">
                        </div>

                        <div class="form-group">
                            <label for="effectivematerial">المادة الفعالة</label>
                            <input name="effectivematerial" data-parsley-trigger="keyup" type="text" id="effectivematerial" class="form-control" value="{{ old('effectivematerial', $drug->effectivematerial) }}" placeholder="أدخل المادة الفعالة">
                        </div>

                        <div class="form-group">
                            <label for="purpose">الغرض</label>
                            <textarea class="form-control" data-parsley-trigger="keyup" name="purpose" id="purpose" rows="3" placeholder="أدخل الغرض من استخدام الدواء">{{ old('purpose', $drug->purpose) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="sideeffects">الأعراض الجانبية</label>
                            <textarea class="form-control" data-parsley-trigger="keyup" name="sideeffects" id="sideeffects" rows="3" placeholder="أدخل الأعراض الجانبية">{{ old('sideeffects', $drug->sideeffects) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="info">ملاحظات</label>
                            <textarea class="form-control" data-parsley-trigger="keyup" name="info" id="info" rows="3" placeholder="أدخل أي ملاحظات إضافية">{{ old('info', $drug->info) }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">{{ $lang['lang_addhicont_confirm'] ?? 'تأكيد' }}</button>
                        <a href="{{ route('drugs.index') }}" class="btn btn-secondary btn-block">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('native/dist/js/parsley.js') }}"></script>
<script>
$(document).ready(function() {
    $("#validate_form").parsley();
});
</script>
@endsection
