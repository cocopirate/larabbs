<div class="card">
    <div class="card-body">
        <a href="{{ route('topics.create') }}" class="btn btn-success btn-block" aria-label="Left Align">
            <span class="oi oi-pencil"></span> 新建帖子
        </a>
    </div>
</div>

@if(count($active_users))
    <div class="card active-users">
        <div class="card-body">
            <div class="text-center">活跃用户</div>
            <hr />
            @foreach($active_users as $active_user)
                <a class="d-block" href="{{ route('users.show', $active_user->id) }}">
                    <img src="{{ $active_user->avatar }}" style="width: 24px;height: 24px;" />
                    <span>{{ $active_user->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
@endif