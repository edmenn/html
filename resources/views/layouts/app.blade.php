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
<!-- dataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
    @include('layouts.header')
    <main>
        @yield('content')
    </main>
    @include('layouts.footer')
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
<!-- dataTables -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
$(function () {
    $('input').iCheck({
        checkboxclass: 'icheckbox_square-blue',
        radioclass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});
</script>
@stack('scripts')
</html>