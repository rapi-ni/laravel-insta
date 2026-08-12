{{-- Show all liked post here --}}
    <div style="margin-top: 100px">
        @if ($liked_posts->isNotEmpty())
            <div class="row">
                @foreach ($liked_posts as $post)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ route('post.show', $post->id )}}">
                            <img src="{{ $post->image }}" alt="post_id" class="grid-img">
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <h3 class="text-muted text-center">No liked Posts Yet</h3>
            
        @endif
    </div>