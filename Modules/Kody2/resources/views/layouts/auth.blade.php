<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KodyPOS | تسجيل الدخول</title>

  <!-- Google Font: Cairo -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ module_asset('kody2', 'plugins/fontawesome-free/css/all.min.css') }}">
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      direction: rtl;
    }

    .login-container {
      width: 100%;
      max-width: 450px;
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      overflow: hidden;
      animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-header {
      background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
      padding: 40px 30px;
      text-align: center;
    }

    .logo-container {
      margin-bottom: 20px;
    }

    .logo-container img {
      max-width: 120px;
      height: auto;
      filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
    }

    .login-header h1 {
      color: #ffffff;
      font-size: 28px;
      font-weight: 700;
      margin: 0;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .login-header p {
      color: rgba(255, 255, 255, 0.9);
      font-size: 14px;
      margin-top: 8px;
    }

    .login-body {
      padding: 40px 30px;
    }

    .form-group {
      margin-bottom: 25px;
      position: relative;
    }

    .form-group label {
      display: block;
      color: #374151;
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .input-wrapper {
      position: relative;
    }

    .input-wrapper i {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #6b7280;
      font-size: 16px;
    }

    .form-control {
      width: 100%;
      padding: 14px 45px 14px 15px;
      border: 2px solid #e5e7eb;
      border-radius: 10px;
      font-size: 15px;
      transition: all 0.3s ease;
      background: #f9fafb;
      color: #111827;
      font-family: 'Cairo', sans-serif;
    }

    .form-control:focus {
      outline: none;
      border-color: #2563eb;
      background: #ffffff;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-control::placeholder {
      color: #9ca3af;
    }

    select.form-control {
      cursor: pointer;
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: left 15px center;
      padding-left: 40px;
    }

    .alert {
      padding: 12px 15px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 14px;
      border: none;
    }

    .alert-danger {
      background: #fef2f2;
      color: #dc2626;
      border-left: 4px solid #dc2626;
    }

    .remember-me {
      display: flex;
      align-items: center;
      margin-bottom: 25px;
    }

    .remember-me input[type="checkbox"] {
      width: 18px;
      height: 18px;
      margin-left: 10px;
      cursor: pointer;
      accent-color: #2563eb;
    }

    .remember-me label {
      color: #6b7280;
      font-size: 14px;
      cursor: pointer;
      margin: 0;
      font-weight: 400;
    }

    .btn-login {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
      color: #ffffff;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      font-family: 'Cairo', sans-serif;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(37, 99, 235, 0.5);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    @media (max-width: 480px) {
      .login-container {
        border-radius: 15px;
      }

      .login-header {
        padding: 30px 20px;
      }

      .login-header h1 {
        font-size: 24px;
      }

      .login-body {
        padding: 30px 20px;
      }

      .logo-container img {
        max-width: 100px;
      }
    }

    @media (max-width: 360px) {
      body {
        padding: 10px;
      }

      .login-header h1 {
        font-size: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-header">
      <div class="logo-container">
        <img src="{{ module_asset('kody2', 'logo/logo.png') }}" alt="KodyPOS Logo" onerror="this.src='{{ module_asset('kody2', 'logo/logo.jpg') }}'; this.onerror=null;">
      </div>
      <h1>KodyPOS</h1>
      <p>نظام إدارة نقاط البيع</p>
    </div>
    
    <div class="login-body">
      @yield('content')
    </div>
  </div>

  <!-- jQuery -->
  <script src="{{ module_asset('kody2', 'plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ module_asset('kody2', 'plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
