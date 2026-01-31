@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">تعديل بصمة يدوية</h3>
                </div>
                <form role="form" action="{{ route('manual-attendance.update', ['id' => $attendance->id]) }}" method="post">
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

                        <div class="form-group col-md-3">
                            <label for="employee">{{ $lang['lang_adfp_employee'] ?? 'الموظف' }}</label>
                            <select class="form-control" name="employee" id="emp" required>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('employee', $attendance->employee) == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="fptybe">{{ $lang['lang_adfp_fptype'] ?? 'نوع البصمة' }}</label>
                            <select class="form-control" name="fptybe" id="fptybe" required>
                                @foreach($fpTypes as $fpType)
                                    <option value="{{ $fpType->id }}" {{ old('fptybe', $attendance->fptybe) == $fpType->id ? 'selected' : '' }}>
                                        {{ $fpType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="fpdate">{{ $lang['lang_adfp_day'] ?? 'اليوم' }}</label>
                            <input class="form-control" type="date" name="fpdate" id="fpdate" value="{{ old('fpdate', $attendance->fpdate) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="fptime">{{ $lang['lang_adfp_time'] ?? 'الوقت' }}</label>
                            <input class="form-control" type="time" name="fptime" id="fptime" value="{{ old('fptime', $attendance->time) }}" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">{{ $lang['lang_publicconfirm'] ?? 'تأكيد' }}</button>
                        <a href="{{ route('manual-attendance.index') }}" class="btn btn-secondary btn-block">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('native/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('#emp').select2();
});
</script>
@endsection
