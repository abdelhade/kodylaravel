@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">إضافة معدل تقييم</h3>
                </div>
                <form action="{{ route('kbis.store') }}" method="post">
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
                            <label for="kname">الاسم</label>
                            <input type="text" name="kname" id="kname" class="form-control" placeholder="اكتب معدل الأداء" value="{{ old('kname') }}" autofocus required>
                        </div>
                        <div class="form-group">
                            <label for="ktybe">النوع</label>
                            <input type="text" name="ktybe" id="ktybe" class="form-control" placeholder="اكتب معدل النوع" value="{{ old('ktybe') }}">
                        </div>
                        <div class="form-group">
                            <label for="info">الوصف</label>
                            <textarea class="form-control" name="info" id="info" cols="20" rows="5">{{ old('info') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">تأكيد</button>
                        <a href="{{ route('kbis.index') }}" class="btn btn-secondary btn-block">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
