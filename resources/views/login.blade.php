<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ِAmber | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @include('admin.layout.head')
</head>
<body class="hold-transition login-page">
<div class="login-box w-50">

  <div class="login-logo">
    <a href="#"> أهلا وسهلا بك في نظام <b>AMBER</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg px-5">تسجيل الدخول من خلال البريد الإلكتروني وكلمة السر</p>

      <form dir="rtl" class="container-fluid my-1" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email input -->
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="البريد الإلكتروني" value="{{ old('email') }}" required autocomplete="email" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <!-- Password input -->
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="كلمة السر" required autocomplete="current-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <!-- Submit button -->
        <div class="social-auth-links text-center mb-3">
          <button type="submit" class="btn btn-primary btn-block mb-4 text-center align-items-center">تسجيل الدخول</button>
        </div>

      </form>

    </div>
    <!-- /.login-card-body -->
  </div>

</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
