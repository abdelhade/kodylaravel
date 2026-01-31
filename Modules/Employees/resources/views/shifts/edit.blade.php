@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">{{ $lang['lang_infoshift'] ?? 'معلومات الوردية' }}</h3>
                </div>
                <form role="form" action="{{ route('shifts.update', ['id' => $shift->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">{{ $lang['lang_addhicont_name'] ?? 'اسم الوردية' }}</label>
                                    <input name="name" id="name" type="text" class="form-control" placeholder="اسم الورديه" value="{{ old('name', $shift->name) }}" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mt-4">
                                    <label for="">{{ $lang['lang_workday'] ?? 'أيام العمل' }}</label>
                                </div>
                                @php
                                    $workingDays = $shift->workingDaysArray ?? explode(',', $shift->workingdays ?? '');
                                @endphp
                                <div class="form-check form-switch">
                                    <input name="sat" class="form-check-input" type="checkbox" role="switch" id="sat" {{ in_array('6', $workingDays) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sat">{{ $lang['lang_addsh_sat'] ?? 'السبت' }}</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input name="sun" class="form-check-input" type="checkbox" role="switch" id="sun" {{ in_array('7', $workingDays) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sun">{{ $lang['lang_addsh_sun'] ?? 'الأحد' }}</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input name="mon" class="form-check-input" type="checkbox" role="switch" id="mon" {{ in_array('1', $workingDays) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="mon">{{ $lang['lang_addsh_mon'] ?? 'الاثنين' }}</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input name="tus" class="form-check-input" type="checkbox" role="switch" id="tus" {{ in_array('2', $workingDays) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tus">{{ $lang['lang_addsh_tue'] ?? 'الثلاثاء' }}</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input name="wed" class="form-check-input" type="checkbox" role="switch" id="wed" {{ in_array('3', $workingDays) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="wed">{{ $lang['lang_addsh_wed'] ?? 'الأربعاء' }}</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input name="thur" class="form-check-input" type="checkbox" role="switch" id="thur" {{ in_array('4', $workingDays) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="thur">{{ $lang['lang_addsh_thu'] ?? 'الخميس' }}</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input name="fri" class="form-check-input" type="checkbox" role="switch" id="fri" {{ in_array('5', $workingDays) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="fri">{{ $lang['lang_addsh_fri'] ?? 'الجمعة' }}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">{{ $lang['lang_Attendance_rules'] ?? 'قواعد الحضور' }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">{{ $lang['lang_addsh_start'] ?? 'بداية الوردية' }}</label>
                                        <input name="shiftstart" type="time" class="form-control" value="{{ old('shiftstart', $shift->shiftstart) }}" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">{{ $lang['lang_addsh_end'] ?? 'نهاية الوردية' }}</label>
                                        <input name="shiftend" type="time" class="form-control" value="{{ old('shiftend', $shift->shiftend) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">{{ $lang['lang_addsh_stardatt'] ?? 'بداية وقت الحضور' }}</label>
                                        <input name="instart" type="time" class="form-control" value="{{ old('instart', $shift->instart) }}" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">{{ $lang['lang_addsh_endatt'] ?? 'نهاية وقت الحضور' }}</label>
                                        <input name="inend" type="time" class="form-control" value="{{ old('inend', $shift->inend) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">{{ $lang['lang_addsh_startout'] ?? 'بداية وقت الانصراف' }}</label>
                                        <input name="outstart" type="time" class="form-control" value="{{ old('outstart', $shift->outstart) }}" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">{{ $lang['lang_addsh_endout'] ?? 'نهاية وقت الانصراف' }}</label>
                                        <input name="outend" type="time" class="form-control" value="{{ old('outend', $shift->outend) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">{{ $lang['lang_addsh_delaylimits'] ?? 'حد التأخير (دقائق)' }}</label>
                                        <input name="latelimit" type="number" class="form-control" value="{{ old('latelimit', $shift->latelimit ?? 0) }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">{{ $lang['lang_addsh_earlylimits'] ?? 'حد الانصراف المبكر (دقائق)' }}</label>
                                        <input name="earlylimit" type="number" class="form-control" value="{{ old('earlylimit', $shift->earlylimit ?? 0) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning btn-block">{{ $lang['lang_addhicont_confirm'] ?? 'تأكيد' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
