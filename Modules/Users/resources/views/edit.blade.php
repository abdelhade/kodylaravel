@extends('dashboard.layout')

@section('content')
<style>
    .edit-user-container {
        padding: 30px;
        background-color: #f8f9fc;
        min-height: 100vh;
    }
    
    .edit-user-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        border: 1px solid #eef2f7;
        overflow: hidden;
    }
    
    .card-header-clean {
        background: #f8f9fc;
        padding: 25px 30px;
        border-bottom: 1px solid #eef2f7;
    }
    
    .card-title-clean {
        margin: 0;
        font-weight: 700;
        font-size: 1.5rem;
        color: #2d3748;
    }
    
    .card-body-clean {
        padding: 30px;
    }
    
    .form-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        max-width: 1000px;
    }
    
    .form-group-clean {
        margin-bottom: 0;
    }
    
    .form-label-clean {
        display: block;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 10px;
        font-size: 1rem;
    }
    
    .form-control-clean {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }
    
    .form-control-clean:focus {
        border-color: #2d3748;
        outline: none;
        box-shadow: 0 0 0 3px rgba(45, 55, 72, 0.1);
    }
    
    .form-text-clean {
        display: block;
        margin-top: 8px;
        font-size: 0.9rem;
        color: #718096;
    }
    
    .file-upload-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .file-upload-label {
        background: #f8f9fc;
        border: 2px dashed #cbd5e0;
        border-radius: 10px;
        padding: 25px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        color: #4a5568;
    }
    
    .file-upload-label:hover {
        border-color: #2d3748;
        background: #f7fafc;
    }
    
    .file-input {
        display: none;
    }
    
    .current-image {
        text-align: center;
        margin-top: 15px;
    }
    
    .current-image img {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        object-fit: cover;
        border: 3px solid #eef2f7;
    }
    
    .btn-submit-clean {
        background: #2d3748;
        border: none;
        border-radius: 10px;
        padding: 16px 32px;
        font-weight: 600;
        color: white;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        max-width: 200px;
    }
    
    .btn-submit-clean:hover {
        background: #4a5568;
        transform: translateY(-2px);
    }
    
    .card-footer-clean {
        padding: 25px 30px;
        background: #f8f9fc;
        border-top: 1px solid #eef2f7;
        text-align: left;
    }
    
    .password-match-error {
        color: #e53e3e;
        font-size: 0.9rem;
        margin-top: 5px;
        display: none;
    }
</style>

