@extends('kody2::layouts.auth')

@section('content')
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Kody</b>POS</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
      @endif

      <form action="{{ route('kody2.login.submit') }}" method="post">
        @csrf
        <div class="input-group mb-3">
            <select name="uname" class="form-control" required>
                <option value="">Select User...</option>
                @foreach($users as $user)
                    <option value="{{ $user->uname }}">{{ $user->uname }}</option>
                @endforeach
            </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
@endsection
