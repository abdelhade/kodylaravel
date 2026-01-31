@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @if(isset($role['show_attandance']) && $role['show_attandance'] == 1)
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>قائمة دفاتر الحضور</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        </ol>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('salary.create') }}" class="btn btn-large btn-primary">
                                        {{ $lang['lang_add_new'] ?? 'إضافة جديد' }}
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body table-responsive">
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <table id="example2" class="table table-bordered table-hover">
                                    <thead class="bg-light text-sm">
                                        <tr>
                                            <th>م</th>
                                            <th>{{ $lang['lang_publicname'] ?? 'الاسم' }}</th>
                                            <th>المدة</th>
                                            <th>الراتب</th>
                                            <th>أيام الحضور</th>
                                            <th>أجر اليوم</th>
                                            <th>أجر الساعة</th>
                                            <th>س ع المستحقة</th>
                                            <th>س ع الفعلية</th>
                                            <th>س الإضافي</th>
                                            <th>المستحق</th>
                                            <th>الإنتاجية</th>
                                            <th>{{ $lang['lang_publicoperations'] ?? 'عمليات' }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($salaryDocs as $index => $doc)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <a href="#">
                                                        {{ $doc->id }}# {{ $doc->employee_name }}
                                                    </a>
                                                </td>
                                                <td class="w-28">
                                                    من {{ $doc->fromdate }}<br>
                                                    إلى {{ $doc->todate }}
                                                </td>
                                                <td>{{ number_format($doc->employee_salary, 2) }}</td>
                                                <td>{{ $doc->workdays }} / {{ $doc->alldays }}</td>
                                                <td>{{ $doc->workdays > 0 ? number_format($doc->employee_salary / $doc->workdays, 2) : 0 }}</td>
                                                <td>{{ $doc->exphours > 0 ? number_format($doc->employee_salary / $doc->exphours, 2) : 0 }}</td>
                                                <td>{{ $doc->exphours }}</td>
                                                <td>{{ $doc->accualhours }}h</td>
                                                <td>{{ number_format($doc->extra_hours, 2) }} / {{ number_format($doc->total_extra_hours, 2) }}</td>
                                                <td class="bg-sky-100">{{ number_format($doc->entitle, 2) }}</td>
                                                <td class="bg-sky-100">{{ number_format($doc->production_value, 2) }}</td>
                                                <td>
                                                    <a href="{{ route('salary.destroy', ['doc' => $doc->id]) }}" 
                                                       class="btn btn-danger" 
                                                       onclick="return confirm('هل تريد حذف هذا الدفتر؟')">
                                                        X
                                                    </a>
                                                    <span title="{{ $doc->info ?? '' }}" class="btn text-red-500 bg-slate-200">?</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="13" class="text-center">لا توجد دفاتر حضور</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @else
                <div class="alert alert-danger">{{ $userErrorMassage ?? 'ليس لديك صلاحية للوصول إلى هذه الصفحة' }}</div>
            @endif
        </div>
    </section>
</div>
@endsection
