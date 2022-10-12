<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Sistema de Gestión" />
    <title>GESTAPP</title>
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skin-blue.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    
    <div class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <b>GESTAPP</b>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <form method="post" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group has-feedback @error('email') has-error @enderror">
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" autofocus />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @error('email')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group has-feedback @error('password') has-error @enderror">
                        <input type="password" name="password" class="form-control" placeholder="Password" />
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @error('password')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                        </div>
                        @error('error')
                        <div class="col-xs-12 m-t-20">
                            <div class="alert alert-warning">{{ $message }}</div>
                        </div>
                        @enderror
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
    </div>

  </body>
  <!-- jQuery 2.2.0 -->
  <script src="{{ asset('plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="{{ asset('js/bootstrap/js/bootstrap.min.js') }}"></script>
  <!-- iCheck -->
  <script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
  <!-- App Js -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
      $(function () {
          $('input').iCheck({
              checkboxclass: 'icheckbox_square-blue',
              radioclass: 'iradio_square-blue',
              increaseArea: '20%' // optional
          });
      });
  </script>
</html>
