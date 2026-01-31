@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h3>إدارة المكالمات</h3>
                        </div>
                        <div class="col">
                            <a class="btn btn-primary right" href="{{ route('calls.create') }}">مكالمة جديدة</a>
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

                    <div class="table table-responsive">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الموضوع</th>
                                    <th>العميل</th>
                                    <th>نوع المكالمة</th>
                                    <th>تاريخ المكالمة</th>
                                    <th>وقت المكالمة</th>
                                    <th>مدة المكالمة</th>
                                    <th>تعليق الموظف</th>
                                    <th>محتوى المكالمة</th>
                                    <th>تاريخ المكالمة القادمة</th>
                                    <th>وقت المكالمة القادمة</th>
                                    <th>تعليق المراجع</th>
                                    <th>تقييم المكالمة</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($calls as $index => $call)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $call->subject }}</td>
                                        <td>{{ $call->client_name }}</td>
                                        <td>{{ $call->call_type_name }}</td>
                                        <td>{{ $call->call_date }}</td>
                                        <td>{{ $call->call_time }}</td>
                                        <td>{{ $call->duration ?? '-' }}</td>
                                        <td>{{ $call->emp_comment ?? '-' }}</td>
                                        <td>{{ Str::limit($call->content ?? '', 50) }}</td>
                                        <td>{{ $call->next_date ?? '-' }}</td>
                                        <td>{{ $call->next_time ?? '-' }}</td>
                                        <td>{{ $call->mod_comment ?? '-' }}</td>
                                        <td>{{ $call->mod_rate ?? '-' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $call->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $call->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-danger">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">تحذير</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل تريد بالتأكيد حذف هذه المكالمة؟</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">إلغاء</button>
                                                    <form action="{{ route('calls.destroy', ['id' => $call->id]) }}" method="POST" class="d-inline">
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
                                        <td colspan="14" class="text-center">لا توجد مكالمات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>الموضوع</th>
                                    <th>العميل</th>
                                    <th>نوع المكالمة</th>
                                    <th>تاريخ المكالمة</th>
                                    <th>وقت المكالمة</th>
                                    <th>مدة المكالمة</th>
                                    <th>تعليق الموظف</th>
                                    <th>محتوى المكالمة</th>
                                    <th>تاريخ المكالمة القادمة</th>
                                    <th>وقت المكالمة القادمة</th>
                                    <th>تعليق المراجع</th>
                                    <th>تقييم المكالمة</th>
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
