@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @if(isset($role['show_attandance']) && $role['show_attandance'] == 1)
                <h2>الإعدادات العامة للنظام</h2>
                
                <div class="card card-primary">
                    <div class="card-header">
                        إعدادات النظام
                    </div>
                    <div class="card-body">
                        <a href="{{ route('import-fp-log.index') }}" class="btn btn-primary mb-3">استيراد الملفات</a>

                        <h2>Employees Table</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Salary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>John Doe</td>
                                        <td>HR</td>
                                        <td>$5000</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Jane Smith</td>
                                        <td>IT</td>
                                        <td>$6000</td>
                                    </tr>
                                    <!-- Add more rows here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            @else
                <div class="alert alert-danger">
                    {{ $lang['userErrorMassage'] ?? 'ليس لديك صلاحية للوصول إلى هذه الصفحة' }}
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
