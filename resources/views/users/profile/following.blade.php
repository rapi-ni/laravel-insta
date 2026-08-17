@extends('layouts.app')
 
@section('title', 'Following')
 
@section('content')
    @include('users.profile.header')
    <div class="" style="margin-top: 100px">
        @if ($user->following->isNotEmpty())
            <div class="row justify-content-center">
                <div class="col-4">
                    <h3 class="text-muted text-center">Following</h3>
                    @foreach ($user->following as $following)
                        @php
                            $listedUser = $following->following;
                            $canMessage = $listedUser->id !== Auth::id() && $listedUser->isFollowed();
                        @endphp

                        <div class="row align-items-center mt-3">
                            <div class="col-auto">
                                <a href="{{ route('profile.show', $listedUser->id) }}">
                                    @if ($listedUser->avatar)
                                        <img src="{{ $listedUser->avatar }}" alt="{{ $listedUser->name }}" class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                    @endif
                                </a>
                            </div>
                            <div class="col ps-0 text-truncate">
                                <a href="{{ route('profile.show', $listedUser->id) }}" class="text-decoration-none text-dark fw-bold">{{ $listedUser->name }}</a>
                            </div>
                            <div class="col-auto d-flex align-items-center gap-2 text-end">
                                @if ($canMessage)
                                    <form action="{{ route('messages.start', $listedUser) }}" method="post">
                                        @csrf
                                        <button type="submit" class="follow-message-button"
                                            title="Message {{ $listedUser->name }}"
                                            aria-label="Message {{ $listedUser->name }}">
                                            <i class="fa-regular fa-paper-plane" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                @endif

                                @if ($listedUser->id !== Auth::id())
                                    @if ($canMessage)
                                        @include('users.profile.following-menu', ['listedUser' => $listedUser])
                                    @else
                                        <form action="{{ route('follow.store', $listedUser->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm fw-bold">Follow</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <h3 class="text-secondary text-center">No Followings</h3>
        @endif
    </div>
@endsection
