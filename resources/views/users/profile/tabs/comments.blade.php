{{-- Show all commented post here --}}
    <div style="margin-top: 100px">
        @if ($commented_posts->isNotEmpty())
            <div class="row">
                @foreach ($commented_posts as $post)
                    <div class="col-lg-4 col-md-6 mb-5">
                        <a href="{{ route('post.show', $post->id )}}">
                            <img src="{{ $post->image }}" alt="post_id" class="grid-img">
                        </a>

                        <div class="mt-2 p-2 bg-light rounded border small text-secondary">
                        @foreach ($post->comments->take(1) as $comment)
                            <div class="d-flex flex-column mb-2 last-border-none">
                                <div class="d-flex align-items-start">
                                    <i class="fa-regular fa-comment-dots me-2 mt-1"></i>
                                    <span class="text-dark fw-bold me-1">You:</span>
                                    <span class="text-dark">{{ $comment->body }}</span>
                                </div>
                                
                                <div class="text-muted text-end" style="font-size: 10px;">
                                    <i class="fa-regular fa-clock me-1"></i>{{ $comment->created_at->format('M j, Y') }}
                                </div>
                            </div>
                        @endforeach
                        
                        @if ($post->comments->count() > 1)
                        <div class="collapse" id="collapseComments-{{ $post->id }}">
                            
                            @foreach ($post->comments->skip(1) as $comment)
                            <div class="d-flex flex-column mb-2">
                                <div class="d-flex align-items-start">
                                    <i class="fa-regular fa-comment-dots me-2 mt-1"></i>
                                    <span class="text-dark fw-bold me-1">{{ $comment->user->name }}:</span>
                                    <span class="text-dark">{{ $comment->body }}</span>
                                </div>
                                <div class="text-muted text-end" style="font-size: 10px;">
                                    <i class="fa-regular fa-clock me-1"></i>{{ $comment->created_at->format('M j, Y') }}
                                </div>
                            </div>
                            @endforeach                           
                        </div>

                        <div class="text-end mt-1">
                                <button class="btn p-0 border-0 text-secondary fw-bold small text-decoration-none shadow-none" 
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseComments-{{ $post->id }}" aria-expanded="false" style="font-size: 11px;">
                                    <i class="fa-solid fa-ellipsis" title="see all"></i>
                                </button>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach 
            </div>
        @else
            <h3 class="text-muted text-center">No comments Posts Yet</h3>
            
        @endif
    </div>