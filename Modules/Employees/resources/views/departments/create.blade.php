@extends('dashboard.layout')

@section('content')
   

    <div class="container-fluid row justify-content-center">
        <div class="card col-9 ">
            <div class="card-header ">
                <h3 class="card-title text-black fs-bold">إضافة قسم جديد</h3>
            </div>
            <form role="form" action="{{ route('departments.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="name">{{ $lang['lang_publicname'] ?? 'الاسم' }}</label>
                        <input name="name" type="text" class="form-control" placeholder="اكتب اسم القسم"
                            value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="info">{{ $lang['lang_publicinfo'] ?? 'معلومات' }}</label>
                        <textarea class="form-control" name="info" id="info" cols="20" rows="5">{{ old('info') }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ $lang['lang_publicconfirm'] ?? 'تأكيد' }}</button>
                    <a href="{{ route('departments.index') }}" class="btn btn-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>

@endsection
