@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col"><h3>Follow UP</h3></div>
                        <div class="col">
                            <a class="btn btn-primary btn-lg" href="{{ route('tasks.create') }}">جديد</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="فلترة" id="itmsearch">
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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>تاريخ</th>
                                    <th>الاسم</th>
                                    <th>التليفون</th>
                                    <th>تعليق المندوب</th>
                                    <th>تعليق العميل</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody id="itmTable">
                                @forelse($tasks as $index => $task)
                                    <tr class="tr1">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $task->crtime }}</td>
                                        <td>{{ $task->name }}</td>
                                        <td>{{ $task->phone }}</td>
                                        <td>{{ $task->emp_comment ?? '-' }}</td>
                                        <td>{{ $task->cl_comment ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('tasks.edit', ['id' => $task->id]) }}" class="btn btn-warning btn-sm">تعديل</a>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deltask{{ $task->id }}">
                                                حذف
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deltask{{ $task->id }}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content bg-warning">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">حذف المهمة {{ $task->id }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل تريد بالتأكيد حذف المهمة {{ $task->id }} نهائياً؟</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('followup.destroy', ['id' => $task->id]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">حذف</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">لا توجد مهام محذوفة</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Search functionality
    $('#itmsearch').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('#itmTable tr').each(function() {
            const name = $(this).find('td:eq(2)').text().toLowerCase();
            const phone = $(this).find('td:eq(3)').text().toLowerCase();
            
            if (name.includes(searchTerm) || phone.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
@endsection
