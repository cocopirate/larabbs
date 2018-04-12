<div class="reply-box">
    <form action="{{ route('replies.store') }}" method="POST" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
        <div class="form-group">
            <textarea name="reply_content" class="form-control {{$errors->has('reply_content') ? ' is-invalid' : ''}}" rows="3" placeholder="分享你的想法"></textarea>
            @if ($errors->has('reply_content'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('reply_content') }}</strong>
                </span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary btn-sm"><span class="oi oi-share"></span>回复</button>
    </form>
</div>