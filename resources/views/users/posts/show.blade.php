@extends('layouts.app')
 
@section('title', 'Show Post')
 
@section('content')
    <style>
        .col-4{
            overflow: scroll;
        }

        .card-body{
            position: absolute;
            top: 65px;
        }
    </style>
    <div class="row border shadow">
        <div class="col p-0 border-end d-flex align-items-center justify-content-center" style="background-color: #fff;">
            @if($post->images->isNotEmpty())
            <div id="carouselPost-{{ $post->id }}" class="carousel slide w-100 position-relative" data-bs-ride="false">
                
                <div class="carousel-inner">
                    @foreach($post->images as $index => $post_image)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="ratio ratio-1x1">
                                <img src="{{ $post_image->image }}" alt="post image" class="w-100 h-100 d-block" style="object-fit: cover;">
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- button for slide to change display of photos  --}}
                @if($post->images->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselPost-{{ $post->id }}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselPost-{{ $post->id }}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                @endif
            </div>

            {{-- if post has only one image... --}}
            @else
                <div class="ratio ratio-1x1">
                    <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100 h-100" style="object-fit: cover;">
                </div>
            @endif
        </div>


        <div class="col-4 px-0 bg-white">
            <div class="card border-0">
                <div class="card-header bg-white py-3">
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
                                {{-- If not the owner , show follow /unfollow button --}}
                                @if ($post->user->isFollowed())
                                    <form action="{{ route('follow.destroy', $post->user->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border-0 bg-transparent p-0 text-secondary">
                                            Following
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('follow.store', $post->user->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="border-0 bg-transparent p-0 text-primary">
                                            Follow
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body w-100">
                    {{-- show tha location of this post --}}
                    @if($post->location_id && $post->location)
                        <div class="mb-2">
                            <span class="text-secondary small fw-bold">
                                <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $post->location->name }}
                            </span>
                        </div>
                    @endif

                    {{-- heart button + no. of links --}}
                    <div class="row align-items-center mb-2">
                        <div class="col-auto">
                        
                            <form
                                class="like-form"
                                data-post-id="{{ $post->id }}"
                                method="post"
                                data-like-store-url="{{ route('like.store', $post->id) }}"
                                data-like-destroy-url="{{ route('like.destroy', $post->id) }}">

                                @csrf

                                <button type="submit" class="btn btn-sm shadow-none p-0">
                                    @if ($post->isLiked())
                                    <i class="fa-solid fa-heart text-danger" data-liked="true"></i> 
                                    @else
                                     <i class="fa-regular fa-heart" data-liked="false"></i>
                                    @endif
                                </button>
                            </form>
                        </div>                
        
                        <div class="col-auto px-0">
                            <span id="like-count-{{ $post->id }}">
                                {{ $post->likes->count() }}
                            </span>
                        </div>

                        <div class="col text-end">
                            @foreach ($post->categoryPost as $category_post)
                                <div class="badge bg-secondary bg-opacity-50">
                                    {{ $category_post->category->name}}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- owner + description --}}
                    <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">
                        {{ $post->user->name}}
                    </a>
                    &nbsp;
                    <p class="d-inline fs-light">{{ $post->description }}</p>

                    {{-- rate for food --}}
                    @if($post->rating_taste || $post->rating_volume || $post->rating_sulit || $post->rating_vibes)
                        <div class="mt-3 p-2 bg-light rounded border small text-secondary" style="max-width: 280px;">
                            
                            {{-- Taste --}}
                            @if($post->rating_taste)
                                <div class="row g-0 align-items-center mb-1">
                                    <div class="col-4 text-dark fw-bold" style="font-size: 11px;">↳ Taste</div>
                                    <div class="col-8 text-warning d-flex align-items-center gap-1">
                                        @for ($i = 1; $i <= floor($post->rating_taste); $i++) <i class="fa-solid fa-star" style="font-size: 10px;"></i> @endfor
                                        @if (fmod($post->rating_taste, 1) != 0) <i class="fa-solid fa-star-half-stroke" style="font-size: 10px;"></i> @endif
                                        @for ($i = 1; $i <= (5 - ceil($post->rating_taste)); $i++) <i class="fa-regular fa-star opacity-25" style="font-size: 10px;"></i> @endfor
                                        <span class="text-muted ms-1" style="font-size: 10px;">({{ number_format($post->rating_taste, 1) }})</span>
                                    </div>
                                </div>
                            @endif

                            {{-- Volume --}}
                            @if($post->rating_volume)
                                <div class="row g-0 align-items-center mb-1">
                                    <div class="col-4 text-dark fw-bold" style="font-size: 11px;">↳ Volume</div>
                                    <div class="col-8 text-warning d-flex align-items-center gap-1">
                                        @for ($i = 1; $i <= floor($post->rating_volume); $i++) <i class="fa-solid fa-star" style="font-size: 10px;"></i> @endfor
                                        @if (fmod($post->rating_volume, 1) != 0) <i class="fa-solid fa-star-half-stroke" style="font-size: 10px;"></i> @endif
                                        @for ($i = 1; $i <= (5 - ceil($post->rating_volume)); $i++) <i class="fa-regular fa-star opacity-25" style="font-size: 10px;"></i> @endfor
                                        <span class="text-muted ms-1" style="font-size: 10px;">({{ number_format($post->rating_volume, 1) }})</span>
                                    </div>
                                </div>
                            @endif

                            {{-- Value --}}
                            @if($post->rating_sulit)
                                <div class="row g-0 align-items-center mb-1">
                                    <div class="col-4 text-dark fw-bold" style="font-size: 11px;">↳ Value</div>
                                    <div class="col-8 text-warning d-flex align-items-center gap-1">
                                        @for ($i = 1; $i <= floor($post->rating_sulit); $i++) <i class="fa-solid fa-star" style="font-size: 10px;"></i> @endfor
                                        @if (fmod($post->rating_sulit, 1) != 0) <i class="fa-solid fa-star-half-stroke" style="font-size: 10px;"></i> @endif
                                        @for ($i = 1; $i <= (5 - ceil($post->rating_sulit)); $i++) <i class="fa-regular fa-star opacity-25" style="font-size: 10px;"></i> @endfor
                                        <span class="text-muted ms-1" style="font-size: 10px;">({{ number_format($post->rating_sulit, 1) }})</span>
                                    </div>
                                </div>
                            @endif

                            {{-- Vibes --}}
                            @if($post->rating_vibes)
                                <div class="row g-0 align-items-center">
                                    <div class="col-4 text-dark fw-bold" style="font-size: 11px;">↳ Vibes</div>
                                    <div class="col-8 text-warning d-flex align-items-center gap-1">
                                        @for ($i = 1; $i <= floor($post->rating_vibes); $i++) <i class="fa-solid fa-star" style="font-size: 10px;"></i> @endfor
                                        @if (fmod($post->rating_vibes, 1) != 0) <i class="fa-solid fa-star-half-stroke" style="font-size: 10px;"></i> @endif
                                        @for ($i = 1; $i <= (5 - ceil($post->rating_vibes)); $i++) <i class="fa-regular fa-star opacity-25" style="font-size: 10px;"></i> @endfor
                                        <span class="text-muted ms-1" style="font-size: 10px;">({{ number_format($post->rating_vibes, 1) }})</span>
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endif

                    <p class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime( $post->created_at )) }}</p>

                    {{-- include comments here --}}
                    <div class="mt-4">
                        
                        <form action="{{ route('comment.store', $post->id) }}" method="post">
                            @csrf
                            <div class="input-group">
                                <textarea name="comment_body{{ $post->id }}" cols="30" rows="1" class="form-control form-control-sm" placeholder="Add a comment...">{{ old("comment_body{$post->id}") }}</textarea>
                                <button type="submit" class="btn btn-outline-secondary btn-sm" title="Post">
                                    <i class="fa-regular fa-paper-plane"></i>
                                </button>
                            </div>
                            {{-- Error --}}
                            @error('comment_body' . $post->id)
                                <div class="text-danger small">
                                    {{$message}}
                                </div>
                            @enderror
                            
                        </form>
                        {{-- Show all comments here --}}
                        @if ($post->comments->isNotEmpty())
                            <ul class="list-group mt-2">
                                @foreach ($post->comments as $comment)
                                    <li class="list-group-item border-0 p-0 mb-2">
                                        <a href="{{ route('profile.show', $comment->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
                                        &nbsp;<p class="d-inline fw-light">{{$comment->body}}</p>

                                        <form action="{{ route('comment.destroy', $comment->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <span class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($comment->created_at))}}</span>

                                            {{-- If the AUTH user is the owner, show delete btn --}}
                                            @if (Auth::user()->id === $comment->user->id)
                                                &middot;
                                                <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">Delete</button>
                                            @endif
                                        </form>
                                    </li>
                                    
                                @endforeach
                            </ul>
                            
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
 
