{{-- Show all commented post here --}}
<div style="margin-top: 60px">
    @if ($commented_posts->isNotEmpty())
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($commented_posts as $post)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden post-card bg-white" style="border: 2px solid #fff !important;">
                        
                        <div class="ratio ratio-1x1 w-100" style="overflow: hidden;">
                            <a href="{{ route('post.show', $post->id )}}">
                                <img src="{{ $post->image }}" alt="post_id" class="w-100 h-100 d-block" style="object-fit: cover;">
                            </a>
                        </div>
                        
                        <div class="card-body p-3 bg-white d-flex flex-column justify-content-between" style="overflow: hidden !important;">
                            
                            @foreach ($post->comments->take(1) as $comment)
                                <div class="d-flex flex-column mb-2 p-2 rounded-3 border-0" style="background-color: #fff5f9; border-left: 3px solid #ff007f !important; overflow: hidden !important;">
                                    <div class="d-flex align-items-start mb-1" style="font-size: 11px; word-break: break-all !important;">
                                        <i class="fa-regular fa-comment-dots mt-1 me-1.5" style="color: #ff007f;"></i>
                                        <span class="fw-black me-1" style="color: #ff007f; white-space: nowrap;">You:</span>
                                        <span class="text-dark fw-bold" style="line-height: 1.2;">{{ $comment->body }}</span>
                                    </div>
                                    <div class="text-muted text-end m-0" style="font-size: 9px; color: #ff007f !important; opacity: 0.75;">
                                        <i class="fa-regular fa-clock me-0.5"></i>{{ $comment->created_at->format('M j, Y') }}
                                    </div>
                                </div>
                            @endforeach
                            
                            @if ($post->comments->count() > 1)
                                <div class="collapse" id="collapseComments-{{ $post->id }}" style="overflow: hidden !important;">
                                    @foreach ($post->comments->skip(1) as $comment)
                                    <div class="d-flex flex-column mb-2 p-2 rounded-3" style="border: 1px solid #ffdeed; overflow: hidden !important;">
                                        <div class="d-flex align-items-start" style="font-size: 11px; word-break: break-all !important;">
                                            <i class="fa-regular fa-comment-dots mt-1 me-1.5" style="color: #ff007f; opacity: 0.75;"></i>
                                            <span class="fw-bold me-1 text-truncate" style="max-width: 50px; white-space: nowrap; color: #ff3399;">{{ $comment->user->name }}:</span>
                                            <span class="text-dark" style="line-height: 1.2;">{{ $comment->body }}</span>
                                        </div>
                                        <div class="text-muted text-end mt-1" style="font-size: 9px; color: #ff007f !important; opacity: 0.75;">
                                            <i class="fa-regular fa-clock me-0.5"></i>{{ $comment->created_at->format('M j, Y') }}
                                        </div>
                                    </div>

                                    @endforeach                           
                                </div>

                                <div class="text-end mt-1">
                                    <button class="btn p-0 border-0 fw-bold small text-decoration-none shadow-none" 
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseComments-{{ $post->id }}" aria-expanded="false" 
                                            style="font-size: 12px; color: #ff007f;" title="See all comments">
                                        <i class="fa-solid fa-ellipsis" style="filter: drop-shadow(0.5px 0.5px 0px rgba(255, 0, 127, 0.2));"></i>
                                    </button>
                                </div>
                            @endif

                        </div>   
                    </div>
                </div>
            @endforeach 
        </div>
    @else
        <div class="text-center py-5 bg-light rounded-4 border border-2" style="border-style: dashed !important; border-color: #ffbfda !important;">
            <i class="fa-solid fa-comment-dots fa-3x mb-3 opacity-30" style="color: #ff007f;"></i>
            <p class="fw-bold mb-0" style="color: #ff007f; font-size: 14px;">No Comments Yet</p>
        </div>
    @endif
</div>
