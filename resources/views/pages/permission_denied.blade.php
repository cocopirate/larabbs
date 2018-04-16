@extends('layouts.app')
@section('title', '无访问权限')
@section('content')
    <div class="col-md-4 offset-4">
        <div class="card">
            <div class="card-body">
                @if(Auth::check())
                    <div class="alert alert-danger text-center">当前登录账号无后台访问权限。</div>
                @else
                    <div class="alert alert-danger text-center">请登录以后再操作。</div>
                    <a class="btn btn-primary" href="{{ route('login') }}">
                        <i class="oi oi-account-login" aria-hidden="true"></i> 登 录
                    </a>
                @endif
            </div>
        </div>
    </div>
@stop