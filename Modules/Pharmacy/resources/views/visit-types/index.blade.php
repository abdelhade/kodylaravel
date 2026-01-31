@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <h3>أنواع الزيارات</h3>
                        </div>
                        <div class="col-md-3">
                            <button id="addNewElement" type="button" class="btn btn-success btn-sm hadi-white-flash" data-toggle="modal" data-target="#modal-xl">
                                +
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Add Modal -->
                <div class="modal fade" id="modal-xl" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">إضافة نوع زيارة جديدة</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form action="{{ route('visit-types.store') }}" method="post" id="addItemForm">
                                @csrf
                                <div class="modal-body">
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <input name="name" type="text" class="form-control" placeholder="ادخل الاسم" value="{{ old('name') }}" required>
                                    <br>
                                    <input name="value" type="number" class="form-control" placeholder="السعر" value="{{ old('value') }}" step="0.01" min="0" required>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                </div>
                            </form>
                            <div>
                                <p id="msgitem"></p>
                            </div>
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

                    <div class="table table-responsive table-stripped">
                        <table class="myTable" id="myTable">
                            <thead>
                                <tr>
                                    <th>نوع الزيارة</th>
                                    <th>السعر</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($visitTypes as $visitType)
                                    <tr>
                                        <form action="{{ route('visit-types.update', ['id' => $visitType->id]) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <td>
                                                <input class="form-control" name="name" type="text" value="{{ $visitType->name }}" required>
                                            </td>
                                            <td>
                                                <input class="form-control" name="value" type="number" value="{{ $visitType->value }}" step="0.01" min="0" required>
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-warning btn-sm">تعديل</button>
                                                <a href="{{ route('visit-types.destroy', ['id' => $visitType->id]) }}" 
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('هل تريد بالتأكيد حذف هذا النوع؟')">حذف</a>
                                            </td>
                                        </form>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">لا توجد أنواع زيارات</td>
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
