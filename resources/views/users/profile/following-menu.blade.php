<div class="dropdown">
    <button type="button" class="following-status-button dropdown-toggle"
        data-bs-toggle="dropdown" aria-expanded="false"
        aria-label="Following options for {{ $listedUser->name }}">
        <i class="fa-solid fa-check me-1" aria-hidden="true"></i>
        Following
    </button>

    <div class="dropdown-menu dropdown-menu-end follow-action-menu">
        <form action="{{ route('follow.destroy', $listedUser->id) }}" method="post"
            onsubmit="return confirm('Are you sure you want to unfollow this user?')">
            @csrf
            @method('DELETE')

            <button type="submit" class="dropdown-item text-danger">
                <i class="fa-solid fa-user-minus me-2" aria-hidden="true"></i>
                Unfollow
            </button>
        </form>
    </div>
</div>
