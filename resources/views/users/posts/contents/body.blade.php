{{-- clickble image --}}
<div class="container p-0">
    <a href="{{ route('post.show', $post->id) }}">
        <img src="{{ $post->image }}" alt="post_id {{ $post->id }}" class="w-100">
    </a>
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
