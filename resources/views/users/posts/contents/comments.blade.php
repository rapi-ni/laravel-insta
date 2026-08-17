<section class="post-comments" aria-label="Comments">
    @php
        $rootComments = $post->comments->whereNull('parent_id');
        $visibleComments = ($showAllComments ?? false) ? $rootComments : $rootComments->take(3);
    @endphp
    @if ($post->comments->isNotEmpty())
        <div class="post-comments-heading">
            <span>Comments</span>
            <span>{{ $post->comments->count() }}</span>
        </div>

        <div class="post-comment-list">
            @foreach ($visibleComments as $comment)
                <article class="post-comment">
                    <a href="{{ route('profile.show', $comment->user->id) }}" class="post-comment-avatar">
                        @if($comment->user->avatar)
                            <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}">
                        @else
                            <i class="fa-solid fa-circle-user"></i>
                        @endif
                    </a>

                    <div class="post-comment-content">
                        <div class="post-comment-bubble">
                            <a href="{{ route('profile.show', $comment->user->id) }}" class="post-comment-author">{{ $comment->user->name }}</a>
                            <p>{{ $comment->body }}</p>
                        </div>

                        <div class="post-comment-meta">
                            <time datetime="{{ $comment->created_at->toDateString() }}">{{ $comment->created_at->diffForHumans() }}</time>
                            <form class="comment-like-form" data-comment-id="{{ $comment->id }}" method="post"
                                action="{{ $comment->isLiked() ? route('like.comment.destroy', $comment->id) : route('like.comment.store', $comment->id) }}"
                                data-like-store-url="{{ route('like.comment.store', $comment->id) }}"
                                data-like-destroy-url="{{ route('like.comment.destroy', $comment->id) }}">
                                @csrf
                                @if ($comment->isLiked()) @method('DELETE') @endif
                                <button type="submit" class="post-comment-action" aria-label="Like comment">
                                    <i class="{{ $comment->isLiked() ? 'fa-solid text-danger' : 'fa-regular' }} fa-heart comment-heart" data-liked="{{ $comment->isLiked() ? 'true' : 'false' }}"></i>
                                    <span id="comment-like-count-{{ $comment->id }}">{{ $comment->likes->count() }}</span>
                                </button>
                            </form>
                            <button type="button" class="post-comment-action" data-bs-toggle="collapse" data-bs-target="#reply-{{ $comment->id }}">Reply</button>

                            @if (Auth::user()->id === $comment->user->id)
                                <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="post-comment-action post-comment-delete">Delete</button>
                                </form>
                            @endif
                        </div>

                        <div class="collapse post-reply-form" id="reply-{{ $comment->id }}">
                            <form action="{{ route('comment.store', $post->id)}}" method="post" class="post-comment-composer post-comment-composer--small">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <textarea name="comment_body{{ $post->id }}" rows="1" placeholder="Reply to {{ $comment->user->name }}"></textarea>
                                <button type="submit" aria-label="Send reply"><i class="fa-regular fa-paper-plane"></i></button>
                            </form>
                        </div>

                        @if ($comment->replies->count() > 0)
                            @php($visibleReplies = ($showAllComments ?? false) ? $comment->replies->sortByDesc('created_at') : $comment->replies->sortByDesc('created_at')->take(2))
                            <div class="post-replies">
                                @foreach ($visibleReplies as $reply)
                                    <div class="post-reply">
                                        <span class="post-reply-line"></span>
                                        <div class="post-comment-bubble">
                                            <a href="{{ route('profile.show', $reply->user->id) }}" class="post-comment-author">{{ $reply->user->name }}</a>
                                            <p>{{ $reply->body }}</p>
                                            <div class="post-comment-meta">
                                                <time datetime="{{ $reply->created_at->toDateString() }}">{{ $reply->created_at->diffForHumans() }}</time>
                                                <form class="comment-like-form" data-comment-id="{{ $reply->id }}" method="post"
                                                    action="{{ $reply->isLiked() ? route('like.comment.destroy', $reply->id) : route('like.comment.store', $reply->id) }}"
                                                    data-like-store-url="{{ route('like.comment.store', $reply->id) }}"
                                                    data-like-destroy-url="{{ route('like.comment.destroy', $reply->id) }}">
                                                    @csrf
                                                    @if ($reply->isLiked()) @method('DELETE') @endif
                                                    <button type="submit" class="post-comment-action" aria-label="Like reply">
                                                        <i class="{{ $reply->isLiked() ? 'fa-solid text-danger' : 'fa-regular' }} fa-heart comment-heart" data-liked="{{ $reply->isLiked() ? 'true' : 'false' }}"></i>
                                                        <span id="comment-like-count-{{ $reply->id }}">{{ $reply->likes->count() }}</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @if (!($showAllComments ?? false) && $comment->replies->count() > 2)
                                    <a href="{{ route('post.show', $post->id) }}" class="post-comments-more">View all {{ $comment->replies->count() }} replies</a>
                                @endif
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

        @if (!($showAllComments ?? false) && $rootComments->count() > 3)
            <a href="{{ route('post.show', $post->id) }}" class="post-comments-more">View all {{ $post->comments->count() }} comments</a>
        @endif
    @endif

    <form action="{{ route('comment.store', $post->id) }}" method="post" class="post-comment-composer">
        @csrf
        @if(Auth::user()->avatar)
            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
        @else
            <i class="fa-solid fa-circle-user"></i>
        @endif
        <textarea name="comment_body{{ $post->id }}" rows="1" placeholder="Add a comment...">{{ old("comment_body{$post->id}") }}</textarea>
        <button type="submit" aria-label="Post comment"><i class="fa-regular fa-paper-plane"></i></button>
    </form>

    @error('comment_body' . $post->id)
        <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror
</section>
