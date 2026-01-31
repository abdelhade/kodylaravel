@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <form id="validate_form" role="form" action="{{ route('contracts.update', ['id' => $contract->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $lang['lang_addhicont_newcont'] ?? 'تعديل عقد عمل' }}</h3>
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
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="employee">{{ $lang['lang_addhicont_employee'] ?? 'الموظف' }}</label>
                                    <select class="form-control" id="employee" name="employee" required>
                                        <option value="">اختر موظف</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ old('employee', $contract->employee) == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
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
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="jopdescription">{{ $lang['lang_addhicont_jopdescription'] ?? 'وصف الوظيفة' }}</label>
                                    <textarea name="jopdescription" data-parsley-trigger="keyup" required id="jopdescription" class="form-control" rows="5">{{ old('jopdescription', $contract->jopdescription) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="startcontract">{{ $lang['lang_addhicont_startcont'] ?? 'تاريخ بداية العقد' }}</label>
                                    <input name="startcontract" data-parsley-trigger="keyup" required type="date" id="startcontract" class="form-control" value="{{ old('startcontract', $contract->startcontract) }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="endcontract">{{ $lang['lang_addhicont_endcont'] ?? 'تاريخ انتهاء العقد' }}</label>
                                    <input name="endcontract" data-parsley-trigger="keyup" required type="date" id="endcontract" class="form-control" value="{{ old('endcontract', $contract->endcontract) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="workhours">{{ $lang['lang_addhicont_workhours'] ?? 'ساعات العمل' }}</label>
                                    <input name="workhours" data-parsley-trigger="keyup" required type="number" id="workhours" class="form-control" value="{{ old('workhours', $contract->workhours) }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inorderhours">{{ $lang['lang_addhicont_inorderhours'] ?? 'ساعات إضافية' }}</label>
                                    <input name="inorderhours" data-parsley-trigger="keyup" required type="number" id="inorderhours" class="form-control" value="{{ old('inorderhours', $contract->inorderhours ?? 0) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="workdaysoff">{{ $lang['lang_addhicont_workdaysoff'] ?? 'أيام الإجازة' }}</label>
                                    <input name="workdaysoff" data-parsley-trigger="keyup" required type="number" id="workdaysoff" class="form-control" value="{{ old('workdaysoff', $contract->workdaysoff) }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="info">{{ $lang['lang_addhicont_info'] ?? 'معلومات' }}</label>
                            <textarea class="form-control" data-parsley-trigger="keyup" required name="info" id="info" rows="5">{{ old('info', $contract->info) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>بنود الراتب</h3>
                    </div>
                    <div class="card-body">
                        <div class="row itemrow bg-warning" id="salary">
                            <div class="col">
                                <input value="ثابت" class="form-control" type="text" disabled>
                            </div>
                            <div class="col">
                                <input class="form-control" type="number" name="salary" id="salaryinput" required value="{{ old('salary', $contract->salary) }}" placeholder="الراتب">
                            </div>
                        </div>
                        <div id="allow-fotter">
                            @if($contractAllowances && $contractAllowances->count() > 0)
                                @foreach($contractAllowances as $allowance)
                                    <div class="row itemrow" id="itmrow">
                                        <div class="col">
                                            <select name="allow[]" class="form-control">
                                                @foreach($allowances as $allow)
                                                    <option value="{{ $allow->id }}" {{ $allowance->allowid == $allow->id ? 'selected' : '' }}>
                                                        {{ $allow->name }}{{ ($allow->tybe ?? 0) == 0 ? ' ## استقطاع ##' : '## بدلات ##' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input class="form-control" type="number" name="value[]" value="{{ $allowance->value }}" placeholder="القيمة">
                                        </div>
                                        <div class="col col-1">
                                            <button class="btn btn-danger btn-danger-row btn-sm" type="button">X</button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-info" id="addrow" type="button">إضافة بند جديد</button>
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h4>بنود التعاقد</h4>
                    </div>
                    <div class="card-body">
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
                        @php
                            $routeName = $contract->type == 1 ? 'contracts.training.index' : ($contract->type == 2 ? 'contracts.external.index' : 'contracts.hiring.index');
                        @endphp
                        <a href="{{ route($routeName) }}" class="btn btn-secondary btn-block">إلغاء</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('native/dist/js/parsley.js') }}"></script>
<script>
$(document).ready(function() {
    $("#validate_form").parsley();
    
    $("#addrow").click(function(){
        var allowanceOptions = @json($allowances->map(function($a) {
            return [
                'id' => $a->id,
                'name' => $a->name,
                'tybe' => $a->tybe ?? 0
            ];
        }));
        
        var optionsHtml = '';
        allowanceOptions.forEach(function(allow) {
            var typeText = allow.tybe == 0 ? ' ## استقطاع ##' : '## بدلات ##';
            optionsHtml += '<option value="' + allow.id + '">' + allow.name + typeText + '</option>';
        });
        
        $("#allow-fotter").append(`
            <div class="row itemrow" id="itmrow">
                <div class="col">
                    <select name="allow[]" class="form-control">
                        ${optionsHtml}
                    </select>
                </div>
                <div class="col">
                    <input class="form-control" type="number" name="value[]" placeholder="القيمة">
                </div>
                <div class="col col-1">
                    <button class="btn btn-danger btn-danger-row btn-sm" type="button">X</button>
                </div>
            </div>
        `);
    });
    
    $(document).on("click", ".btn-danger-row", function() {
        $(this).closest(".itemrow").remove();
    });
    
    $("#salaryinput").focusout(function(){
        $("#addrow").focus();
    });
});
</script>
@endsection
