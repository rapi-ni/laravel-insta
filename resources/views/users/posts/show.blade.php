@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
    <a href="{{ route('index') }}#post-{{ $post->id }}" class="post-back-link" title="Back to Home">
        <i class="fa-solid fa-chevron-left"></i>
        Back to Home
    </a>

    <article class="post-detail">
            <div class="post-detail-media post-media">
            <div id="carouselPost-{{ $post->id }}" class="carousel slide w-100" data-bs-ride="false">
                <div class="carousel-inner">
                    
                    <div class="carousel-item active">
                        <div class="ratio ratio-1x1">
                            <img src="{{ $post->image }}" alt="Post by {{ $post->user->name }}" class="w-100 h-100 d-block object-fit-cover">
                        </div>
                    </div>

                    @foreach($post->images as $post_image)
                        <div class="carousel-item">
                            <div class="ratio ratio-1x1">
                                <img src="{{ $post_image->image }}" alt="Post by {{ $post->user->name }}" class="w-100 h-100 d-block object-fit-cover">
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($post->images->isNotEmpty())
                    <button class="carousel-control-prev post-carousel-control" type="button" data-bs-target="#carouselPost-{{ $post->id }}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next post-carousel-control" type="button" data-bs-target="#carouselPost-{{ $post->id }}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                @endif
            </div>
        </div>


        <div class="card post-detail-panel">
            @include('users.posts.contents.title')

            <div class="card-body post-detail-content">
                <div class="post-actions">
                    <form class="like-form" data-post-id="{{ $post->id }}" method="post"
                        data-like-store-url="{{ route('like.store', $post->id) }}"
                        data-like-destroy-url="{{ route('like.destroy', $post->id) }}">
                        @csrf
                        <button type="submit" class="post-like-button" aria-label="Like this post">
                            @if ($post->isLiked())
                                <i class="fa-solid fa-heart text-danger" data-liked="true"></i>
                            @else
                                <i class="fa-regular fa-heart" data-liked="false"></i>
                            @endif
                            <span id="like-count-{{ $post->id }}">{{ $post->likes->count() }}</span>
                        </button>
                    </form>

                    <div class="post-categories" aria-label="Categories">
                        @forelse ($post->categorypost as $category)
                            <span class="post-category-chip">
                                <i class="fa-solid fa-utensils"></i>
                                {{ ucfirst($category->category->name) }}
                            </span>
                        @empty
                            <span class="post-category-chip post-category-chip--muted">Uncategorized</span>
                        @endforelse
                    </div>
                </div>

                <div class="post-caption">
                    <a href="{{ route('profile.show', $post->user->id) }}" class="post-caption-author">{{ $post->user->name }}</a>
                    <p>{{ $post->description }}</p>
                </div>

                @include('users.posts.contents.ratings')

                <time class="post-date" datetime="{{ $post->created_at->toDateString() }}">
                    {{ $post->created_at->format('M d, Y') }}
                </time>

                @include('users.posts.contents.comments', ['showAllComments' => true])
            </div>
        </div>
    </article>

    @if (Auth::user()->id === $post->user->id)
        @include('users.posts.contents.modals.delete')
    @endif
@endsection
