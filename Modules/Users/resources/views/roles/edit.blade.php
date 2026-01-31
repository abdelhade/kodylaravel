@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
<section class="content-header">
<div class="container-fluid">
    @if($role['show_users'] == 1)
        <form action="{{ route('roles.update', ['id' => $roleData->id]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card card-warning">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <h3>تعديل دور {{ $roleData->rollname }}</h3>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <button type="submit" class="btn btn-light col-sm-2">حفظ</button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group border">
                                <label for="rollname">اسم الدور</label>
                                <input type="text" name="rollname" class="form-control form-control-sm" value="{{ old('rollname', $roleData->rollname) }}" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group border">
                                <label for="info">وصف الدور</label>
                                <input type="text" name="info" class="form-control form-control-sm" value="{{ old('info', $roleData->info) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table table-responsive table-bordered table-hover">
                                <input type="text" id="itmsearch1" class="form-control form-control-sm" placeholder="search">
                                <center>
                                    <table id="horsTable1" class="table">
                                        <thead>
                                            <tr>
                                                <th class="">اسم الصلاحيه</th>
                                                <th>عرض</th>
                                                <th>جديد</th>
                                                <th>تعديل</th>
                                                <th>حذف</th>
                                                <th>المفضلة</th>
                                            </tr>
                                            <tr>
                                                <th>اختيار الكل <input type="checkbox" name="" id="checkall"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $permissions = [
                                                    ['name' => 'المستخدمين', 'prefix' => 'users'],
                                                    ['name' => 'العملاء', 'prefix' => 'clients'],
                                                    ['name' => 'الموردين', 'prefix' => 'suppliers'],
                                                    ['name' => 'الصناديق', 'prefix' => 'funds'],
                                                    ['name' => 'البنوك', 'prefix' => 'banks'],
                                                    ['name' => 'المخزون', 'prefix' => 'stock'],
                                                    ['name' => 'المصروفات', 'prefix' => 'expenses'],
                                                    ['name' => 'الايرادات', 'prefix' => 'revenuses'],
                                                    ['name' => 'دائنين آخرين', 'prefix' => 'credits'],
                                                    ['name' => 'مدينين آخرين', 'prefix' => 'depits'],
                                                    ['name' => 'الشركاء', 'prefix' => 'partners'],
                                                    ['name' => 'الاصول', 'prefix' => 'assets'],
                                                    ['name' => 'الاصول القابلة للتأجير', 'prefix' => 'rentables'],
                                                    ['name' => 'الموظفين', 'prefix' => 'employees'],
                                                    ['name' => 'الاصناف', 'prefix' => 'items'],
                                                    ['name' => 'مجموعات الاصناف', 'prefix' => 'item_groups'],
                                                    ['name' => 'المبيعات', 'prefix' => 'sales'],
                                                    ['name' => 'مردود المبيعات', 'prefix' => 'resale'],
                                                    ['name' => 'المشتريات', 'prefix' => 'purchases'],
                                                    ['name' => 'مردود المشتريات', 'prefix' => 'repurchases'],
                                                    ['name' => 'سندات القبض', 'prefix' => 'recive'],
                                                    ['name' => 'سندات الدفع', 'prefix' => 'payment'],
                                                    ['name' => 'العيادات', 'prefix' => 'clinics'],
                                                    ['name' => 'الحجوزات', 'prefix' => 'reservations'],
                                                    ['name' => 'العملاء متقدم', 'prefix' => 'advanced_clients'],
                                                    ['name' => 'الادوية', 'prefix' => 'drugs'],
                                                    ['name' => 'بروفايل لعميل', 'prefix' => 'client_profile'],
                                                    ['name' => 'الفرص', 'prefix' => 'chances'],
                                                    ['name' => 'موديول الحضور ة الانصراف', 'prefix' => 'attandance'],
                                                    ['name' => 'المكالمات', 'prefix' => 'calls'],
                                                    ['name' => 'قيود اليومية', 'prefix' => 'journals'],
                                                    ['name' => 'حسابات الاستاذ', 'prefix' => 'gl_reports', 'disabled' => true],
                                                    ['name' => 'تقارير العيادات', 'prefix' => 'clinic_reports', 'disabled' => true],
                                                    ['name' => 'تقارير التأجير', 'prefix' => 'rent_reports', 'disabled' => true],
                                                    ['name' => 'تقاريرالمرتبات', 'prefix' => 'payroll_report', 'disabled' => true],
                                                    ['name' => 'تقارير الحضور', 'prefix' => 'hr_report', 'disabled' => true],
                                                ];
                                            @endphp
                                            @foreach($permissions as $perm)
                                                @php
                                                    $roleValue = $roleData->{'show_' . $perm['prefix']} ?? 0;
                                                    $addValue = $roleData->{'add_' . $perm['prefix']} ?? 0;
                                                    $editValue = $roleData->{'edit_' . $perm['prefix']} ?? 0;
                                                    $deleteValue = $roleData->{'delete_' . $perm['prefix']} ?? 0;
                                                    $favValue = $roleData->{'is_fav_' . $perm['prefix']} ?? 0;
                                                @endphp
                                                <tr class="tr1">
                                                    <td>{{ $perm['name'] }}</td>
                                                    <td><input type="checkbox" class="user-checkbox" name="show_{{ $perm['prefix'] }}" {{ old('show_' . $perm['prefix'], $roleValue) == 1 ? 'checked' : '' }} {{ isset($perm['disabled']) && $perm['disabled'] ? 'disabled' : '' }}></td>
                                                    <td><input type="checkbox" class="user-checkbox" name="add_{{ $perm['prefix'] }}" {{ old('add_' . $perm['prefix'], $addValue) == 1 ? 'checked' : '' }} {{ isset($perm['disabled']) && $perm['disabled'] ? 'disabled' : '' }}></td>
                                                    <td><input type="checkbox" class="user-checkbox" name="edit_{{ $perm['prefix'] }}" {{ old('edit_' . $perm['prefix'], $editValue) == 1 ? 'checked' : '' }} {{ isset($perm['disabled']) && $perm['disabled'] ? 'disabled' : '' }}></td>
                                                    <td><input type="checkbox" class="user-checkbox" name="delete_{{ $perm['prefix'] }}" {{ old('delete_' . $perm['prefix'], $deleteValue) == 1 ? 'checked' : '' }} {{ isset($perm['disabled']) && $perm['disabled'] ? 'disabled' : '' }}></td>
                                                    <td><input type="checkbox" class="user-checkbox" name="is_fav_{{ $perm['prefix'] }}" {{ old('is_fav_' . $perm['prefix'], $favValue) == 1 ? 'checked' : '' }} {{ isset($perm['disabled']) && $perm['disabled'] ? 'disabled' : '' }}></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </center>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table table-responsive">
                                <table id="horsTable1" class="table table-bordered table-responsive table-hover">
                                    <thead>
                                        <tr>
                                            <th>خيارات الجانب</th>
                                            <th>عرض</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sidebarOptions = [
                                                ['name' => 'اظهار قائمة البيانات الاساسية من الجانب الايمن', 'key' => 'sid_entry'],
                                                ['name' => 'اظهار قائمة المخزون من الجانب الايمن', 'key' => 'sid_stock'],
                                                ['name' => 'اظهار قسم المبيعات من الجانب الايمن', 'key' => 'sid_sales'],
                                                ['name' => 'اظهار قسم المشتريات من الجانب الايمن', 'key' => 'sid_purchases'],
                                                ['name' => 'اظهار السندات من الجانب الايمن', 'key' => 'sid_vouchers'],
                                                ['name' => 'اظهار قسم العيادات من الجانب الايمن', 'key' => 'sid_clinics'],
                                                ['name' => 'اظهار قسم ادارة علاقات العملاء من الجانب الايمن', 'key' => 'sid_crm'],
                                                ['name' => 'اظهار قسم الحسابات من الجانب الايمن', 'key' => 'sid_accounts'],
                                                ['name' => 'اظهار قسم الاصول من الجانب الايمن', 'key' => 'sid_assets'],
                                                ['name' => 'اظهار التقارير من الجانب الايمن', 'key' => 'sid_reports'],
                                                ['name' => 'اظهار قسم اداره الموارد البشرية من الجانب الايمن', 'key' => 'sid_hr'],
                                                ['name' => 'اظهار قسم المرتبات من الجانب الايمن', 'key' => 'sid_payroll'],
                                                ['name' => 'اظهار قسم التأجير من الجانب الايمن', 'key' => 'sid_rents'],
                                                ['name' => 'اظهار قسم ادارة الكروت من الجانب الايمن', 'key' => 'sid_cards'],
                                                ['name' => 'تعديل كلمات مرور المستخدمين', 'key' => 'edit_user_passwords'],
                                            ];
                                        @endphp
                                        @foreach($sidebarOptions as $option)
                                            @php
                                                $optionValue = $roleData->{$option['key']} ?? 0;
                                            @endphp
                                            <tr class="tr1">
                                                <td>{{ $option['name'] }}</td>
                                                <td><input type="checkbox" name="{{ $option['key'] }}" class="user-checkbox" {{ old($option['key'], $optionValue) == 1 ? 'checked' : '' }}></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="table table-responsive">
                                <table id="horsTable1" class="table table-bordered table-responsive table-hover">
                                    <thead>
                                        <tr>
                                            <th>الخيارات العامة</th>
                                            <th>عرض</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $generalOptions = [
                                                ['name' => 'اظهار الحجوزات المنتهية', 'key' => 'show_ended_reservation'],
                                                ['name' => 'اظهار اجمالي الحجوزات', 'key' => 'show_total_reservation'],
                                                ['name' => '(مكرر)اظهار بيانات المريض', 'key' => 'show_client_profile'],
                                                ['name' => 'اظهار مهمات كل الاشخاص', 'key' => 'show_all_tasks'],
                                                ['name' => 'اظهار الكروت في الشاشة الرئيسية', 'key' => 'show_main_cards'],
                                                ['name' => 'اظهار الاختصارات في الشاشة الرئيسية', 'key' => 'show_main_elements'],
                                                ['name' => 'اظهار الجداول في الشاشة الرئيسية', 'key' => 'show_main_tables'],
                                            ];
                                        @endphp
                                        @foreach($generalOptions as $option)
                                            @php
                                                $optionValue = $roleData->{$option['key']} ?? 0;
                                            @endphp
                                            <tr class="tr1">
                                                <td>{{ $option['name'] }} @if($option['key'] == 'show_client_profile')<span title="قد يتم التعارض مع اظهار بيانات العميل" class="text-slate-50 bg-red-500">?</span>@endif</td>
                                                <td><input type="checkbox" name="{{ $option['key'] }}" class="user-checkbox" {{ old($option['key'], $optionValue) == 1 ? 'checked' : '' }}></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="alert alert-danger">{{ $lang['userErrorMassage'] ?? 'ليس لديك صلاحية للوصول إلى هذه الصفحة' }}</div>
    @endif
</div>
</section>
</div>

<script>
$(document).ready(function(){
    $("#itmsearch1").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#horsTable1 .tr1").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

document.getElementById('checkall').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.tr1 .user-checkbox:not([disabled])');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>
@endsection
