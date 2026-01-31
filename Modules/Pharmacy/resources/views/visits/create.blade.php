@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <form id="validate_form" role="form" action="{{ route('visits.store') }}" method="POST">
                @csrf
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">بيانات الزيارة</h3>
                    </div>
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

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="client">اسم المريض <span class="text-danger">*</span></label>
                                    <select name="client" id="client" class="form-control" required>
                                        <option value="">اختر مريض</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" {{ old('client') == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="complaint">الشكوى <span class="text-danger">*</span></label>
                                    <textarea name="complaint" id="complaint" class="form-control" rows="5" required placeholder="أدخل الشكوى">{{ old('complaint') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="diagnosis">التشخيص</label>
                                    <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3" placeholder="أدخل التشخيص">{{ old('diagnosis') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="recommendation">التوصيات</label>
                                    <textarea name="recommendation" id="recommendation" class="form-control" rows="3" placeholder="أدخل التوصيات">{{ old('recommendation') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="prescription">الوصفة</label>
                                    <textarea name="prescription" id="prescription" class="form-control" rows="3" placeholder="أدخل الوصفة">{{ old('prescription') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">{{ $lang['lang_addhicont_confirm'] ?? 'تأكيد' }}</button>
                        <a href="{{ route('visits.index') }}" class="btn btn-secondary btn-block">إلغاء</a>
                    </div>
                </div>
            </form>
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
