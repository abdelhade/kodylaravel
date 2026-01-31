@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <form class="validate_form" autocomplete="off" id="validate_form" action="{{ route('employees.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <button type="button" class="btn btn-tool" data-bs-toggle="collapse" data-bs-target="#personalInfo">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <h3 class="card-title">{{ $lang['lang_addemployee_personalinfo'] ?? 'المعلومات الشخصية' }}</h3>
                            </div>
                            <div class="card-body collapse show" id="personalInfo">
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
                                            <label for="name">{{ $lang['lang_addemployee_name'] ?? 'الاسم' }}
                                                <button class="btn bg-sky-400" id="insbtn" type="button">+</button>
                                            </label>
                                            <input type="text" required minlength="6" maxlength="50" autocomplete="off" class="form-control form-control-sm" id="name" name="name" placeholder="{{ $lang['lang_pbholder_name'] ?? 'الاسم' }}" value="{{ old('name') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">{{ $lang['lang_addemployee_phone'] ?? 'التليفون' }}</label>
                                            <input type="text" autocomplete="off" class="form-control form-control-sm" name="number" id="phone" placeholder="{{ $lang['lang_pbholder_phone'] ?? 'التليفون' }}" value="{{ old('number') }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="email">{{ $lang['lang_addemployee_email'] ?? 'البريد الإلكتروني' }}</label>
                                            <input type="email" autocomplete="off" class="form-control form-control-sm" name="email" id="email" placeholder="{{ $lang['lang_pbholder_email'] ?? 'البريد الإلكتروني' }}" value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">{{ $lang['lang_addemployee_image'] ?? 'الصورة' }}</label>
                                            <div class="input-group">
                                                <input name="imgs" autocomplete="off" type="file" class="form-control" id="exampleInputFile" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="date">{{ $lang['lang_addemployee_dateofbirth'] ?? 'تاريخ الميلاد' }}</label>
                                            <input type="date" autocomplete="off" class="form-control form-control-sm" name="dateofbirth" id="date" value="{{ old('dateofbirth') }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>{{ $lang['lang_addemployee_gender'] ?? 'الجنس' }}</label>
                                            <select name="gender" class="form-select">
                                                <option value="0" {{ old('gender') == 0 ? 'selected' : '' }}>{{ $lang['lang_addemployee_male'] ?? 'ذكر' }}</option>
                                                <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>{{ $lang['lang_addemployee_female'] ?? 'أنثى' }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="info">{{ $lang['lang_addemployee_info'] ?? 'معلومات' }}</label>
                                    <textarea name="info" class="form-control form-control-sm" rows="4" id="info" placeholder="معلومات....">{{ old('info') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input name="active" class="form-check-input" type="checkbox" {{ old('active') ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $lang['lang_addemployee_active'] ?? 'نشط' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <button type="button" class="btn btn-tool" data-bs-toggle="collapse" data-bs-target="#detailsInfo">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <h3 class="card-title">{{ $lang['lang_addemployee_details'] ?? 'التفاصيل' }}</h3>
                            </div>
                            <div class="card-body collapse show" id="detailsInfo">
                                <div class="form-group">
                                    <label for="address">{{ $lang['lang_addemployee_address'] ?? 'العنوان' }} 1</label>
                                    <input type="text" autocomplete="off" class="form-control form-control-sm" id="address" name="address" placeholder="أدخل العنوان" value="{{ old('address') }}">
                                </div>
                                <div class="form-group">
                                    <label for="address2">{{ $lang['lang_addemployee_address'] ?? 'العنوان' }} 2</label>
                                    <input type="text" autocomplete="off" class="form-control form-control-sm" id="address2" name="address2" placeholder="أدخل العنوان 2" value="{{ old('address2') }}">
                                </div>
                                <div class="form-group">
                                    <label>{{ $lang['lang_addemployee_country'] ?? 'المدينة' }}</label>
                                    <select name="town" class="form-select">
                                        @foreach($towns as $town)
                                            <option value="{{ $town->id }}" {{ old('town') == $town->id ? 'selected' : '' }}>{{ $town->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <button type="button" class="btn btn-tool" data-bs-toggle="collapse" data-bs-target="#jobInfo">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <h3 class="card-title">{{ $lang['lang_addemployee_jobinfo'] ?? 'معلومات الوظيفة' }}</h3>
                            </div>
                            <div class="card-body collapse show" id="jobInfo">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>{{ $lang['lang_addemployee_job'] ?? 'الوظيفة' }}</label>
                                            <select name="jop" class="form-select" required>
                                                @foreach($jobs as $job)
                                                    <option value="{{ $job->id }}" {{ old('jop') == $job->id ? 'selected' : '' }}>{{ $job->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ $lang['lang_addemployee_jobdepart'] ?? 'القسم' }}</label>
                                            <select name="department" class="form-select">
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}" {{ old('department') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>{{ $lang['lang_addemployee_joplevel'] ?? 'مستوى الوظيفة' }}</label>
                                            <select name="joplevel" class="form-select">
                                                @foreach($jopLevels as $level)
                                                    <option value="{{ $level->id }}" {{ old('joplevel') == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ $lang['lang_addemployee_jobtype'] ?? 'نوع الوظيفة' }}</label>
                                            <select name="joptybe" class="form-select">
                                                @foreach($jopTypes as $type)
                                                    <option value="{{ $type->id }}" {{ old('joptybe') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="start_date">{{ $lang['lang_addemployee_jobstart'] ?? 'تاريخ البدء' }}</label>
                                            <input type="date" class="form-control form-control-sm" name="dateofhire" id="start_date" value="{{ old('dateofhire') }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="end_date">{{ $lang['lang_addemployee_jobend'] ?? 'تاريخ الانتهاء' }}</label>
                                            <input type="date" class="form-control form-control-sm" name="dateofend" id="end_date" value="{{ old('dateofend') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <button type="button" class="btn btn-tool" data-bs-toggle="collapse" data-bs-target="#salaryInfo">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <h3 class="card-title">{{ $lang['lang_addemployee_salaries'] ?? 'الرواتب' }}</h3>
                            </div>
                            <div class="card-body collapse show" id="salaryInfo">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="salary">{{ $lang['lang_addemployee_salary'] ?? 'الراتب' }}</label>
                                            <input type="text" autocomplete="off" class="form-control form-control-sm" id="salary" name="salary" placeholder="أدخل المرتب" value="{{ old('salary') }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>{{ $lang['lang_addemployee_shift'] ?? 'الشيفت' }}</label>
                                            <select name="shift" class="form-select">
                                                @foreach($shifts as $shift)
                                                    <option value="{{ $shift->id }}" {{ old('shift') == $shift->id ? 'selected' : '' }}>{{ $shift->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="hour_extra">الساعة الاضافي تحسب ك</label>
                                            <input type="number" autocomplete="off" class="form-control form-control-sm" id="hour_extra" name="hour_extra" placeholder="" value="{{ old('hour_extra', '1.50') }}" step="0.001">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="day_extra">اليوم الاضافي يحسب ك</label>
                                            <input type="number" autocomplete="off" class="form-control form-control-sm" id="day_extra" name="day_extra" placeholder="" value="{{ old('day_extra', '1.50') }}" step="0.001">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="basmaid">{{ $lang['lang_addemployee_basmaid'] ?? 'معرف البصمة' }}</label>
                                            <input type="text" autocomplete="off" class="form-control form-control-sm" name="basmaid" id="basmaid" placeholder="ادخل" value="{{ old('basmaid') }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="basmaname">{{ $lang['lang_addemployee_basmaname'] ?? 'اسم البصمة' }}</label>
                                            <input type="text" autocomplete="off" class="form-control form-control-sm" name="basmaname" id="basmaname" placeholder="ادخل" value="{{ old('basmaname') }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="password">{{ $lang['lang_addemployee_password'] ?? 'كلمة المرور' }}</label>
                                            <input type="password" autocomplete="off" class="form-control form-control-sm" name="password" id="password" placeholder="باسورد الهاتف" value="{{ old('password') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-lg w-100" id="submit">{{ $lang['lang_addemployee_confirm'] ?? 'تأكيد' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $("input, select, textarea").prop("disabled", true);
    $("#insbtn").on("click", function() {
        $("input, select, textarea").prop("disabled", false);
    });
});
</script>
@endsection
