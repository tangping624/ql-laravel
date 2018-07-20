<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' : '' }}{{ config('app.name') }}后台管理</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @yield('css')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/utils.js') }}"></script>
    <script src="{{ asset('plugins/layer/layer.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    </script>
    <?php $inIframe = $inIframe ?? false; ?>
</head>
<body{!! $inIframe ? ' style="padding: 0; background-color: transparent;"' : '' !!}>
@if (!$inIframe)
    @include('admin.public.nav')
@endif
    <div class="container-fluid main-content">
        @yield('content')
    </div>

    @yield('js')
</body>
</html>
