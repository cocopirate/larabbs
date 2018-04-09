@extends('layouts.app')

@section('title', $topic->title)

@section('description', $topic->excerpt)

@section('content')

    <div class="row">
        <div class="col-lg-3 col-md-3 author-info">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        作者：{{ $topic->user->name }}
                    </div>
                    <hr />
                    <a href="{{ route('users.show', $topic->user->id) }}">
                        <img width="300px" height="300px" class="img-thumbnail img-fluid" src="{{ $topic->user->avatar }}">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 topic-content">
            <div class="card">
                <div class="card-body">

                    <h1 class="text-center">{{ $topic->title }}</h1>

                    <div class="article-meta text-center">
                        {{ $topic->created_at->diffForHumans() }}
                        .
                        <span class="oi oi-comment-square"></span>
                        {{ $topic->reply_count }}
                    </div>

                    <div class="topic-body">
                        {!! $topic->body !!}
                    </div>

                    @can('update', $topic)
                        <div class="operate">
                            <hr />

                            <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-primary btn-xs float-left" role="button">
                                <span class="oi oi-pencil"></span>编辑
                            </a>

                            <form class="float-left" style="margin-left: 10px" action="{{ route('topics.destroy', $topic->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-primary btn-xs" role="button">
                                    <span class="oi oi-trash"></span>删除
                                </button>
                            </form>

                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@stop
