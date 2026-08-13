<div class="row">
    <div class="col-4">
        @if ($user->avatar)
            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="img-thumbnail rounded-circle d-block mx-auto avatar-lg">
        @else
            <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
        @endif
    </div>
    <div class="col-8">
        <div class="row mb-3">
            <div class="col-auto">
                <h2 class="display-6 mb-0">
                    {{ $user->name }}
                </h2>
            </div>
            <div class="col-auto p-2 d-flex gap-2">
                @if (Auth::user()->id === $user->id)
                    <a href="{{ route('profile.edit')}}" class="btn btn-outline-secondary btn-sm fw-bold">Edit Profile</a>
                @else
                    @if ($user->isFollowed())
                        <form action="{{ route('follow.destroy', $user->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-secondary btn-sm fw-bold">Following</button>
                        </form>
                         {{-- message --}}
                        <form action="{{ route('messages.start', $user) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm fw-bold">
                            <i class="fa-regular fa-paper-plane me-1"></i>Message
                        </button>
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
        <div class="row mb-3">
            <div class="col-auto">
                <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark">
                    <strong>{{ $user->posts->count() }}</strong> {{ $user->posts->count() == 1 ? 'post' : 'posts'}}
                </a>
            </div>
            <div class="col-auto">
                <a href="#followers-modal" class="text-decoration-none text-dark" data-bs-toggle="modal">
                    <strong>{{ $user->followers->count() }}</strong> {{ $user->followers->count() == 1 ? 'follower' : 'followers'}}
                </a>
            </div>
            <div class="col-auto">
                <a href="#following-modal" class="text-decoration-none text-dark" data-bs-toggle="modal">
                    <strong>{{ $user->following->count() }}</strong> {{ $user->followers->count() == 1 ? 'following' : 'followings'}}
                </a>
            </div>
        </div>

        <p class="fs-bold">{{ $user->introduction}}</p>
    </div>
</div>

@include('users.profile.modals.followers')
@include('users.profile.modals.following')
