@if (isset($comments) && count($comments) > 0 && isset($requestID))
    <div class="panel panel-primary">
        <div class="panel-heading">Comments</div>
        <div class="list-group list-group-item" style="overflow-y:scroll; max-height: 300px;">
            @foreach($comments as $comment)
                <a href="#" class="list-group-item">
                    <h4 class="list-group-item-heading">
                        <b>{{ $comment->commentable->name }}</b>
                    </h4>

                    <p class="list-group-item-text">
                        {{ $comment->comment }}
                    </p>
                    <h5 class="list-group-item-text text-right text-muted">{{ $comment->created_at->setTimezone('America/Detroit')->format('m/d/Y g:ia') }}</h5>
                </a>
            @endforeach
        </div>
        <div style="margin: 5px;">
            <form action="{{ URL::route('comment',$requestID) }}" method="post" id="comment">
                {{ csrf_field() }}

                <div class="input-group">
                    <input id="comment" name="comment" type="text" class="form-control" placeholder="Comment" required>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">Post</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
@endif