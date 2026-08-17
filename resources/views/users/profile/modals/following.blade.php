<div class="modal fade follow-modal"
     id="following-modal"
     tabindex="-1"
     aria-labelledby="following-modal-label"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="following-modal-label">
                    Following
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>
            </div>

            <div class="modal-body">
                @forelse ($user->following as $follow)
                    @php
                        $listedUser = $follow->following;
                        $canMessage = $listedUser->id !== Auth::id() && $listedUser->isFollowed();
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
                            <div class="col-auto d-flex align-items-center gap-2">
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

                                @if ($canMessage)
                                    @include('users.profile.following-menu', ['listedUser' => $listedUser])
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
                        Not following anyone yet.
                    </p>
                @endforelse
            </div>

        </div>
    </div>
</div>
