@extends('layouts.app')
 
@section('title', 'Admin: Posts')
 
@section('content')
    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="small table-primary text-secondary">
            <tr>
                <th></th>
                <th></th>
                <th>CATEGORY</th>
                <th>OWNER</th>
                <th>CREATED AT</th>
                <th>STATUS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>
                    <img src="{{ $post->image }}" alt="{{ $post->user->name }}" class="d-block mx-auto avatar-lg">
                </td>
                <td>
                    @forelse ($post->categorypost as $category)
                        <div class="badge bg-secondary bg-opacity-50">
                        {{ $category->category->name}}</div>
                    @empty
                        <span class="badge bg-dark text-light small">Uncategorized</span>
                    @endforelse
                </td>
                <td>
                    <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
                </td>
                <td>{{ $post->created_at }}</td>
                <td>
                    @if ($post->trashed())
                        {{-- trashed() - returns TRUE if the user was soft deleted --}}
                        <i class="fa-solid fa-circle-minus"></i>&nbsp; Hidden
                    @else
                        <i class="fa-solid fa-circle text-primary"></i>&nbsp; Visible
                    @endif
                </td>
                <td>
                    @if (Auth::user()->id !== $post->id)
                    <div class="dropdown">
                        <button class="btn btn-sm" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        
                        <div class="dropdown-menu">
                            @if ($post->trashed())
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#unhide-post-{{$post->id}}">
                                    <i class="fa-solid fa-eye"></i> Unhide Post {{ $post->id }}
                                </button>
                                
                            @else
                                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post-{{$post->id}}">
                                    <i class="fa-solid fa-eye-slash"></i> Hide Post {{ $post->id }}
                                </button>
                            @endif
                        </div>
                    </div>
                    {{-- include modal --}}
                    @include('admin.posts.modals.status')
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $all_posts->links() }}
        {{-- links() will render the pages in the result set --}}
    </div>
@endsection
 