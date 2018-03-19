@extends('layouts.app')

@section('title', '编辑资料')

@section('content')

    <div class="card">
        <div class="card-header">
            <h4><i class="glyphicon glyphicon-edit"></i>编辑个人资料</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('users.update', $user->id) }}" accept-charset="UTF-8" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">用户名</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $user->name) }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">邮 箱</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', $user->email) }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="introduction" class="col-md-4 col-form-label text-md-right">个人简介</label>

                    <div class="col-md-6">
                        <textarea id="introduction" class="form-control{{ $errors->has('introduction') ? ' is-invalid' : '' }}" name="introduction">{{ $user->introduction }}</textarea>

                        @if ($errors->has('introduction'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('introduction') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="avatar" class="col-md-4 col-form-label text-md-right">用户头像</label>

                    <div class="col-md-6">
                        <input id="avatar" type="file" name="avatar" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}"/>

                        @if ($errors->has('avatar'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                        @endif
                        
                        @if($user->avatar)
                            <br/>
                            <img class="img-thumbnail img-responsive" src="{{ $user->avatar }}" width="200px">
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

@stop