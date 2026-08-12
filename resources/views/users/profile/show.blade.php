@extends('layouts.app')
 
@section('title', $user->name)
 
@section('content')
    @include('users.profile.header')

    {{-- Tab button --}}
    <div style="margin-top: 50px">
        <ul class="nav nav-tabs nav-justified justify-content-center mb-4 border-0 profile-nav-tabs w-75 mx-auto" id="profileTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts-content" type="button" role="tab">
                    <i class="fa-regular fa-newspaper fs-5 me-1"></i> POSTS
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="liked-tab" data-bs-toggle="tab" data-bs-target="#liked-content" type="button" role="tab">
                    <i class="fa-regular fa-heart fs-5 me-1"></i> LIKED
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments-content" type="button" role="tab">
                    <i class="fa-regular fa-comment fs-5 me-1"></i> COMMENTS
                </button>
            </li>
        </ul>
    </div>

    {{-- Tab content --}}
    <div class="tab-content" id="profileTabContent">
    
    <!-- POSTS -->
    <div class="tab-pane fade show active" id="posts-content" role="tabpanel">
        @include('users.profile.tabs.posts')
    </div>

    <!-- LIKED-->
    <div class="tab-pane fade" id="liked-content" role="tabpanel">
        @include('users.profile.tabs.liked')
    </div>

    <!-- COMMENTS -->
    <div class="tab-pane fade" id="comments-content" role="tabpanel">
        @include('users.profile.tabs.comments')
    </div>

</div>

@endsection
 