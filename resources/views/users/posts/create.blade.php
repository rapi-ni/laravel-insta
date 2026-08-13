@extends('layouts.app')
 
@section('title', 'Create Post')
 
@section('content')
    <form action="{{ route('post.store')}}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="category" class="form-label d-block fw-bold">
                Category <span class="text-muted fw-normal">(up to 3)</span>
            </label>

            @foreach ($all_categories as $category)
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}" class="form-input">
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
            <textarea name="description" id="description" rows="3" class="form-control" placeholder="What's on your mind">
                {{ old('description')}}
            </textarea>
            {{-- Error --}}
            @error('description')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="images" class="form-label fw-bold">Images</label>
            <input type="file" name="images[]" id="images" class="form-control" aria-describedby="image-info" multiple>
            <div class="form-text" id="images-info">
                The acceptable formats are jpeg, jpg, png, and gif only.<br>
                Max file size is 1048kb.<span class="text-muted fw-normal">(up to 5)</span>
            </div>
            {{-- Error --}}
            @error('images')
                <div class="text-danger small">{{ $message }}</div>
            @enderror

            @error('images.*')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary px-5">Post</button>

    </form>
    
@endsection
 