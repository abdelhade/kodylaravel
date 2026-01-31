@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h5>إضافة بدل أو استقطاع</h5>
                </div>
                <form action="{{ route('allowances.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group col-lg-3">
                            <label for="name">الاسم</label>
                            <input class="form-control form-control bg-gradient-dark" type="text" name="name" id="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="tybe">النوع</label>
                            <select class="form-control form-control bg-gradient-dark" name="tybe" id="tybe" required>
                                <option value="1" {{ old('tybe', '1') == '1' ? 'selected' : '' }}>بدل</option>
                                <option value="0" {{ old('tybe') == '0' ? 'selected' : '' }}>استقطاع</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="info">ملاحظات</label>
                            <input class="form-control form-control bg-gradient-dark" name="info" type="text" id="info" value="{{ old('info') }}">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-info btn-block" type="submit">{{ $lang['lang_publicconfirm'] ?? 'تأكيد' }}</button>
                        <a href="{{ route('allowances.index') }}" class="btn btn-secondary btn-block">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
