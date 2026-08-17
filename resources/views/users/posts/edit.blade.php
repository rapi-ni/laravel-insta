@extends('layouts.app')
 
@section('title', 'Edit Post')
 
@section('content')
    <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        {{-- Images --}}
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

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea name="description" id="description" rows="3" class="form-control" placeholder="What's on your mind">{{ old('description', $post->description)}}</textarea>
            {{-- Error --}}
            @error('description')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Category --}}
        <div class="mb-3">
            <label for="category" class="form-label d-block fw-bold">
                Category
            </label>

            @foreach ($all_categories as $category)
                <div class="form-check form-check-inline">
                    @if (in_array($category->id, $selected_categories))
                        <input type="radio" name="category_id" id="{{ $category->name }}" value="{{ $category->id }}" class="form-check-input category-checkbox" checked>
                    @else
                        <input type="radio" name="category_id" id="{{ $category->name }}" value="{{ $category->id }}" class="form-check-input category-checkbox">
                    @endif
                        <label for="{{ $category->name }}" class="form-check-label">{{ ucfirst($category->name) }}</label>
                </div>
            @endforeach
            {{-- Error --}}
            @error('category_id')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Edit location --}}
        <div class="mb-4 p-3 bg-light rounded border position-relative" style="max-width: 450px;">
            <label for="location-search" class="form-label fw-bold text-dark">
                <i class="fa-solid fa-location-dot text-danger me-1"></i> Add Location
            </label>

            {{-- search for location --}}
            <input type="text" name="location_name" id="location-search" class="form-control form-control-sm mb-3" placeholder="Search or type a new location... (e.g., UCMA, IT Park)" autocomplete="off" value="{{ old('location_name', $post->location ? $post->location->name : '') }}">

            <input type="hidden" name="location_id" id="hidden-location-id" value="{{ old('location_id', $post->location_id) }}">

            <div id="location-list" class="d-flex flex-column gap-2 d-none bg-white p-2 border rounded position-absolute w-100 shadow" style="max-height: 150px; overflow-y: auto; z-index: 1000;">
                @foreach ($all_locations as $location)
                    <div class="form-check location-item" data-id="{{ $location->id }}" data-name="{{ strtolower($location->name) }}" style="cursor: pointer;">
                        <input type="radio" 
                            name="location_radio" 
                            id="loc-{{ $location->id }}" 
                            value="{{ $location->id }}" 
                            class="form-check-input"
                            {{ old('location_id', $post->location_id) == $location->id ? 'checked' : '' }}>
                        <label for="loc-{{ $location->id }}" class="form-check-label small text-dark fw-bold location-name-label">{{ $location->name }}</label>
                    </div>
                @endforeach
            </div>
    
            @error('location_name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Rate --}}
        <div id="review-section" class="mb-4 p-3 bg-light rounded border" style="max-width: 450px;">
            <label class="form-label fw-bold text-dark mb-3">
                <i class="fa-solid fa-star text-secondary me-1"></i> Rate your Experience
            </label>
            
            {{-- Taste --}}
            <div class="row align-items-center mb-3">
                <div class="col-4 text-secondary small fw-bold">↳ Taste</div>
                <div class="col-8 d-flex align-items-center gap-2">
                    <input type="number" name="rating_taste" id="input_taste" class="form-control form-control-sm rating-input" 
                        min="0.5" max="5.0" step="0.5" value="{{ old('rating_taste', $post->rating_taste ?? '5.0') }}" style="width: 70px;">
                    <div class="star-display text-warning ms-2" id="stars_taste" style="font-size: 16px;"></div>
                </div>
            </div>

            {{-- Volume --}}
            <div class="row align-items-center mb-3">
                <div class="col-4 text-secondary small fw-bold">↳ Volume</div>
                <div class="col-8 d-flex align-items-center gap-2">
                    <input type="number" name="rating_volume" id="input_volume" class="form-control form-control-sm rating-input" 
                        min="0.5" max="5.0" step="0.5" value="{{ old('rating_volume', $post->rating_volume ?? '5.0') }}" style="width: 70px;">
                    <div class="star-display text-warning ms-2" id="stars_volume" style="font-size: 16px;"></div>
                </div>
            </div>

            {{-- Value --}}
            <div class="row align-items-center mb-3">
                <div class="col-4 text-secondary small fw-bold">↳ Value</div>
                <div class="col-8 d-flex align-items-center gap-2">
                    <input type="number" name="rating_sulit" id="input_sulit" class="form-control form-control-sm rating-input" 
                        min="0.5" max="5.0" step="0.5" value="{{ old('rating_sulit', $post->rating_sulit ?? '5.0') }}" style="width: 70px;">
                    <div class="star-display text-warning ms-2" id="stars_sulit" style="font-size: 16px;"></div>
                </div>
            </div>

            {{-- Vibes --}}
            <div class="row align-items-center">
                <div class="col-4 text-secondary small fw-bold">↳ Vibes</div>
                <div class="col-8 d-flex align-items-center gap-2">
                    <input type="number" name="rating_vibes" id="input_vibes" class="form-control form-control-sm rating-input" 
                        min="0.5" max="5.0" step="0.5" value="{{ old('rating_vibes', $post->rating_vibes ?? '5.0') }}" style="width: 70px;">
                    <div class="star-display text-warning ms-2" id="stars_vibes" style="font-size: 16px;"></div>
                </div>
            </div>
        </div>



        <button type="submit" class="btn btn-warning px-5">Save</button>

    </form>
@endsection
 