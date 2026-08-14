{{-- Show all liked post here --}}
<div style="margin-top: 60px"> 
    @if ($liked_posts->isNotEmpty())
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($liked_posts as $post)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden post-card bg-white" style="border: 2px solid #fff !important;">
                        
                        <div class="ratio ratio-1x1 w-100" style="overflow: hidden;">
                            <a href="{{ route('post.show', $post->id )}}">
                                <img src="{{ $post->image }}" alt="post_id" class="w-100 h-100 d-block" style="object-fit: cover;">
                            </a>
                        </div>
                        
                        <div class="card-body pt-3 pb-2 bg-white">
                            <div class="d-flex justify-content-between align-items-center flex-nowrap small">
                                
                                <div class="px-2.5 py-1 d-flex align-items-center gap-1 text-truncate">
                                    <i class="fa-regular fa-user text-secondary" style="font-size: 13px; color: #ff007f !important;"></i>
                                    <span class="fw-black text-truncate" style="color: #ff007f; font-size: 13px;">{{ $post->user->name }}</span>
                                </div>

                                <div class="text-muted fw-bold d-flex align-items-center gap-1" style="font-size: 10px; color: #ff007f !important; opacity: 0.75;">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $post->created_at->format('M j, Y') }}
                                </div>
                                
                            </div>
                        </div>   
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- 💡【お揃い】いいねした投稿がない時のエリアも、可愛いピンクの点線デザインにカスタム！ -->
        <div class="text-center py-5 bg-light rounded-4 border border-2" style="border-style: dashed !important; border-color: #ffbfda !important;">
            <i class="fa-solid fa-heart fa-3x mb-3 opacity-30" style="color: #ff007f;"></i>
            <p class="fw-bold mb-0" style="color: #ff007f; font-size: 14px;">No Liked Posts Yet</p>
        </div>
    @endif
</div>
