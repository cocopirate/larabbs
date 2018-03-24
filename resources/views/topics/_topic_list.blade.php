@if(count($topics))
    <ul class="list-unstyled">
        @foreach($topics as $topic)
            <li class="media">
                <div class="media-left">
                    <a href="{{ route('users.show', [$topic->user_id]) }}">
                        <img class="mr-2 img-thumbnail" style="width: 52px; height: 52px;" src="{{ $topic->user->avatar }}" title="{{ $topic->user->name }}" />
                    </a>
                </div>
                <div class="media-body">
                    <div class="media-heading">
                        <a href="{{ route('topics.show', [$topic->id]) }}" title="{{ $topic->title }}">
                            {{ $topic->title }}
                        </a>
                        <a class="float-right" href="{{ route('topics.show', [$topic->id]) }}">
                            <span class="badge badge-primary">{{ $topic->reply_count }}</span>
                        </a>
                    </div>
                    <div class="media-body meta">
                        <a href="#" title="{{ $topic->category->name }}">
                            <span class="oi oi-folder" aria-hidden="true"></span>
                            {{ $topic->category->name }}
                        </a>
                        <span> • </span>
                        <a href="{{ route('users.show', [$topic->user_id]) }}" title="{{ $topic->user->name }}">
                            <span class="oi oi-person" aria-hidden="true"></span>
                            {{ $topic->user->name }}
                        </a>
                        <span> • </span>
                        <span class="oi oi-clock" aria-hidden="true"></span>
                        <span title="最后活跃于">{{ $topic->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </li>

            @if(!$loop->last)
                <hr/>
            @endif

        @endforeach
    </ul>
@else
    <div class="alert alert-dark" role="alert">暂无数据</div>
@endif