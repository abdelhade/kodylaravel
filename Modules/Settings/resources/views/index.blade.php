@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h2>الاعدادات العامة للنظام</h2>
            <h3>نرجو الحذر في الاختيارات .. التعديل حرج في هذه القائمة</h3>

            <form action="{{ route('settings.update') }}" method="post">
                @csrf
                @method('PUT')
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- إعدادات النظام -->
                <div class="card collapsed-card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h1>اعدادات النظام</h1>
                            </div>
                            <div class="col">
                                <button class="form-control btn btn-primary" type="submit">تأكيد</button>
                            </div>
                            <div class="col"></div>
                        </div>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="companyname">اسم الشركة</label>
                                <input type="text" class="form-control" name="companyname" id="companyname" value="{{ old('companyname', $settingsData->company_name ?? '') }}" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="companyadd">عنوان الشركة</label>
                                <input type="text" class="form-control" name="companyadd" id="companyadd" value="{{ old('companyadd', $settingsData->company_add ?? '') }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="companytel">تليفونات الشركة</label>
                                <input type="text" class="form-control" name="companytel" id="companytel" value="{{ old('companytel', $settingsData->company_tel ?? '') }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="lang">لغة البرنامج</label>
                                <select class="form-control" name="lang" id="lang">
                                    <option value="ar" {{ old('lang', $settingsData->lang ?? 'ar') == 'ar' ? 'selected' : '' }}>العربية</option>
                                    <option value="en" {{ old('lang', $settingsData->lang ?? 'ar') == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="fr" {{ old('lang', $settingsData->lang ?? 'ar') == 'fr' ? 'selected' : '' }}>French</option>
                                    <option value="gr" {{ old('lang', $settingsData->lang ?? 'ar') == 'gr' ? 'selected' : '' }}>German</option>
                                    <option value="sp" {{ old('lang', $settingsData->lang ?? 'ar') == 'sp' ? 'selected' : '' }}>Spanish</option>
                                    <option value="trk" {{ old('lang', $settingsData->lang ?? 'ar') == 'trk' ? 'selected' : '' }}>Turkish</option>
                                    <option value="ch" {{ old('lang', $settingsData->lang ?? 'ar') == 'ch' ? 'selected' : '' }}>Chinese</option>
                                    <option value="hn" {{ old('lang', $settingsData->lang ?? 'ar') == 'hn' ? 'selected' : '' }}>Hindi</option>
                                    <option value="urd" {{ old('lang', $settingsData->lang ?? 'ar') == 'urd' ? 'selected' : '' }}>Urdu</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edit_pass">كلمة مرور التعديل</label>
                                <input type="text" class="form-control" name="edit_pass" id="edit_pass" value="{{ old('edit_pass', $settingsData->edit_pass ?? '') }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="lic">الترخيص</label>
                                <input type="text" class="form-control" name="lic" id="lic" value="{{ old('lic', $settingsData->lic ?? '') }}" readonly>
                            </div>
                        </div>

                        <!-- الحسابات الافتراضية -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h4>الحسابات الافتراضية</h4>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="acc_rent">الحساب الافتراضي للإيجار المستحق</label>
                                <input type="number" name="acc_rent" id="acc_rent" class="form-control" value="{{ old('acc_rent', $settingsData->acc_rent ?? 0) }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="def_pos_client">الحساب الافتراضي لعميل الكاشير</label>
                                <input type="number" name="def_pos_client" id="def_pos_client" class="form-control" value="{{ old('def_pos_client', $settingsData->def_pos_client ?? '') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="def_pos_store">الحساب الافتراضي لمخزن الكاشير</label>
                                <input type="number" name="def_pos_store" id="def_pos_store" class="form-control" value="{{ old('def_pos_store', $settingsData->def_pos_store ?? '') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="def_pos_employee">الحساب الافتراضي لموظف الكاشير</label>
                                <input type="number" name="def_pos_employee" id="def_pos_employee" class="form-control" value="{{ old('def_pos_employee', $settingsData->def_pos_employee ?? '') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="def_pos_fund">الحساب الافتراضي لصندوق الكاشير</label>
                                <input type="number" name="def_pos_fund" id="def_pos_fund" class="form-control" value="{{ old('def_pos_fund', $settingsData->def_pos_fund ?? '') }}">
                            </div>
                        </div>

                        <!-- الألوان -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h4>الألوان</h4>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="bodycolor">لون الخلفية</label>
                                <input type="color" name="bodycolor" id="bodycolor" class="form-control" value="{{ old('bodycolor', $settingsData->bodycolor ?? '#ffffff') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nav-background">لون الهيدر</label>
                                <input type="color" name="nav-background" id="nav-background" class="form-control" value="{{ old('nav-background', $settingsData->bodycolor ?? '#ffffff') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="side-background">لون المفاتيح</label>
                                <input type="color" name="side-background" id="side-background" class="form-control" value="{{ old('side-background', $settingsData->bodycolor ?? '#ffffff') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- التحكم بالقوائم -->
                <div class="card collapsed-card mt-3">
                    <div class="card-header">
                        التحكم بالقوائم
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive col-md-4">
                            <table class="table table-hover table-striped table-warning">
                                <thead>
                                    <tr>
                                        <th class="col-1">id</th>
                                        <th class="col-9">الاسم</th>
                                        <th class="col-2">ظهور</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th></th>
                                        <th>التأجير</th>
                                        <th>
                                            <input type="number" name="showrent" class="form-control" value="{{ old('showrent', $settingsData->showrent ?? 1) }}" min="0" max="1">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>العيادات</th>
                                        <th>
                                            <input type="number" name="showclinc" class="form-control" value="{{ old('showclinc', $settingsData->showclinc ?? 1) }}" min="0" max="1">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>HR</th>
                                        <th>
                                            <input type="number" name="showhr" class="form-control" value="{{ old('showhr', $settingsData->showhr ?? 1) }}" min="0" max="1">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>الحضور</th>
                                        <th>
                                            <input type="number" name="showatt" class="form-control" value="{{ old('showatt', $settingsData->showatt ?? 1) }}" min="0" max="1">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>المرتبات</th>
                                        <th>
                                            <input type="number" name="showpayroll" class="form-control" value="{{ old('showpayroll', $settingsData->showpayroll ?? 1) }}" min="0" max="1">
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    <a href="{{ route('kody2.dashboard') }}" class="btn btn-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
