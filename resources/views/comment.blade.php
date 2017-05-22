<div class="comment-content" data-id="{{ $comment->id }}" data-parent-id="{{ $comment->parent_id or '' }}" style="margin-left: {{ $margin or 0 }}px;">
    <div class="comment-wrap">
        <div class="comment-block">
            @if ($comment->trashed())
                <p class="comment-text">This comment is deleted</p>
            @else
                <p class="comment-text">{{ $comment->comment }}</p>
                <div class="bottom-comment">
                    <div class="comment-date">{{ $comment->updated_at }}</div>
                    <ul class="comment-actions">
                        <li class="reply">Reply</li>
                        <li class="edit">Edit</li>
                        <li class="delete">Delete</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>