<div class="edit-user-container container">
    <div class="edit-user-card">
        <div class="card-header-clean">
            <h3 class="card-title-clean">
                <i class="fas fa-user-edit mr-2"></i>
                تعديل المستخدم
            </h3>
        </div>
        
        <form role="form" enctype="multipart/form-data" action="{{ route('users.update', ['id' => $user->id]) }}" method="post" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="card-body-clean">
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

                <div class="form-container">
                    <!-- اسم المستخدم -->
                    <div class="form-group-clean">
                        <label class="form-label-clean" for="uname">
                            <i class="fas fa-user mr-2"></i>
                            {{ $lang['lang_username'] ?? 'اسم المستخدم' }}
                        </label>
                        <input value="{{ old('uname', $user->uname) }}" name="uname" type="text" class="form-control-clean" 
                               id="uname" placeholder="اكتب اسم المستخدم" required>
                    </div>

                    <!-- دور المستخدم -->
                    <div class="form-group-clean">
                        <label class="form-label-clean" for="userrole">
                            <i class="fas fa-user-tag mr-2"></i>
                            دور المستخدم
                        </label>
                        <select name="userrole" class="form-control-clean" id="userrole" required>
                            @foreach($roles as $roleItem)
                                <option value="{{ $roleItem->id }}" 
                                    {{ old('userrole', $user->userrole) == $roleItem->id ? 'selected' : '' }}>
                                    {{ $roleItem->rollname }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if(isset($role) && isset($role['edit_user_passwords']) && $role['edit_user_passwords'] == 1)
                    <!-- كلمة المرور الجديدة -->
                    <div class="form-group-clean">
                        <label class="form-label-clean" for="password">
                            <i class="fas fa-lock mr-2"></i>
                            كلمة المرور الجديدة
                        </label>
                        <input name="password" type="password" class="form-control-clean" id="password"
                               placeholder="اترك فارغاً إذا كنت لا تريد تغيير كلمة المرور">
                        <span class="form-text-clean">اترك هذا الحقل فارغاً إذا كنت لا تريد تغيير كلمة المرور</span>
                    </div>

                    <!-- تأكيد كلمة المرور -->
                    <div class="form-group-clean">
                        <label class="form-label-clean" for="confirm_password">
                            <i class="fas fa-lock mr-2"></i>
                            تأكيد كلمة المرور
                        </label>
                        <input name="confirm_password" type="password" class="form-control-clean" id="confirm_password"
                               placeholder="تأكيد كلمة المرور الجديدة">
                        <div class="password-match-error" id="passwordError">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            كلمات المرور غير متطابقة
                        </div>
                    </div>
                    @endif

                    <!-- رفع الصورة -->
                    <div class="form-group-clean">
                        <label class="form-label-clean">
                            <i class="fas fa-image mr-2"></i>
                            صورة المستخدم
                        </label>
                        <div class="file-upload-container">
                            <label for="img" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-3"></i>
                                <br>
                                {{ $lang['lang_image_upload'] ?? 'رفع صورة' }}
                                <br>
                                <small class="text-muted">انقر لاختيار صورة</small>
                            </label>
                            <input type="file" name="img" id="img" class="file-input" accept="image/*">
                            
                            <!-- عرض الصورة الحالية -->
                            @if(!empty($user->img))
                            <div class="current-image">
                                <p class="form-text-clean">الصورة الحالية:</p>
                                <img src="{{ asset('uploads/' . $user->img) }}" alt="صورة المستخدم الحالية" 
                                     onerror="this.style.display='none'">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer-clean">
                <button type="submit" class="btn-submit-clean">
                    <i class="fas fa-save mr-2"></i>
                    حفظ التغييرات
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('confirm_password');
        const passwordError = document.getElementById('passwordError');
        const form = document.querySelector('form');
        const fileInput = document.getElementById('img');
        const fileUploadLabel = document.querySelector('.file-upload-label');

        // التحقق من تطابق كلمات المرور
        function validatePasswords() {
            if (passwordField && confirmPasswordField) {
                if (passwordField.value !== '' || confirmPasswordField.value !== '') {
                    if (passwordField.value !== confirmPasswordField.value) {
                        if (passwordError) {
                            passwordError.style.display = 'block';
                        }
                        if (confirmPasswordField) {
                            confirmPasswordField.style.borderColor = '#e53e3e';
                        }
                        return false;
                    } else {
                        if (passwordError) {
                            passwordError.style.display = 'none';
                        }
                        if (confirmPasswordField) {
                            confirmPasswordField.style.borderColor = '#2d3748';
                        }
                        return true;
                    }
                }
            }
            return true;
        }

        if (passwordField && confirmPasswordField) {
            passwordField.addEventListener('input', validatePasswords);
            confirmPasswordField.addEventListener('input', validatePasswords);
        }

        // إظهار اسم الملف عند اختياره
        if (fileInput && fileUploadLabel) {
            fileInput.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    const fileName = this.files[0].name;
                    fileUploadLabel.innerHTML = `
                        <i class="fas fa-check-circle fa-2x mb-3 text-success"></i>
                        <br>
                        تم اختيار الملف
                        <br>
                        <small class="text-success">${fileName}</small>
                    `;
                    fileUploadLabel.style.borderColor = '#38a169';
                }
            });
        }

        if (form) {
            form.addEventListener('submit', function(e) {
                if (!validatePasswords()) {
                    e.preventDefault();
                    // تمرير للأعلى لرؤية الخطأ
                    if (passwordError) {
                        passwordError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        }
    });
</script>
@endsection
