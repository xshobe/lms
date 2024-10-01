<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>::: {!! Config::get('constants.app_name') !!} ::: - {!! $page_title or '' !!}</title>
    <link rel="stylesheet" href="{!! asset('public/css/ddsmoothmenu.css') !!}" />
    <link rel="stylesheet" href="{!! asset('public/css/font-awesome.min.css') !!}" />
    <link rel="stylesheet" href="{!! asset('public/css/style.css') !!}" />
    <link rel="stylesheet" href="{!! asset('public/css/media.css') !!}" />
    <script type="text/javascript" src="{!! asset('public/js/jquery.min.js') !!}"></script>
</head>
<body>
    @include('layouts.front.header')
    @yield('content')
    @include('layouts.front.footer')
</body>
</html>
