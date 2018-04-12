<div class="media">
    <img class="mr-3 img-thumbnail" src="{{ $notification->data['user_avatar'] }}" alt="{{ $notification->data['user_name'] }}" style="width: 48px;height: 48px;">
    <div class="media-body">
        <div>
            <a href="{{ route('users.show', $notification->data['user_id']) }}">
                {{ $notification->data['user_name'] }}
            </a>
            评论了
            <a href="{{ $notification->data['topic_link'] }}">
                {{ $notification->data['topic_title'] }}
            </a>
            {{-- 创建时间 --}}
            <span class="meta float-right">
                <i class="oi oi-clock" aria-hidden="true"></i>
                {{ $notification->created_at->diffForHumans() }}
            </span>
        </div>
        <div class="reply-content">
            {!! $notification->data['reply_content'] !!}
        </div>
    </div>
</div>