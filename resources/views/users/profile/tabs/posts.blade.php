{{-- Show all post here --}}
    <div style="margin-top: 60px">
        @if ($user->posts->isNotEmpty())
            <div class="row  row-cols-1 row-cols-md-3 g-4">
                @foreach ($user->posts as $post)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden post-card bg-white" style="border: 2px solid #fff !important;">
                            <div class="ratio ratio-1x1 w-100" style="overflow: hidden;">
                                <a href="{{ route('post.show', $post->id )}}">
                                    <img src="{{ $post->image }}" alt="post_id" class="w-100 h-100 d-block" style="object-fit: cover;">
                                </a>
                            </div>
                        
                            <div class="card-body pt-3 pb-2 bg-white">
                                <div class="d-flex justify-content-between align-items-center flex-nowrap small">
                                    
                                    {{-- heart button + no. of links --}}
                                    <div class="row align-items-center">
                                        <div class="col-auto pe-1">
                                        
                                            <form
                                                class="like-form"
                                                data-post-id="{{ $post->id }}"
                                                method="post"
                                                data-like-store-url="{{ route('like.store', $post->id) }}"
                                                data-like-destroy-url="{{ route('like.destroy', $post->id) }}">

                                                @csrf

                                                <button type="submit" class="btn btn-sm shadow-none p-0">
                                                    @if ($post->isLiked())
                                                    <i class="fa-solid fa-heart text-danger" data-liked="true" style="font-size: 20px;"></i> 
                                                    @else
                                                    <i class="fa-regular fa-heart text-danger" data-liked="false" style="font-size: 20px;"></i>
                                                    @endif
                                                </button>
                                            </form>
                                        </div>                
                        
                                        <div class="col-auto px-0">
                                            <span id="like-count-{{ $post->id }}" style="color: #ff007f; font-size: 11px;">
                                                {{ $post->likes->count() }}
                                            </span>
                                        </div>
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
            <div class="text-center py-5 bg-light rounded-4 border border-2" style="border-style: dashed !important; border-color: #ffbfda !important;">
                <i class="fa-solid fa-folder-open fa-3x mb-3 opacity-50" style="color: #ff007f;"></i>
                <p class="fw-bold mb-0" style="color: #ff007f; font-size: 14px;">No Posts Yet</p>
            </div>
        @endif
    </div>