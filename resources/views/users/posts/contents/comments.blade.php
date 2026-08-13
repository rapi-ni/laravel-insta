<div class="mt-3">
    {{-- Show all comments here --}}
    @if ($post->comments->isNotEmpty())
        <hr>
        <ul class="list-group">
            @foreach ($post->comments->whereNull('parent_id')->take(3) as $comment)
                <li class="list-group-item border-0 p-0 mb-2">
                    <a href="{{ route('profile.show', $comment->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}
                    </a>
                    &nbsp;
                    <p class="d-inline fw-light">
                        {{$comment->body}}
                    </p>

                    {{-- Comment Like --}}
                    <div class="d-inline-flex align-items-center ms-2">
                        <form
                            class="comment-like-form"
                            data-comment-id="{{ $comment->id }}"
                            method="post"
                            data-like-store-url="{{ route('like.comment.store', $comment->id) }}"
                            data-like-destroy-url="{{ route('like.comment.destroy', $comment->id) }}">

                            @csrf

                            <button type="submit" class="btn btn-sm shadow-none p-0">
                                @if ($comment->isLiked())
                                    <i class="fa-solid fa-heart text-danger comment-heart"
                                    data-liked="true"></i>
                                @else
                                    <i class="fa-regular fa-heart comment-heart"
                                    data-liked="false"></i>
                                @endif
                            </button>
                        </form>

                        <span class="ms-1" id="comment-like-count-{{ $comment->id }}">
                            {{ $comment->likes->count() }}
                        </span>
                    </div>
                    
                    {{-- Reply button --}}
                    <button
                        type="button"
                        class="border-0 bg-transparent text-primary p-0 small"
                        data-bs-toggle="collapse"
                        data-bs-target="#reply-{{ $comment->id }}">
                        Reply
                    </button>

                    {{-- Reply form --}}
                    <div class="collapse mt-2" id="reply-{{ $comment->id }}">

                        
                        <form action="{{ route('comment.store', $post->id)}}" method="post">
                            @csrf

                            <input 
                               type="hidden"
                               name="parent_id"
                               value="{{ $comment->id }}">

                            <div class="input-group">
                                <textarea 
                                    name="comment_body{{ $post->id }}"
                                    rows="1"
                                    class="form-control form-control-sm"
                                    placeholder="Reply to {{ $comment->user->name }}"></textarea>
                                    
                                    <button
                                    type="submit"
                                    class="btn btn-outline-secondary btn-sm">
                                    Reply
                                </button>
                            </div>
                        </form>
                    </div>

                    Replies
                    @if ($comment->replies->count() > 0)
                        <div class="ms-4 mt-2">

                            {{-- Latest reply --}}
                            @php
                               $latestReply = $comment->replies
                                   ->sortBydesc('created_at')
                                   ->first();
                            @endphp

                            <div class="border-start ps-3 mb-2">

                                <div class="small">
                                    <strong>{{ $latestReply->user->name }}</strong>
                                </div>

                                <div class="small">
                                    {{ $latestReply->body }}
                                </div>
                                
                                {{-- Reply Like --}}
                                <div class="d-inline-flex align-items-center mt-1">
                                    
                                    <form
                                        class="comment-like-form"
                                        data-comment-id="{{ $latestReply->id }}"
                                        method="post"
                                        data-like-store-url="{{ route('like.comment.store', $latestReply->id) }}"
                                        data-like-destroy-url="{{ route('like.comment.destroy', $latestReply->id) }}">

                                        @csrf

                                        <button type="submit" class="btn btn-sm shadow-none p-0">
                                            @if ($latestReply->isLiked())
                                            <i class="fa-solid fa-heart text-danger comment-heart"
                                            data-liked="true"></i>
                                            @else
                                                <i class="fa-regular fa-heart comment-heart"
                                                data-liked="false"></i>
                                            @endif
                                        </button>
                                            
                                    </form>

                                    <span class="ms-1" id="comment-like-count-{{ $latestReply->id }}">
                                        {{ $latestReply->likes->count() }}
                                    </span>

                                </div>

                                <div class="text-muted xsmall">
                                    {{ date('M d, Y', strtotime($latestReply->created_at)) }}
                                </div>
                                
                            </div>

                            {{-- View all replies --}}
                            @if ($comment->replies->count() > 1)

                                <button
                                    type="button"
                                    class="btn btn-link btn-sm p-0 text-decoration-none"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#all-replies-{{ $comment->id }}"
                                    aria-expanded="false"
                                    aria-controls="all-replies-{{ $comment->id }}">

                                    View all {{ $comment->replies->count() }} replies

                                </button>
                                
                                {{-- All replies except latest --}}
                                <div
                                    class="collapse mt-2"
                                    id="all-replies-{{ $comment->id }}">
                                
                                    <div
                                    class="border rounded p-2"
                                    style="max-height: 250px; overflow-y: auto;">
                                    
                                    @foreach ($comment->replies->sortByDesc('created_at')->skip(1) as $reply)

                                        <div class="border-start ps-3 mb-3">
                                            
                                            <div class="small">
                                                <strong>{{ $reply->user->name }}</strong>
                                            </div>
                                            
                                            <div class="small">
                                                {{ $reply->body }}
                                            </div>
                                            
                                            {{-- Reply Like --}}
                                            <div class="d-inline-flex align-items-center mt-1">
                                                
                                                <form
                                                    class="comment-like-form"
                                                    data-comment-id="{{ $reply->id }}"
                                                    method="post"
                                                    data-like-store-url="{{ route('like.comment.store', $reply->id) }}"
                                                    data-like-destroy-url="{{ route('like.comment.destroy', $reply->id) }}">

                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm shadow-none p-0">

                                                        @if ($reply->isLiked())
                                                            <i
                                                                class="fa-solid fa-heart text-danger comment-heart"
                                                                data-liked="true">
                                                            </i>
                                                        @else
                                                            <i
                                                            class="fa-regular fa-heart comment-heart"
                                                            data-liked="false"></i>
                                                        @endif

                                                    </button>

                                                </form>
                                                        
                                                <span
                                                    class="ms-1"
                                                    id="comment-like-count-{{ $reply->id }}">
                                                    {{ $reply->likes->count() }}
                                                </span>

                                            </div>

                                            <div class="text-muted xsmall">
                                                {{ date('M d, Y', strtotime($reply->created_at)) }}
                                            </div>
                                            
                                        </div>

                                    @endforeach
                                        
                                </div>

                            </div>
                           
                         @endif

                    </div>

                @endif
                                
                    {{-- Comment date + Delete --}}
                    <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <span class="text-uppercase text-muted xsmall">
                            {{ date('M d, Y', strtotime($comment->created_at))}}
                        </span>
                        
                        {{-- If the AUTH user is the owner, show delete btn --}}
                        @if (Auth::user()->id === $comment->user->id)
                        &middot;
                        <button 
                            type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">
                                Delete
                        </button>
                        @endif
                    </form>
                </li>
            @endforeach

            @if ($post->comments->count() > 3)
                <li class="list-group-item border-0 px-0 pt-0">
                    <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none small">View all {{ $post->comments->count() }} comments</a>
                </li>
                
            @endif
        </ul>
        
    @endif

    <form action="{{ route('comment.store', $post->id) }}" method="post">
        @csrf
        <div class="input-group">
            <textarea name="comment_body{{ $post->id }}"
                rows="1" 
                class="form-control form-control-sm" 
                placeholder="Add a comment...">{{ old("comment_body{$post->id}") }}</textarea>

            <button type="submit" class="btn btn-outline-secondary btn-sm" title="Post">
                <i class="fa-regular fa-paper-plane"></i>
            </button>
        </div>
        {{-- Error --}}
        @error('comment_body' . $post->id)
            <div class="text-danger small">
                {{$message}}
            </div>
        @enderror
    </form>
</div>