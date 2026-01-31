@extends('dashboard.layout')

@section('content')
<style>
    .ltr {
        direction: ltr;
        width: 80%;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="ltr card card-primary">
                <div class="card-header">
                    <h3 class="card-title">تعديل القسم</h3>
                </div>
                <form role="form" action="{{ route('departments.update', ['id' => $department->id]) }}" method="POST">
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
                            <label for="name">{{ $lang['lang_publicname'] ?? 'الاسم' }}</label>
                            <input name="name" type="text" class="form-control" placeholder="اكتب اسم القسم" value="{{ old('name', $department->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="info">{{ $lang['lang_publicinfo'] ?? 'معلومات' }}</label>
                            <textarea class="form-control" name="info" id="info" cols="20" rows="5">{{ old('info', $department->info) }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ $lang['lang_publicconfirm'] ?? 'تأكيد' }}</button>
                        <a href="{{ route('departments.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
