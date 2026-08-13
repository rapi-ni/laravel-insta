@extends('layouts.app')
 
@section('title', $user->name)
    
@section('content')
    <div class="row justify-content-center">
        <div class="col-8">
            <form action="{{ route('profile.update')}}" method="post" class="bg-white shadow rounded-3 p-5" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <h2 class="h3 mb-3 fs-light text-muted">Update Profile</h2>

            <div class="row mb-3">
                <div class="col-4">
                    @if ($user->avatar)
                    <img src="{{$user->avatar}}" alt="{{$user->name}}" class="img-thumbnail rounded-circle d-block mx-auto avatar-lg">
                    @else
                    <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
                    @endif
                </div>
                <div class="col-auto align-self-end">
                    <input type="file" name="avatar" id="avatar" class="form-control form-control-sm mt-1" aria-describedby="avatar-info">
                    <div class="form-text" id="avatar-info">
                        Acceptable formats; jpeg, jpg, png, gif only.<br>
                        Max file size is 1048kb.
                    </div>
                    {{-- Error --}}
                    @error('avatar')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name', $user->name)}}" autofocus>
                {{-- Error --}}
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">E-mail Address</label>
                <input type="email" name="email" id="email" class="form-control" value="{{old('email', $user->email)}}">
                {{-- Error --}}
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="introduction" class="form-label fw-bold">Introduction</label>
                <textarea name="introduction" id="introduction" rows="5" class="form-control" placeholder="Describe yourself">{{old('introduction', $user->introduction)}}</textarea>
                {{-- Error --}}
                @error('introduction')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <section class="taste-edit-card mb-4">
                <div class="mb-4">
                    <h3 class="h5 fw-bold mb-1">Taste Profile</h3>
                    <p class="text-muted small mb-0">Choose how much you like each type of food.</p>
                </div>

                @php
                    $tasteFields = [
                        'spicy_level' => ['label' => 'Spicy', 'emoji' => '🌶️'],
                        'sweet_level' => ['label' => 'Sweet', 'emoji' => '🧁'],
                        'meat_level' => ['label' => 'Meat', 'emoji' => '🍖'],
                        'vegetable_level' => ['label' => 'Vegetables', 'emoji' => '🥦'],
                    ];
                @endphp

                @foreach ($tasteFields as $field => $taste)
                    <fieldset class="taste-edit-row">
                        <legend class="taste-edit-label">{{ $taste['label'] }}</legend>

                        <div class="taste-edit-options">
                            @for ($level = 1; $level <= 5; $level++)
                                <input type="radio" class="btn-check" name="{{ $field }}"
                                    id="{{ $field }}-{{ $level }}" value="{{ $level }}"
                                    @checked((int) old($field, $user->$field) === $level)>

                                <label class="taste-edit-option" for="{{ $field }}-{{ $level }}"
                                    title="{{ $level }} out of 5">
                                    <span>{{ $taste['emoji'] }}</span>
                                    <small>{{ $level }}</small>
                                </label>
                            @endfor
                        </div>

                        @error($field)
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </fieldset>
                @endforeach

                <div class="mt-4">
                    <label for="favorite_foods" class="form-label fw-bold">Favorite Foods</label>
                    <input type="text" name="favorite_foods" id="favorite_foods"
                        class="form-control taste-food-input @error('favorite_foods') is-invalid @enderror"
                        value="{{ old('favorite_foods', $user->favorite_foods) }}"
                        placeholder="Ramen, Yakiniku, Strawberry Cake">
                    <div class="form-text">Separate multiple foods with commas.</div>

                    @error('favorite_foods')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </section>

            <button type="submit" class="btn auth-submit px-5">Save Profile</button>

        </form>
        </div>
    </div>
@endsection
 
