@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <form id="validate_form" role="form" action="{{ route('contracts.update', ['id' => $contract->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $lang['lang_addhicont_newout'] ?? 'تعديل عقد خارجي' }}</h3>
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
                                    <label for="name">{{ $lang['lang_addhicont_name'] ?? 'الاسم' }}</label>
                                    <input name="name" data-parsley-trigger="keyup" required id="name" type="text" class="form-control" value="{{ old('name', $contract->name) }}">
                                </div>

                                <div class="form-group">
                                    <label for="jop">{{ $lang['lang_addhicont_jop'] ?? 'الوظيفة' }}</label>
                                    <select class="form-control" id="jop" name="jop" required>
                                        <option value="">اختر وظيفة</option>
                                        @foreach($jobs as $job)
                                            <option value="{{ $job->id }}" {{ old('jop', $contract->jop) == $job->id ? 'selected' : '' }}>
                                                {{ $job->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="jopdescription">{{ $lang['lang_addhicont_jopdescription'] ?? 'وصف الوظيفة' }}</label>
                                    <textarea name="jopdescription" data-parsley-trigger="keyup" required id="jopdescription" class="form-control" rows="5">{{ old('jopdescription', $contract->jopdescription) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="salary">{{ $lang['lang_addhicont_salaryagreement'] ?? 'اتفاق الراتب' }}</label>
                                    <input name="salary" data-parsley-trigger="keyup" required type="number" id="salary" class="form-control" value="{{ old('salary', $contract->salary) }}">
                                </div>

                                <div class="form-group">
                                    <label for="endcontract">{{ $lang['lang_addhicont_endcont'] ?? 'تاريخ انتهاء العقد' }}</label>
                                    <input name="endcontract" data-parsley-trigger="keyup" required type="date" id="endcontract" class="form-control" value="{{ old('endcontract', $contract->endcontract) }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="workhours">{{ $lang['lang_addhicont_workhours'] ?? 'ساعات العمل' }}</label>
                                    <input name="workhours" data-parsley-trigger="keyup" required type="number" id="workhours" class="form-control" value="{{ old('workhours', $contract->workhours) }}">
                                </div>

                                <div class="form-group">
                                    <label for="inorderhours">{{ $lang['lang_addhicont_inorderhours'] ?? 'ساعات إضافية' }}</label>
                                    <input name="inorderhours" data-parsley-trigger="keyup" required type="number" id="inorderhours" class="form-control" value="{{ old('inorderhours', $contract->inorderhours ?? 0) }}">
                                </div>

                                <div class="form-group">
                                    <label for="workdaysoff">{{ $lang['lang_addhicont_workdaysoff'] ?? 'أيام الإجازة' }}</label>
                                    <input name="workdaysoff" data-parsley-trigger="keyup" required type="number" id="workdaysoff" class="form-control" value="{{ old('workdaysoff', $contract->workdaysoff) }}">
                                </div>

                                <div class="form-group">
                                    <label for="info">{{ $lang['lang_addhicont_info'] ?? 'معلومات' }}</label>
                                    <textarea class="form-control" data-parsley-trigger="keyup" required name="info" id="info" rows="5">{{ old('info', $contract->info) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="user">{{ $lang['lang_addhicont_user'] ?? 'المستخدم' }}</label>
                                    <input name="user" data-parsley-trigger="keyup" required type="number" id="user" class="form-control" value="{{ old('user', $contract->user ?? session('userid')) }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="startcontract">{{ $lang['lang_addhicont_startcont'] ?? 'تاريخ بداية العقد' }}</label>
                                    <input name="startcontract" data-parsley-trigger="keyup" required type="date" id="startcontract" class="form-control" value="{{ old('startcontract', $contract->startcontract) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="joprule1">{{ $lang['lang_addhicont_rule'] ?? 'بند' }} 1</label>
                                    <input name="joprule1" data-parsley-trigger="keyup" required id="joprule1" type="text" class="form-control" value="{{ old('joprule1', $contract->joprule1) }}">
                                </div>
                                <div class="form-group">
                                    <label for="joprule2">{{ $lang['lang_addhicont_rule'] ?? 'بند' }} 2</label>
                                    <input name="joprule2" id="joprule2" type="text" class="form-control" value="{{ old('joprule2', $contract->joprule2) }}">
                                </div>
                                <div class="form-group">
                                    <label for="joprule3">{{ $lang['lang_addhicont_rule'] ?? 'بند' }} 3</label>
                                    <input name="joprule3" id="joprule3" type="text" class="form-control" value="{{ old('joprule3', $contract->joprule3) }}">
                                </div>
                                <div class="form-group">
                                    <label for="joprule4">{{ $lang['lang_addhicont_rule'] ?? 'بند' }} 4</label>
                                    <input name="joprule4" id="joprule4" type="text" class="form-control" value="{{ old('joprule4', $contract->joprule4) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">{{ $lang['lang_addhicont_confirm'] ?? 'تأكيد' }}</button>
                        <a href="{{ route('contracts.external.index') }}" class="btn btn-secondary btn-block">إلغاء</a>
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
