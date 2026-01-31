@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h2>KBIs</h2>
                    <div class="col-md-2 float-right">
                        <a href="{{ route('kbis.create') }}" class="btn btn-primary hadi-white-flash">إضافة KBI</a>
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
                                    <th>اسم المعدل</th>
                                    <th>الوصف</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kbis as $index => $kbi)
                                    <form action="{{ route('kbis.update', ['id' => $kbi->id]) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <tr>
                                            <th>{{ $index + 1 }}</th>
                                            <th>
                                                <input type="text" value="{{ $kbi->kname }}" name="kname" class="form-control" required>
                                            </th>
                                            <th>
                                                <input type="text" value="{{ $kbi->info ?? '' }}" name="info" class="form-control">
                                            </th>
                                            <th>
                                                <button type="submit" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-pen"></i>
                                                </button>
                                                <button type="button" class="btn bg-red-600 text-red-100" data-toggle="modal" data-target="#deleteModal{{ $kbi->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </th>
                                        </tr>
                                    </form>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $kbi->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-danger">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">تحذير</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل تريد بالتأكيد حذف هذا المعدل؟</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">إلغاء</button>
                                                    <form action="{{ route('kbis.destroy', ['id' => $kbi->id]) }}" method="POST" class="d-inline">
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
                                        <td colspan="4" class="text-center">لا توجد معدلات تقييم</td>
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
