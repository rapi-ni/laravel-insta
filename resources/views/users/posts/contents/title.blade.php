<div class="card-header post-header">
    <div class="post-author">
        <a href="{{ route('profile.show', $post->user->id) }}" class="post-author-avatar">
            @if ($post->user->avatar)
                <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" class="rounded-circle avatar-sm">
            @else
                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
            @endif
        </a>
        <div class="post-author-copy">
            <a href="{{ route('profile.show', $post->user->id) }}">{{ $post->user->name }}</a>
            @if($post->location_id && $post->location)
                <span><i class="fa-solid fa-location-dot"></i> {{ $post->location->name }}</span>
            @endif
        </div>
    </div>

    <div class="dropdown">
        <button class="post-menu-button" data-bs-toggle="dropdown" aria-label="Post options">
            <i class="fa-solid fa-ellipsis"></i>
        </button>
        @if (Auth::user()->id === $post->user->id)
            <div class="dropdown-menu dropdown-menu-end">
                <a href="{{ route('post.edit', $post->id) }}" class="dropdown-item"><i class="fa-regular fa-pen-to-square"></i> Edit</a>
                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{ $post->id }}"><i class="fa-regular fa-trash-can"></i> Delete</button>
            </div>
            @include('users.posts.contents.modals.delete')
        @else
            <div class="dropdown-menu dropdown-menu-end">
                <form action="{{ route('follow.destroy', $post->user->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item text-danger">Unfollow</button>
                </form>
            </div>
        @endif
    </div>
</div>
