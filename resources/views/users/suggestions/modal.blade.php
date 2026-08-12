<div class="modal fade suggestions-modal" id="suggestions-modal" tabindex="-1" aria-labelledby="suggestions-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="suggestions-modal-label">
                    Suggestions For You
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                @forelse ($suggestedUsers as $user)
                    <div class="row align-items-center suggestion-user">
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $user->id) }}">
                                @if ($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                        class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>

                        <div class="col ps-0 text-truncate">
                            <a href="{{ route('profile.show', $user->id) }}"
                                class="suggestion-user-name">
                                {{ $user->name }}
                            </a>
                        </div>

                        <div class="col-auto">
                            <form action="{{ route('follow.store', $user->id) }}" method="post">
                                @csrf

                                <button type="submit" class="btn btn-sm follow-btn">
                                    Follow
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-secondary text-center py-4 mb-0">
                        No suggestions available.
                    </p>
                @endforelse
            </div>

        </div>
    </div>
</div>
