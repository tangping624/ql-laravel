@extends('admin.public.layouts')

@section('content')
    <h1>欢迎您，管理员：{{ Auth::user()->name }}</h1>
@endsection

@section('css')
<style type="text/css">
.main-content {margin-left: -200px;}
</style>
@endsection
