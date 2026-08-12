{{-- Show all post here --}}
    <div style="margin-top: 100px">
        @if ($user->posts->isNotEmpty())
            <div class="row">
                @foreach ($user->posts as $post)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ route('post.show', $post->id )}}">
                            <img src="{{ $post->image }}" alt="post_id" class="grid-img">
                        </a>

                        <div class="d-flex justify-content-between align-items-center mt-2 px-1 small text-secondary">
                            <div>
                                <i class="fa-solid fa-heart text-danger me-1"></i>
                                <span class="fw-bold text-dark">{{ $post->likes->count() }}</span>
                            </div>

                            <div class="text-muted" style="font-size: 11px;">
                                <i class="fa-regular fa-clock me-1"></i>
                                {{ $post->created_at->format('M j, Y') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <h3 class="text-muted text-center">No Posts Yet</h3>
            
        @endif
    </div>