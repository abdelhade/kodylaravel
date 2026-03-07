@extends('dashboard.layout')

@section('content')
    <div class="container-fluid p-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">
                            <i class="fas fa-lock me-2"></i>
                            تأمين الإعدادات
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('settings.index') }}" method="post">
                            @csrf

                            @if (isset($error))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    {{ $error }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                @if (isset($debug))
                                    <div class="alert alert-info">
                                        <small>{{ $debug }}</small>
                                    </div>
                                @endif
                            @endif

                            <div class="text-center mb-4">
                                <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                                <p class="text-muted">الرجاء إدخال كلمة المرور للوصول إلى الإعدادات</p>
                            </div>

                            <div class="form-group mb-4">
                                <label for="password" class="form-label">كلمة المرور</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <input class="form-control form-control-lg" type="password" name="password"
                                        id="password" placeholder="أدخل كلمة المرور" required autofocus>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    كلمة المرور الافتراضية: <code>198</code>
                                </small>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    دخول
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
