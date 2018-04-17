@extends('layouts.app')

@section('title', $user->name . ' 个人中心')

@section('content')

    <div class="row">

        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
            <div class="card">
                <div class="card-body">
                    <img class="img-thumbnail img-fluid" src="{{ $user->avatar }}">
                    <hr />
                    <h4><strong>个人简介</strong></h4>
                    @if(!empty($user->introduction))
                        <p>{{ $user->introduction }}</p>
                    @else
                        <p>这人很懒，没有简介哟</p>
                    @endif
                    <hr />
                    <h4><strong>注册于</strong></h4>
                    <p>{{ $user->created_at->diffForHumans() }}</p>
                    <h4><strong>最后活跃于</strong></h4>
                    <p>{{ $user->last_actived_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body" style="font-size: 24px;">{{ $user->name }} <span style="font-size: 14px;">{{ $user->email }}</span></div>
            </div>
            <hr />
            {{-- 用户发布的内容 --}}
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(if_query('tab', null)) }}" href="{{ route('users.show', $user->id) }}">Ta 的话题</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(if_query('tab', 'replies')) }}" href="{{ route('users.show', [$user->id, 'tab'=>'replies']) }}">Ta 的回复</a>
                        </li>
                    </ul>
                    @if(if_query('tab', 'replies'))
                        @include('users._replies', ['replies' => $user->replies()->with('topic')->recent()->paginate(5)])
                    @else
                        @include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])
                    @endif
                </div>
            </div>
        </div>

    </div>

@stop