<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{!! asset('public/css/pdf-style.css') !!}" />
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{!! asset('public/images/logo.png') !!}" width="182" height="89">
        </div>
    </div>
    <div class="footer">
        <div class="pagenum">Page <span></span></div>
    </div>
    @yield('content')
</body>
<html>
