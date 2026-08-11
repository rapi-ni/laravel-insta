@extends('layouts.app')
 
@section('title', 'Explore People')
 
@section('content')
    <div class="row justify-content-center">
        <div class="col-5">

            <p class="h5 text-muted mb-4">Search results for "<span class="fw-bold">{{ $search }}</span>"</p>
            {{-- $search is the $request->search --}}

            @forelse ($users as $user)
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="{{ route('profile.show', $user->id) }}">
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-md">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0 text-truncate">
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
                    </div>
                    <div class="col-auto">
                        @if ($user->id !== Auth::user()->id)
                            {{-- if the searched user ID is not the same as AUTH USER ID show follow/unfollow btn --}}
                            @if ($user->isFollowed())
                                <form action="{{ route('follow.destroy', $user->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn ntm-outline-secondary fw-bold btn btn-sm">Following</button>
                                </form>
                            @else
                            <form action="{{ route('follow.store', $user->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm fw-bold">Follow</button>
                            </form>
                        @endif
                        @endif
                    </div>
                </div>            
            @empty
                <p class="lead text-muted text-center">No users found.</p>
            @endforelse
        </div>
    </div>
@endsection
 