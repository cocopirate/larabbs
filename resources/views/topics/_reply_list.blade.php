<div class="reply-list">
    @foreach($replies as $index => $reply)
        <div class="media" name="reply{{ $reply->id }}" id="reply{{ $reply->id }}">
            <img class="avatar img-thumbnail mr-3" src="{{ $reply->user->avatar }}" alt="{{ $reply->user->name }}" style="width: 48px; height: 48px;">
            <div class="media-body">
                <div>
                    <a class="mt-0" href="{{ route('users.show', $reply->user_id) }}">{{ $reply->user->name }}</a>
                    <span> • </span>
                    <span class="meta">{{ $reply->created_at->diffForHumans() }}</span>

                    {{-- 回复删除按钮 --}}
                    @can('destroy', $reply)
                        <span class="meta float-right">
                            <form action="{{ route('replies.destroy', $reply->id) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-light btn-xs">
                                    <i class="oi oi-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                        </span>
                    @endcan
                </div>
                <div class="reply-content">
                    {!! $reply->content !!}
                </div>
            </div>
        </div>
        <hr />
    @endforeach
</div>