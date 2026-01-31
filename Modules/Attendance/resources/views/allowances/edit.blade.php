@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h5>تعديل بدل أو استقطاع</h5>
                </div>
                <form action="{{ route('allowances.update', ['id' => $allowance->id]) }}" method="post">
                    @csrf
                    @method('PUT')
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

                        <div class="form-group">
                            <label for="name">الاسم</label>
                            <input value="{{ old('name', $allowance->name) }}" class="form-control form-control bg-gradient-dark" type="text" name="name" id="name" required>
                        </div>

                        <div class="form-group">
                            <label for="tybe">النوع</label>
                            <select class="form-control form-control bg-gradient-dark" name="tybe" id="tybe" required>
                                <option value="0" {{ old('tybe', $allowance->tybe) == 0 ? 'selected' : '' }}>استقطاع</option>
                                <option value="1" {{ old('tybe', $allowance->tybe) == 1 ? 'selected' : '' }}>بدل</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="info">ملاحظات</label>
                            <input value="{{ old('info', $allowance->info) }}" class="form-control form-control bg-gradient-dark" name="info" type="text" id="info">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-warning btn-block" type="submit">{{ $lang['lang_publicconfirm'] ?? 'تأكيد' }}</button>
                        <a href="{{ route('allowances.index') }}" class="btn btn-secondary btn-block">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
