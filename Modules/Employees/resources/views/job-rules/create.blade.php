@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ $lang['lang_add_joprule'] ?? 'إضافة قاعدة وظيفة' }}</h3>
                </div>
                <form action="{{ route('job-rules.store') }}" method="post">
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
                            <label for="name">{{ $lang['lang_name_rule'] ?? 'اسم القاعدة' }}</label>
                            <input name="name" type="text" class="form-control" 
                                   placeholder="{{ $lang['lang_plholder_joprule'] ?? 'أدخل اسم القاعدة' }}"
                                   value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="info">{{ $lang['lang_publicinfo'] ?? 'المعلومات' }}</label>
                            <textarea class="form-control" name="info" id="info" cols="20" rows="5">{{ old('info') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ $lang['lang_publicconfirm'] ?? 'تأكيد' }}</button>
                        <a href="{{ route('job-rules.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
