@extends('dashboard.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-0">إدارة المخازن</h3>
                <small class="text-muted">تعريف مخازن النظام وربطها بالحسابات المناسبة</small>
            </div>
            <div>
                <a href="{{ route('stores.create') }}" id="addNewElement" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> مخزن جديد (F3)
                </a>
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table">
                        <table class="table table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stores as $store)
                                    <tr>
                                        <td>{{ $store->id }}</td>
                                        <td>{{ $store->aname }}</td>
                                        <td>
                                            <a href="{{ route('stores.edit', ['id' => $store->id]) }}" class="btn btn-warning">تعديل</a>
                                            <form action="{{ route('stores.destroy', ['id' => $store->id]) }}" method="post" style="display: inline-block;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المخزن؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">حذف</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">لا توجد مخازن</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // F3 shortcut to go to add page
    document.addEventListener('keydown', function(e) {
        if (e.key === 'F3') {
            e.preventDefault();
            window.location.href = document.getElementById('addNewElement').href;
        }
    });
});
</script>
@endsection
