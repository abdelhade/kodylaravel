@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ $lang['lang_addjop'] ?? 'إضافة وظيفة' }}</h3>
                </div>
                <form role="form" action="{{ route('jobs.store') }}" method="post">
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

                        <div class="form-group">
                            <label for="name">{{ $lang['lang_namejop'] ?? 'اسم الوظيفة' }}</label>
                            <input name="name" type="text" class="form-control" placeholder="{{ $lang['lang_plholder_jop'] ?? 'اكتب اسم الوظيفة' }}" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="info">{{ $lang['lang_publicinfo'] ?? 'معلومات' }}</label>
                            <textarea class="form-control" name="info" id="info" cols="20" rows="5">{{ old('info') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">{{ $lang['lang_publicconfirm'] ?? 'تأكيد' }}</button>
                        <a href="{{ route('jobs.index') }}" class="btn btn-secondary btn-block">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
