@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ $lang['lang_add_joplevel'] ?? 'إضافة مستوى وظيفة' }}</h3>
                </div>
                <form action="{{ route('job-levels.store') }}" method="post">
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
                            <label for="name">{{ $lang['lang_name_joplevel'] ?? 'اسم المستوى' }}</label>
                            <input name="name" type="text" class="form-control" 
                                   placeholder="{{ $lang['lang_plholder_joplvl'] ?? 'أدخل اسم المستوى' }}"
                                   value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="info">{{ $lang['lang_publicinfo'] ?? 'المعلومات' }}</label>
                            <textarea class="form-control" name="info" id="info" cols="20" rows="5">{{ old('info') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ $lang['lang_publicconfirm'] ?? 'تأكيد' }}</button>
                        <a href="{{ route('job-levels.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
