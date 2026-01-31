@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <form action="{{ route('manual-attendance.index') }}" method="post">
                    @csrf
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h1 class="card-title">سجل الحضور والانصراف</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                <a href="{{ route('manual-attendance.create') }}" class="btn btn-block btn-large bg-lime-300 h-16">+</a>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="employee">الاسم:</label>
                                    <select required class="form-control" name="employee" id="employee">
                                        <option value="0">كل الموظفين</option>
                                        @foreach($employees as $emp)
                                            <option value="{{ $emp->id }}" {{ old('employee', $employeeId) == $emp->id ? 'selected' : '' }}>
                                                {{ $emp->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fromdate">من:</label>
                                    <input required name="fromdate" class="form-control" type="date" value="{{ old('fromdate', $fromDate) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="todate">إلى:</label>
                                    <input required name="todate" class="form-control" type="date" value="{{ old('todate', $toDate) }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-block btn-large bg-sky-500 text-slate-50 h-16" type="submit">
                                    <i class="nav-icon fa-light fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>الاسم</th>
                                <th>نوع البصمة</th>
                                <th>التاريخ</th>
                                <th>الوقت</th>
                                <th>عمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $index => $attendance)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $attendance->employee_name }}</td>
                                    <td>{{ $attendance->fp_type_name }}</td>
                                    <td>{{ $attendance->fpdate }}</td>
                                    <td>{{ $attendance->time }}</td>
                                    <td>
                                        <a class="btn btn-warning" href="{{ route('manual-attendance.edit', ['id' => $attendance->id]) }}">
                                            {{ $lang['lang_edit'] ?? 'تعديل' }}
                                        </a>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $attendance->id }}">
                                            حذف
                                        </button>
                                    </td>
                                </tr>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $attendance->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-danger">
                                            <div class="modal-header">
                                                <h4 class="modal-title">تحذير</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>هل تريد بالتأكيد حذف هذه البصمة؟</p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">إلغاء</button>
                                                <form action="{{ route('manual-attendance.destroy', ['id' => $attendance->id]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-light">حذف</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">لا توجد بصمات</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
