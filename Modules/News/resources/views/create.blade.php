@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-primary col-md-8">
                <div class="card-header">
                    <h3 class="hadi-wonder">خبر جديد</h3>
                </div>
                <form action="{{ route('news.store') }}" method="post" enctype="multipart/form-data">
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
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="form-group col-md-10">
                            <label for="title">عنوان الخبر</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                        </div>

                        <div class="form-group col-md-10">
                            <label for="img" class="btn btn-secondary">اختر صورة</label>
                            <input id="img" type="file" class="form-control" name="img" accept="image/*">
                            <div id="imgPreview" class="mt-2"></div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="content">محتوى الخبر</label>
                            <textarea id="summernote" class="" name="content" required>{{ old('content') }}</textarea>
                        </div>

                        <div class="form-group col-md-10">
                            <label for="tags">Tags</label>
                            <input type="text" class="form-control" name="tags" id="tags" value="{{ old('tags') }}" placeholder="مثال: عامة، أخبار">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">حفظ</button>
                        <a href="{{ route('news.index') }}" class="btn btn-secondary btn-block">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('native/plugins/summernote/summernote-bs4.min.js') }}"></script>
<link href="{{ asset('native/plugins/summernote/summernote-bs4.min.css') }}" rel="stylesheet">
<script>
$(function () {
    // Summernote
    $('#summernote').summernote({
        height: 300,
        lang: 'ar-AR'
    });

    // Image preview
    $('#img').on('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imgPreview').html('<img src="' + e.target.result + '" style="max-width: 200px; max-height: 200px; border-radius: 8px; margin-top: 10px;">');
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>
@endsection
