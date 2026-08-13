{{-- clickable image with multi-image slideshow --}}
<div class="container p-0">
    @if($post->images->isNotEmpty())
        <div id="carouselTimeline-{{ $post->id }}" class="carousel slide w-100" data-bs-ride="false">
            
            <div class="carousel-inner">
                @foreach($post->images as $index => $post_image)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <a href="{{ route('post.show', $post->id) }}">
                            <div class="ratio ratio-1x1">
                                <img src="{{ $post_image->image }}" alt="post image" class="w-100 h-100 d-block" style="object-fit: cover;">
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            @if($post->images->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselTimeline-{{ $post->id }}" data-bs-slide="prev" style="z-index: 5;">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselTimeline-{{ $post->id }}" data-bs-slide="next" style="z-index: 5;">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            @endif
        </div>

    {{-- if post has only one image... --}}
    @else
        <a href="{{ route('post.show', $post->id) }}">
            <div class="ratio ratio-1x1">
                <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100 h-100" style="object-fit: cover;">
            </div>
        </a>
    @endif
</div>

<div class="card-body">
    {{-- heart button + no. of links --}}
    <div class="row align-items-center">
        <div class="col-auto">

            <form class="like-form" action="{{ route('like.store', $post->id) }}" data-post-id="{{ $post->id }}"
                data-like-store-url="{{ route('like.store', $post->id) }}"
                data-like-destroy-url="{{ route('like.destroy', $post->id) }}" method="post">

                @csrf

                <button type="submit" class="btn btn-sm shadow-none p-0">
                    @if ($post->isLiked())
                        <i class="fa-solid fa-heart text-danger" data-liked="true"></i>
                    @else
                        <i class="fa-regular fa-heart" data-liked="false"></i>
                    @endif
                </button>
                <span id="like-count-{{ $post->id }}">
                    {{ $post->likes->count() }}
                </span>
            </form>


        </div>
        <div class="col text-end">
            @forelse ($post->categorypost as $category)
                <div class="badge bg-secondary bg-opacity-50">
                    {{ $category->category->name }}
                </div>
            @empty
                <span class="badge bg-dark text-light small">Uncategorized
                </span>
            @endforelse
        </div>
    </div>

    {{-- owner + description --}}
    <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">
        {{ $post->user->name }}
    </a>
    &nbsp;
    <p class="d-inline fs-light">{{ $post->description }}</p>
    <p class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($post->created_at)) }}</p>

    {{-- include comments here --}}
    @include('users.posts.contents.comments')
</div>
