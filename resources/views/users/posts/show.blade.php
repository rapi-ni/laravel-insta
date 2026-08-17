@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
    <a href="javascript:history.back()" class="post-back-link" title="Back">
        <i class="fa-solid fa-chevron-left"></i>
        Back
    </a>

    <article class="post-detail">
        <div class="post-detail-media post-media">
    {{-- Post --}}
    <div class="row border shadow m-0 bg-white rounded-4 overflow-hidden" style="border-color: #ff007f !important;">
        <div class="col p-0 border-end d-flex align-items-center justify-content-center" style="background-color: #fff;">
            @if($post->images->isNotEmpty())
                <div id="carouselPost-{{ $post->id }}" class="carousel slide w-100" data-bs-ride="false">
                    <div class="carousel-inner">
                        @foreach($post->images as $index => $post_image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="ratio ratio-1x1">
                                    <img src="{{ $post_image->image }}" alt="Post by {{ $post->user->name }}" class="w-100 h-100 d-block">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($post->images->count() > 1)
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
            @else
                <div class="ratio ratio-1x1">
                    <img src="{{ $post->image }}" alt="Post by {{ $post->user->name }}" class="w-100 h-100">
                </div>
            @endif
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

        <div class="col-4 px-0 bg-white">
            <div class="card border-0">
                <div class="card-header bg-white py-3 border-bottom" style="border-color: #ff007f !important;">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $post->user->id) }}">
                                @if ($post->user->avatar)
                                    <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name}}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0">
                            <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark">
                                {{ $post->user->name }}
                            </a>
                        </div>
                        <div class="col-auto">
                            @if (Auth::user()->id === $post->user->id)
                                {{-- If youare the owner of the post, show edit and deltete --}}
                                <div class="dropdown">
                                    <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('post.edit', $post->id) }}" class="dropdown-item">
                                            <i class="fa-regular fa-pen-to-square"></i>Edit
                                        </a>
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{ $post->id }}">
                                            <i class="fa-regular fa-trash-can"></i>Delete
                                        </button>
                                    </div>
                                    {{-- include modal here --}}
                                    @include('users.posts.contents.modals.delete')
                                </div>
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
@endsection
