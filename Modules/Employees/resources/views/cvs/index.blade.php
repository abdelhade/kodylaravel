@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>السيرة الذاتية</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <a href="{{ route('cvs.create') }}" class="btn btn-large btn-primary">
                                {{ $lang['lang_add_new'] ?? 'إضافة جديد' }}
                            </a>
                        </h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>الاسم</th>
                                    <th>المهارات</th>
                                    <th>آخر راتب</th>
                                    <th>أخرى</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cvs as $index => $cv)
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <th>{{ $cv->name }}</th>
                                        <th>{{ $cv->skills }}</th>
                                        <th>{{ $cv->expsalary ?? '-' }}</th>
                                        <th>
                                            {{ $cv->exp1 ?? '' }},
                                            {{ $cv->exp2 ?? '' }},
                                            {{ $cv->exp3 ?? '' }},
                                            {{ $cv->exp4 ?? '' }},
                                            {{ $cv->exp5 ?? '' }}
                                        </th>
                                        <th>
                                            <a href="{{ route('cvs.edit', ['id' => $cv->id]) }}" class="btn btn-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        </th>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">لا توجد سير ذاتية</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>م</th>
                                    <th>الاسم</th>
                                    <th>المهارات</th>
                                    <th>آخر راتب</th>
                                    <th>أخرى</th>
                                    <th>عمليات</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
