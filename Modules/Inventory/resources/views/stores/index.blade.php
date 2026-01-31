@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4"><h3>ادارة المخازن</h3></div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4 text-right">
                            <a href="{{ route('stores.create') }}" id="addNewElement">
                                <p class="btn btn-large btn-dark">جديد(F3)</p>
                            </a>
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

                    <div class="table">
                        <table class="table table-bordered">
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
</div>

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
