@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <form class="validate_form" autocomplete="off" id="validate_form" action="{{ route('employees.update') }}?id={{ $employee->id }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ $lang['lang_addemployee_personalinfo'] ?? 'المعلومات الشخصية' }}</h3>
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
                                            <label for="name">{{ $lang['lang_addemployee_name'] ?? 'الاسم' }}</label>
                                            <input type="text" required minlength="6" maxlength="50" autocomplete="off" class="form-control form-control-sm" id="name" name="name" value="{{ old('name', $employee->name) }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">{{ $lang['lang_addemployee_phone'] ?? 'التليفون' }}</label>
                                            <input type="text" autocomplete="off" class="form-control form-control-sm" name="number" id="phone" value="{{ old('number', $employee->number) }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="email">{{ $lang['lang_addemployee_email'] ?? 'البريد الإلكتروني' }}</label>
                                            <input type="email" autocomplete="off" class="form-control form-control-sm" name="email" id="email" value="{{ old('email', $employee->email) }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">{{ $lang['lang_addemployee_image'] ?? 'الصورة' }}</label>
                                            @if($employee->imgs)
                                                <p>الصورة الحالية: {{ $employee->imgs }}</p>
                                            @endif
                                            <input name="imgs" autocomplete="off" type="file" class="form-control" id="exampleInputFile" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="date">{{ $lang['lang_addemployee_dateofbirth'] ?? 'تاريخ الميلاد' }}</label>
                                            <input type="date" autocomplete="off" class="form-control form-control-sm" name="dateofbirth" id="date" value="{{ old('dateofbirth', $employee->dateofbirth) }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>{{ $lang['lang_addemployee_gender'] ?? 'الجنس' }}</label>
                                            <select name="gender" class="form-select">
                                                <option value="0" {{ old('gender', $employee->gender) == 0 ? 'selected' : '' }}>{{ $lang['lang_addemployee_male'] ?? 'ذكر' }}</option>
                                                <option value="1" {{ old('gender', $employee->gender) == 1 ? 'selected' : '' }}>{{ $lang['lang_addemployee_female'] ?? 'أنثى' }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="info">{{ $lang['lang_addemployee_info'] ?? 'معلومات' }}</label>
                                    <textarea name="info" class="form-control form-control-sm" rows="4" id="info">{{ old('info', $employee->info) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input name="active" class="form-check-input" type="checkbox" {{ old('active', $employee->active) ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $lang['lang_addemployee_active'] ?? 'نشط' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ $lang['lang_addemployee_details'] ?? 'التفاصيل' }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="address">{{ $lang['lang_addemployee_address'] ?? 'العنوان' }} 1</label>
                                    <input type="text" autocomplete="off" class="form-control form-control-sm" id="address" name="address" value="{{ old('address', $employee->address) }}">
                                </div>
                                <div class="form-group">
                                    <label for="address2">{{ $lang['lang_addemployee_address'] ?? 'العنوان' }} 2</label>
                                    <input type="text" autocomplete="off" class="form-control form-control-sm" id="address2" name="address2" value="{{ old('address2', $employee->address2) }}">
                                </div>
                                <div class="form-group">
                                    <label>{{ $lang['lang_addemployee_country'] ?? 'المدينة' }}</label>
                                    <select name="town" class="form-select">
                                        @foreach($towns as $town)
                                            <option value="{{ $town->id }}" {{ old('town', $employee->town) == $town->id ? 'selected' : '' }}>{{ $town->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ $lang['lang_addemployee_jobinfo'] ?? 'معلومات الوظيفة' }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>{{ $lang['lang_addemployee_job'] ?? 'الوظيفة' }}</label>
                                            <select name="jop" class="form-select" required>
                                                @foreach($jobs as $job)
                                                    <option value="{{ $job->id }}" {{ old('jop', $employee->jop) == $job->id ? 'selected' : '' }}>{{ $job->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ $lang['lang_addemployee_jobdepart'] ?? 'القسم' }}</label>
                                            <select name="department" class="form-select">
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}" {{ old('department', $employee->department) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>{{ $lang['lang_addemployee_joplevel'] ?? 'مستوى الوظيفة' }}</label>
                                            <select name="joplevel" class="form-select">
                                                @foreach($jopLevels as $level)
                                                    <option value="{{ $level->id }}" {{ old('joplevel', $employee->joplevel) == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ $lang['lang_addemployee_jobtype'] ?? 'نوع الوظيفة' }}</label>
                                            <select name="joptybe" class="form-select">
                                                @foreach($jopTypes as $type)
                                                    <option value="{{ $type->id }}" {{ old('joptybe', $employee->joptybe) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="start_date">{{ $lang['lang_addemployee_jobstart'] ?? 'تاريخ البدء' }}</label>
                                            <input type="date" class="form-control form-control-sm" name="dateofhire" id="start_date" value="{{ old('dateofhire', $employee->dateofhire) }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="end_date">{{ $lang['lang_addemployee_jobend'] ?? 'تاريخ الانتهاء' }}</label>
                                            <input type="date" class="form-control form-control-sm" name="dateofend" id="end_date" value="{{ old('dateofend', $employee->dateofend) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ $lang['lang_addemployee_salaries'] ?? 'الرواتب' }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="salary">{{ $lang['lang_addemployee_salary'] ?? 'الراتب' }}</label>
                                            <input type="text" autocomplete="off" class="form-control form-control-sm" id="salary" name="salary" value="{{ old('salary', $employee->salary) }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>{{ $lang['lang_addemployee_shift'] ?? 'الشيفت' }}</label>
                                            <select name="shift" class="form-select">
                                                @foreach($shifts as $shift)
                                                    <option value="{{ $shift->id }}" {{ old('shift', $employee->shift) == $shift->id ? 'selected' : '' }}>{{ $shift->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="hour_extra">الساعة الاضافي تحسب ك</label>
                                            <input type="number" autocomplete="off" class="form-control form-control-sm" id="hour_extra" name="hour_extra" value="{{ old('hour_extra', $employee->hour_extra ?? '1.50') }}" step="0.001">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="day_extra">اليوم الاضافي يحسب ك</label>
                                            <input type="number" autocomplete="off" class="form-control form-control-sm" id="day_extra" name="day_extra" value="{{ old('day_extra', $employee->day_extra ?? '1.50') }}" step="0.001">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="basma_id">{{ $lang['lang_addemployee_basmaid'] ?? 'معرف البصمة' }}</label>
                                            <input type="text" autocomplete="off" class="form-control form-control-sm" name="basma_id" id="basma_id" value="{{ old('basma_id', $employee->basma_id) }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="basma_name">{{ $lang['lang_addemployee_basmaname'] ?? 'اسم البصمة' }}</label>
                                            <input type="text" autocomplete="off" class="form-control form-control-sm" name="basma_name" id="basma_name" value="{{ old('basma_name', $employee->basma_name) }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="password">{{ $lang['lang_addemployee_password'] ?? 'كلمة المرور' }}</label>
                                            <input type="password" autocomplete="off" class="form-control form-control-sm" name="password" id="password" value="{{ old('password', $employee->password) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-lg w-100">{{ $lang['lang_addemployee_confirm'] ?? 'تحديث' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
