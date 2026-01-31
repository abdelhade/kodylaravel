@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">تعديل سيرة ذاتية</h3>
                </div>
                <form id="validate_form" role="form" action="{{ route('cvs.update', ['id' => $cv->id]) }}" method="POST">
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

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">{{ $lang['lang_addhicont_name'] ?? 'الاسم' }}</label>
                                    <input name="name" data-parsley-trigger="keyup" required id="name" type="text" class="form-control" value="{{ old('name', $cv->name) }}">
                                </div>
                                <div class="form-group">
                                    <label for="degree">الشهادة الجامعية</label>
                                    <input name="degree" type="text" data-parsley-trigger="keyup" required id="degree" class="form-control" value="{{ old('degree', $cv->degree) }}">
                                </div>
                                <div class="form-group">
                                    <label for="address">العنوان</label>
                                    <input name="address" data-parsley-trigger="keyup" required type="text" id="address" class="form-control" value="{{ old('address', $cv->address) }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="birthdate">تاريخ الميلاد</label>
                                    <input name="birthdate" data-parsley-trigger="keyup" required type="date" id="birthdate" class="form-control" value="{{ old('birthdate', $cv->birthdate) }}">
                                </div>
                                <div class="form-group">
                                    <label for="phone">رقم الهاتف</label>
                                    <input name="phone" data-parsley-trigger="keyup" required type="number" id="phone" class="form-control" value="{{ old('phone', $cv->phone) }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">الإيميل</label>
                                    <input name="email" data-parsley-trigger="keyup" type="email" id="email" class="form-control" value="{{ old('email', $cv->email) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="skills">المهارات</label>
                                    <textarea class="form-control" data-parsley-trigger="keyup" required name="skills" id="skills" rows="5">{{ old('skills', $cv->skills) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="exp1">الخبرة 1</label>
                                    <input name="exp1" data-parsley-trigger="keyup" required id="exp1" type="text" class="form-control" value="{{ old('exp1', $cv->exp1) }}">
                                </div>
                                <div class="form-group">
                                    <label for="exp2">الخبرة 2</label>
                                    <input name="exp2" id="exp2" type="text" class="form-control" value="{{ old('exp2', $cv->exp2) }}">
                                </div>
                                <div class="form-group">
                                    <label for="exp3">الخبرة 3</label>
                                    <input name="exp3" id="exp3" type="text" class="form-control" value="{{ old('exp3', $cv->exp3) }}">
                                </div>
                                <div class="form-group">
                                    <label for="exp4">الخبرة 4</label>
                                    <input name="exp4" id="exp4" type="text" class="form-control" value="{{ old('exp4', $cv->exp4) }}">
                                </div>
                                <div class="form-group">
                                    <label for="exp5">الخبرة 5</label>
                                    <input name="exp5" id="exp5" type="text" class="form-control" value="{{ old('exp5', $cv->exp5) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="lastsalary">آخر راتب</label>
                                    <input name="lastsalary" id="lastsalary" type="text" class="form-control" value="{{ old('lastsalary', $cv->lastsalary) }}">
                                </div>
                                <div class="form-group">
                                    <label for="expsalary">الراتب المتوقع</label>
                                    <input name="expsalary" id="expsalary" type="text" class="form-control" value="{{ old('expsalary', $cv->expsalary) }}">
                                </div>
                                <div class="form-group">
                                    <label for="referances">المراجع</label>
                                    <textarea name="referances" id="referances" class="form-control" rows="3">{{ old('referances', $cv->referances) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">{{ $lang['lang_addhicont_confirm'] ?? 'تأكيد' }}</button>
                        <a href="{{ route('cvs.index') }}" class="btn btn-secondary btn-block">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('native/plugins/parsleyjs/parsley.min.js') }}"></script>
<script>
$(document).ready(function() {
    $("#validate_form").parsley();
});
</script>
@endsection
