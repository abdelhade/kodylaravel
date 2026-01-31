@extends('kody2::layouts.auth')

@section('content')
  @if($errors->any())
    <div class="alert alert-danger">
      <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
    </div>
  @endif

  <form action="{{ route('login.submit') }}" method="post">
    @csrf
    
    <div class="form-group">
      <label for="uname">
        <i class="fas fa-user"></i> المستخدم
      </label>
      <div class="input-wrapper">
        <select name="uname" id="uname" class="form-control" required>
          <option value="">اختر المستخدم...</option>
          @foreach($users as $user)
            <option value="{{ $user->uname }}">{{ $user->uname }}</option>
          @endforeach
        </select>
        <i class="fas fa-chevron-down"></i>
      </div>
    </div>

    <div class="form-group">
      <label for="password">
        <i class="fas fa-lock"></i> كلمة المرور
      </label>
      <div class="input-wrapper">
        <input type="password" name="password" id="password" class="form-control" placeholder="أدخل كلمة المرور" required>
        <i class="fas fa-lock"></i>
      </div>
    </div>

    <div class="remember-me">
      <input type="checkbox" id="remember" name="remember">
      <label for="remember">تذكرني</label>
    </div>

    <button type="submit" class="btn-login">
      <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
    </button>
  </form>
@endsection
