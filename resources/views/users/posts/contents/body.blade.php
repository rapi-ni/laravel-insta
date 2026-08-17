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

    {{-- rate for food --}}
    @if($post->rating_taste || $post->rating_volume || $post->rating_sulit || $post->rating_vibes)
        <div class="mt-3 p-2 bg-white rounded-4 border border-2 shadow-sm mx-auto" 
            style="max-width: 450px; border-color: #ff007f !important; box-shadow: 3px 3px 6px rgba(255, 0, 127, 0.15) !important; font-family: 'Hiragino Maru Gothic ProN', 'Comic Sans MS', sans-serif;">
            
            <div class="text-center fw-bolder mb-2.5 text-uppercase tracking-wider" style="color: #ff007f; font-size: 15px; text-shadow: 0.5px 0.5px 0px #fff;">
                🎀 My Rate Scale 🎀
            </div>

            <div class="row row-cols-4 g-0">

                {{-- Taste --}}
                @if($post->rating_taste)
                    <!-- 💡 Vibesと全く同じ「col p-1」に統一！ -->
                    <div class="col p-1">
                        <div class="pt-1 px-2 rounded-3 h-100 d-flex flex-column align-items-center text-center justify-content-between" style="background-color: #fff5f9; border: 1px solid #ffbfda;">
                            <div class="fw-black mb-1" style="font-size: 12px; color: #ff007f;">Taste</div>
                            <div class="text-warning d-flex justify-content-center gap-0.5 mb-1.5 w-100 flex-nowrap">
                                @for ($i = 1; $i <= floor($post->rating_taste); $i++) <i class="fa-solid fa-star" style="font-size: 11px;"></i> @endfor
                                @if (fmod($post->rating_taste, 1) != 0) <i class="fa-solid fa-star-half-stroke" style="font-size: 11px;"></i> @endif
                                @for ($i = 1; $i <= (5 - ceil($post->rating_taste)); $i++) <i class="fa-regular fa-star opacity-25 text-secondary" style="font-size: 11px;"></i> @endfor
                            </div>
                            <span class="fw-black py-1 my-2 rounded-pill w-100 text-center d-block" style="background-color: #ff007f; color: #fff; font-size: 11px; line-height: 1; box-shadow: 0px 1px 2px rgba(255, 0, 127, 0.2); text-shadow: none;">{{ number_format($post->rating_taste, 1) }}</span>
                        </div>
                    </div>
                @endif

                {{-- Volume --}}
                @if($post->rating_volume)
                    <div class="col p-1">
                        <div class="pt-1 px-2 rounded-3 h-100 d-flex flex-column align-items-center text-center justify-content-between" style="background-color: #fff5f9; border: 1px solid #ffbfda;">
                            <div class="fw-black mb-1" style="font-size: 12px; color: #ff007f;">Volume</div>
                            <div class="text-warning d-flex justify-content-center gap-0.5 mb-1.5 w-100 flex-nowrap">
                                @for ($i = 1; $i <= floor($post->rating_volume); $i++) <i class="fa-solid fa-star" style="font-size: 11px;"></i> @endfor
                                @if (fmod($post->rating_volume, 1) != 0) <i class="fa-solid fa-star-half-stroke" style="font-size: 11px;"></i> @endif
                                @for ($i = 1; $i <= (5 - ceil($post->rating_volume)); $i++) <i class="fa-regular fa-star opacity-25 text-secondary" style="font-size: 11px;"></i> @endfor
                            </div>
                            <span class="fw-black py-1 my-2 rounded-pill w-100 text-center d-block" style="background-color: #ff007f; color: #fff; font-size: 11px; line-height: 1; box-shadow: 0px 1px 2px rgba(255, 0, 127, 0.2); text-shadow: none;">{{ number_format($post->rating_volume, 1) }}</span>
                        </div>
                    </div>
                @endif

                {{-- Value --}}
                @if($post->rating_sulit)
                    <div class="col p-1">
                        <div class="pt-1 px-2 rounded-3 h-100 d-flex flex-column align-items-center text-center justify-content-between" style="background-color: #fff5f9; border: 1px solid #ffbfda;">
                            <div class="fw-black mb-1" style="font-size: 12px; color: #ff007f;">Value</div>
                            <div class="text-warning d-flex justify-content-center gap-0.5 mb-1.5 w-100 flex-nowrap">
                                @for ($i = 1; $i <= floor($post->rating_sulit); $i++) <i class="fa-solid fa-star" style="font-size: 11px;"></i> @endfor
                                @if (fmod($post->rating_sulit, 1) != 0) <i class="fa-solid fa-star-half-stroke" style="font-size: 11px;"></i> @endif
                                @for ($i = 1; $i <= (5 - ceil($post->rating_sulit)); $i++) <i class="fa-regular fa-star opacity-25 text-secondary" style="font-size: 11px;"></i> @endfor
                            </div>
                            <span class="fw-black py-1 my-2 rounded-pill w-100 text-center d-block" style="background-color: #ff007f; color: #fff; font-size: 11px; line-height: 1; box-shadow: 0px 1px 2px rgba(255, 0, 127, 0.2); text-shadow: none;">{{ number_format($post->rating_sulit, 1) }}</span>
                        </div>
                    </div>
                @endif

                {{-- Vibes --}}
                @if($post->rating_vibes)
                    <div class="col p-1">
                        <div class="pt-1 px-2 rounded-3 h-100 d-flex flex-column align-items-center text-center justify-content-between" style="background-color: #fff5f9; border: 1px solid #ffbfda;">
                            <div class="fw-black mb-1" style="font-size: 12px; color: #ff007f;">Vibes</div>
                            <div class="text-warning d-flex justify-content-center gap-0.5 mb-1.5 w-100 flex-nowrap">
                                @for ($i = 1; $i <= floor($post->rating_vibes); $i++) <i class="fa-solid fa-star" style="font-size: 11px;"></i> @endfor
                                @if (fmod($post->rating_vibes, 1) != 0) <i class="fa-solid fa-star-half-stroke" style="font-size: 11px;"></i> @endif
                                @for ($i = 1; $i <= (5 - ceil($post->rating_vibes)); $i++) <i class="fa-regular fa-star opacity-25 text-secondary" style="font-size: 11px;"></i> @endfor
                            </div>
                            <span class="fw-black py-1 my-2 rounded-pill w-100 text-center d-block" style="background-color: #ff007f; color: #fff; font-size: 11px; line-height: 1; box-shadow: 0px 1px 2px rgba(255, 0, 127, 0.2); text-shadow: none;">{{ number_format($post->rating_vibes, 1) }}</span>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    @endif

    {{-- include comments here --}}
    @include('users.posts.contents.comments')
</div>
