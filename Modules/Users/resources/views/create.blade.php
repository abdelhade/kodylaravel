@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="col">
                <div class="card card-primary col-lg-3">
                    <div class="card-header">
                        <h3 class="card-title">{{ $lang['lang_add_new_user'] ?? 'إضافة مستخدم جديد' }}</h3>
                    </div>

                    <form role="form" action="{{ route('users.store') }}" method="post" autocomplete="off" enctype="multipart/form-data">
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

                            <div class="form-group">
                                <label for="uname">{{ $lang['lang_username'] ?? 'اسم المستخدم' }}</label>
                                <input required name="uname" type="text" class="form-control" id="uname" 
                                       placeholder="{{ $lang['lang_pbholder_uname'] ?? 'أدخل اسم المستخدم' }}" 
                                       value="{{ old('uname') }}">
                            </div>

                            <div class="form-group">
                                <label for="password">{{ $lang['lang_password'] ?? 'كلمة المرور' }}</label>
                                <input name="password" type="password" class="form-control" id="password" 
                                       placeholder="{{ $lang['lang_pbholder_password'] ?? 'أدخل كلمة المرور' }}" required>
                            </div>

                            <div class="form-group">
                                <label for="userrole">دور المستخدم</label>
                                <select name="userrole" class="form-control" id="userrole" required>
                                    @foreach($roles as $roleItem)
                                        <option value="{{ $roleItem->id }}" {{ old('userrole') == $roleItem->id ? 'selected' : '' }}>
                                            {{ $roleItem->rollname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <br>
                            <label for="img" class="btn btn-outline-secondary btn-lg">
                                {{ $lang['lang_image_upload'] ?? 'رفع صورة' }}
                            </label>
                            <input hidden type="file" name="img" id="img" accept="image/*">
                            <div id="imgPreview" class="mt-2"></div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{ $lang['lang_publicconfirm'] ?? 'تأكيد' }}</button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imgInput = document.getElementById('img');
    const imgPreview = document.getElementById('imgPreview');
    
    if (imgInput) {
        imgInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.innerHTML = '<img src="' + e.target.result + '" style="max-width: 200px; max-height: 200px; border-radius: 8px; margin-top: 10px;">';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});
</script>
@endsection
