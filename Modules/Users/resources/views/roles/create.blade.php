@extends('dashboard.layout')

@section('content')
<style>
    .card { border-radius: 15px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 2rem; }
    .card-header { background: linear-gradient(45deg, #007bff, #0056b3); color: white; border-radius: 15px 15px 0 0 !important; }
    .form-section-title { border-right: 4px solid #007bff; padding-right: 10px; margin: 20px 0; font-weight: bold; color: #333; }
    .table thead th { background-color: #f8f9fa; border-bottom: 2px solid #dee2e6; }
    .user-checkbox { width: 18px; height: 18px; cursor: pointer; }
    .sticky-save { position: sticky; top: 20px; z-index: 100; }
    .table-responsive { max-height: 600px; overflow-y: auto; }
</style>

<div class="container-fluid p-3">
    @if($role['show_users'] == 1)
        <form action="{{ route('roles.store') }}" method="post">
            @csrf
            
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="fas fa-user-shield ml-2"></i> إضافة دور جديد (صلاحية)</h3>
                    <button type="submit" class="btn btn-light btn-lg px-5 shadow-sm">
                        <i class="fas fa-save ml-1"></i> حفظ البيانات
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="form-section-title">البيانات الأساسية</h5>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="font-weight-bold">اسم الدور</label>
                                        <input type="text" name="rollname" class="form-control" value="{{ old('rollname') }}" placeholder="مثلاً: مدير النظام" required>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="font-weight-bold">وصف الدور</label>
                                        <input type="text" name="info" class="form-control" value="{{ old('info') }}" placeholder="وصف مختصر للمهام">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <h5 class="form-section-title d-flex justify-content-between align-items-center">
                                جدول الصلاحيات التفصيلي
                                <div class="custom-control custom-checkbox bg-light p-2 rounded" style="font-size: 0.9rem;">
                                    <input type="checkbox" class="custom-control-input" id="checkall">
                                    <label class="custom-control-label" for="checkall">تحديد الكل</label>
                                </div>
                            </h5>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" id="itmsearch1" class="form-control" placeholder="بحث في الصلاحيات...">
                            </div>

                            <div class="table-responsive">
                                <table id="horsTable1" class="table table-hover table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th class="text-right">الموديول / الصفحة</th>
                                            <th class="text-info">عرض</th>
                                            <th class="text-success">إضافة</th>
                                            <th class="text-warning">تعديل</th>
                                            <th class="text-danger">حذف</th>
                                            <th class="text-primary">مفضلة</th>
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
                                                ['name' => 'حضور وانصراف', 'prefix' => 'attandance'],
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
                                            <tr class="tr1">
                                                <td class="text-right font-weight-bold">{{ $perm['name'] }}</td>
                                                <td><input type="checkbox" class="user-checkbox" name="show_{{ $perm['prefix'] }}" {{ old('show_' . $perm['prefix'], true) ? 'checked' : '' }} {{ isset($perm['disabled']) && $perm['disabled'] ? 'disabled' : '' }}></td>
                                                <td><input type="checkbox" class="user-checkbox" name="add_{{ $perm['prefix'] }}" {{ old('add_' . $perm['prefix'], true) ? 'checked' : '' }} {{ isset($perm['disabled']) && $perm['disabled'] ? 'disabled' : '' }}></td>
                                                <td><input type="checkbox" class="user-checkbox" name="edit_{{ $perm['prefix'] }}" {{ old('edit_' . $perm['prefix'], true) ? 'checked' : '' }} {{ isset($perm['disabled']) && $perm['disabled'] ? 'disabled' : '' }}></td>
                                                <td><input type="checkbox" class="user-checkbox" name="delete_{{ $perm['prefix'] }}" {{ old('delete_' . $perm['prefix'], true) ? 'checked' : '' }} {{ isset($perm['disabled']) && $perm['disabled'] ? 'disabled' : '' }}></td>
                                                <td><input type="checkbox" class="user-checkbox" name="is_fav_{{ $perm['prefix'] }}" {{ old('is_fav_' . $perm['prefix']) ? 'checked' : '' }} {{ isset($perm['disabled']) && $perm['disabled'] ? 'disabled' : '' }}></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="form-section-title">خيارات القائمة الجانبية</h5>
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    @php
                                        $sidebarOptions = [
                                            ['name' => 'البيانات الاساسية', 'key' => 'sid_entry'],
                                            ['name' => 'المخزون', 'key' => 'sid_stock'],
                                            ['name' => 'المبيعات', 'key' => 'sid_sales'],
                                            ['name' => 'المشتريات', 'key' => 'sid_purchases'],
                                            ['name' => 'السندات', 'key' => 'sid_vouchers'],
                                            ['name' => 'العيادات', 'key' => 'sid_clinics'],
                                            ['name' => 'إدارة علاقات العملاء (CRM)', 'key' => 'sid_crm'],
                                            ['name' => 'الحسابات', 'key' => 'sid_accounts'],
                                            ['name' => 'الاصول', 'key' => 'sid_assets'],
                                            ['name' => 'التقارير', 'key' => 'sid_reports'],
                                            ['name' => 'الموارد البشرية (HR)', 'key' => 'sid_hr'],
                                            ['name' => 'المرتبات', 'key' => 'sid_payroll'],
                                            ['name' => 'التأجير', 'key' => 'sid_rents'],
                                            ['name' => 'إدارة الكروت', 'key' => 'sid_cards'],
                                            ['name' => 'تعديل كلمات مرور المستخدمين', 'key' => 'edit_user_passwords'],
                                        ];
                                    @endphp
                                    @foreach($sidebarOptions as $option)
                                        <tr class="border-bottom">
                                            <td>{{ $option['name'] }}</td>
                                            <td class="text-left">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="{{ $option['key'] }}" class="custom-control-input user-checkbox" id="sw_{{ $option['key'] }}" {{ old($option['key'], true) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="sw_{{ $option['key'] }}"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="form-section-title">إعدادات عامة</h5>
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    @php
                                        $generalOptions = [
                                            ['name' => 'اظهار الحجوزات المنتهية', 'key' => 'show_ended_reservation'],
                                            ['name' => 'اظهار اجمالي الحجوزات', 'key' => 'show_total_reservation'],
                                            ['name' => 'اظهار بيانات المريض', 'key' => 'show_client_profile', 'info' => true],
                                            ['name' => 'اظهار مهمات كل الاشخاص', 'key' => 'show_all_tasks'],
                                            ['name' => 'الكروت في الشاشة الرئيسية', 'key' => 'show_main_cards'],
                                            ['name' => 'الاختصارات في الشاشة الرئيسية', 'key' => 'show_main_elements'],
                                            ['name' => 'الجداول في الشاشة الرئيسية', 'key' => 'show_main_tables'],
                                        ];
                                    @endphp
                                    @foreach($generalOptions as $option)
                                        <tr class="border-bottom">
                                            <td>
                                                {{ $option['name'] }}
                                                @if(isset($option['info']))
                                                    <i class="fas fa-exclamation-circle text-warning" title="قد يتعارض مع إظهار بيانات العميل"></i>
                                                @endif
                                            </td>
                                            <td class="text-left">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="{{ $option['key'] }}" class="custom-control-input user-checkbox" id="sw_{{ $option['key'] }}" {{ old($option['key'], true) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="sw_{{ $option['key'] }}"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="alert alert-custom bg-white border-right-danger shadow-sm">
            <i class="fas fa-lock text-danger ml-2"></i> {{ $lang['userErrorMassage'] ?? 'ليس لديك صلاحية للوصول إلى هذه الصفحة' }}
        </div>
    @endif
</div>

<script>
$(document).ready(function(){
    // البحث في الصلاحيات
    $("#itmsearch1").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#horsTable1 tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // تحديد الكل
    $('#checkall').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('.user-checkbox:not([disabled])').prop('checked', isChecked);
    });
});
</script>
@endsection