@if(count($replies))
    <ul class="list-group">
        @foreach($replies as $reply)
            <li class="list-group-item">
                <a href="{{ $reply->topic->link(['#reply' . $reply->id]) }}">
                    {{ $reply->topic->title }}
                </a>
                <div class="reply-content">
                    {!! $reply->content !!}
                </div>
                <div class="meta">
                    <span class="oi oi-clock"></span> 回复于 {{ $reply->created_at->diffForHumans() }}
                </div>
            </li>
        @endforeach
    </ul>
@else
    <div>暂无数据</div>
@endif

{{-- 分页 --}}
{!! $replies->appends(Request::except('page'))->render() !!}