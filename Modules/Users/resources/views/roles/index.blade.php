@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @if($role['show_users'] == 1)
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <h1>ادوار المستخدمين</h1>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('roles.create') }}" class="btn btn-outline-primary btn-sm">جديد</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>الوصف</th>
                                        <th>عمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($roles as $index => $rawrole)
                                        <tr>
                                            <td>{{ $rawrole->id }}</td>
                                            <td>{{ $rawrole->rollname }}</td>
                                            <td>{{ $rawrole->info ?? '--' }}</td>
                                            <td>
                                                <a href="{{ route('roles.edit', ['id' => $rawrole->id, 'hash' => md5($rawrole->id), 'name' => $rawrole->rollname]) }}" class="btn btn-warning btn-sm">تعديل</a>
                                                <form action="{{ route('roles.destroy', ['id' => $rawrole->id]) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الدور؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">لا توجد أدوار</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-danger">{{ $lang['userErrorMassage'] ?? 'ليس لديك صلاحية للوصول إلى هذه الصفحة' }}</div>
            @endif
        </div>
    </section>
</div>
@endsection
