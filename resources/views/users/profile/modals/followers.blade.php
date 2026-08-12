<div class="modal fade follow-modal"
     id="followers-modal"
     tabindex="-1"
     aria-labelledby="followers-modal-label"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="followers-modal-label">
                    Followers
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>
            </div>

            <div class="modal-body">
                @forelse ($user->followers as $follow)
                    @php
                        $listedUser = $follow->follower;
                    @endphp

                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $listedUser->id) }}">
                                @if ($listedUser->avatar)
                                    <img src="{{ $listedUser->avatar }}"
                                         alt="{{ $listedUser->name }}"
                                         class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>

                        <div class="col ps-0 text-truncate">
                            <a href="{{ route('profile.show', $listedUser->id) }}"
                               class="text-decoration-none text-dark fw-bold">
                                {{ $listedUser->name }}
                            </a>
                        </div>

                        @if ($listedUser->id !== Auth::id())
                            <div class="col-auto">
                                @if ($listedUser->isFollowed())
                                    <form action="{{ route('follow.destroy', $listedUser->id) }}"
                                          method="post">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="border-0 bg-transparent p-0 text-secondary">
                                            Following
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('follow.store', $listedUser->id) }}"
                                          method="post">
                                        @csrf

                                        <button type="submit"
                                                class="border-0 bg-transparent p-0 text-primary">
                                            Follow
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-secondary text-center mb-0">
                        No followers yet.
                    </p>
                @endforelse
            </div>

        </div>
    </div>
</div>
