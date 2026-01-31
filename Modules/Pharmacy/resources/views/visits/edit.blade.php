@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <form id="validate_form" role="form" action="{{ route('visits.update', ['id' => $visit->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">تعديل بيانات الزيارة</h3>
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
                                    <label for="client">اسم المريض</label>
                                    <input type="text" class="form-control" value="{{ $client->name ?? '' }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="complaint">الشكوى <span class="text-danger">*</span></label>
                                    <textarea name="complaint" id="complaint" class="form-control" rows="5" required>{{ old('complaint', $visit->complaint) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="diagnosis">التشخيص</label>
                                    <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3">{{ old('diagnosis', $visit->diagnosis) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="recommendation">التوصيات</label>
                                    <textarea name="recommendation" id="recommendation" class="form-control" rows="3">{{ old('recommendation', $visit->recommendation) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="prescription">الوصفة</label>
                                    <textarea name="prescription" id="prescription" class="form-control" rows="3">{{ old('prescription', $visit->prescription) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning btn-block">{{ $lang['lang_addhicont_confirm'] ?? 'تأكيد' }}</button>
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
