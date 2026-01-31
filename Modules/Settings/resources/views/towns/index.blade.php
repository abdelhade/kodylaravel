@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h2>المدن</h2>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="col-md-4 border rounded m-0 p-0 mb-3">
                        <form action="{{ route('towns.store') }}" method="post">
                            @csrf
                            <input type="text" name="name" class="form-control frst focus:bg-orange-200" placeholder="ادخل مدينة جديدة" value="{{ old('name') }}" required>
                            <button type="submit" class="btn btn-info btn-block">حفظ</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم المدينة</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($towns as $index => $town)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <form action="{{ route('towns.update', ['id' => $town->id]) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group">
                                                    <input type="text" name="name" class="form-control" value="{{ $town->name }}" required>
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-sm btn-warning">
                                                            <i class="fa fa-pen"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('towns.destroy', ['id' => $town->id]) }}" method="post" class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm bg-red-600 text-red-100">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">لا توجد مدن</td>
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
@endsection
