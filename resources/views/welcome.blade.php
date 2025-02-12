@extends('layouts.app')

@section('content')
<div class="container text-center">
    <div class="mt-5">
        <img src="/img/logos/logo_ntd.png" alt="Logo">
    </div>
    <div class="mb-2">
        <a href="{{route('login')}}" class="btn btn-primary">Đăng nhập</a>
    </div>
    <div class="mt-5">
        <h3 class="text-uppercase">Hệ thống quản lý công việc</h3>
    </div>
</div>
@endsection