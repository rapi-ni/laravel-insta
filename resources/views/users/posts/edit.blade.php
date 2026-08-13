@extends('layouts.app')
 
@section('title', 'Edit Post')
 
@section('content')
    <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="category" class="form-label d-block fw-bold">
                Category <span class="text-muted fw-normal">(up to 3)</span>
            </label>

            @foreach ($all_categories as $category)
                <div class="form-check form-check-inline">
                    @if (in_array($category->id, $selected_categories))
                        <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}" class="form-input" checked>
                    @else
                        <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}" class="form-input">
                    @endif
                        <label for="{{ $category->name }}" class="form-check-label">{{ ucfirst($category->name) }}</label>
                </div>
            @endforeach
            {{-- Error --}}
            @error('category')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea name="description" id="description" rows="3" class="form-control" placeholder="What's on your mind">{{ old('description', $post->description)}}</textarea>
            {{-- Error --}}
            @error('description')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="images" class="form-label fw-bold">Images</label>
                @if($post->images->isNotEmpty())
                    <div class="d-flex flex-wrap gap-2 mb-2 p-2 bg-light rounded border">
                        @foreach($post->images as $post_image)
                            <img src="{{ $post_image->image }}" alt="posted image" class="img-thumbnail me-1" style="width: 150px; height: 150px; object-fit: cover;">
                        @endforeach
                    </div>
                
                    {{-- information --}}
                    <div class="alert alert-secondary py-2 px-3 small text-secondary border-0 bg-opacity-10 bg-secondary" style="font-size: 11px; margin: 0;">
                        <i class="fa-solid fa-circle-info me-1"></i> Multiple images cannot be changed after posting.
                    </div>

                @else
                <!-- preview -->
                <div class="mb-2">
                    <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="img-thumbnail" style="max-height: 300px; object-fit: contain;">
                </div>

                {{-- update for only one image --}}
                <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
                
                <div class="form-text" id="image-info">
                    The acceptable formats are jpeg, jpg, png, and gif only.<br>
                    Max file size is 1048kb.
                </div>
                
                {{-- Error --}}
                @error('image')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            @endif
        </div>


        <button type="submit" class="btn btn-warning px-5">Save</button>

    </form>
@endsection
 