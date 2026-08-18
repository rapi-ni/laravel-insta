@extends('layouts.app')
 
@section('title', 'Admin: Locations')
 
@section('content')
    <!-- Form -->
    <div class="mb-3 w-50">
        <form action="{{ route('admin.locations.store') }}" method="post">
            @csrf
            <div class="row gx-2">
                <div class="col">
                    <input type="text" name="location_name" id="location" class="form-control" placeholder="Add a new location (e.g., IT Park, UCMA)" required autofocus>
                </div>
                <div class="col-auto">
                    <button type="submit" name="btn_add" class="btn btn-primary w-100 fw-bold">
                        <i class="fa-solid fa-plus"></i>Add
                    </button>
                </div>
            </div>
        </form>
    </div>
    @error('location_name')
        <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
    @enderror

    <!-- Table -->
    <table class="table table-hover align-middle bg-white border text-secondary w-75 text-center">
        <thead class="small table-info text-secondary">
            <tr>
                <th>#</th>
                <th>LOCATION NAME</th>
                <th>COUNT</th>
                <th>LAST UPDATE</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_locations as $location)
                <tr>
                    <td>{{ $location->id }}</td>
                    <td>{{ ucfirst($location->name) }}</td>
                    <td>{{ $location->posts_count }}</td>
                    <td>{{ $location->updated_at }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-warning me-2" data-bs-toggle="modal" data-bs-target="#edit-location-{{ $location->id }}">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-location-{{ $location->id }}">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                        @include('admin.locations.modals.edit')
                        @include('admin.locations.modals.delete')
                    </td>
                </tr>
            @endforeach
                <tr>
                    <td></td>
                    <td>
                        No Location Assigned
                        <div class="text-muted small">Hidden posts are not included.</div>
                    </td>
                    <td>{{ $no_location_count }}</td>
                    <td></td>
                    <td></td>
                </tr>
        </tbody>
    </table>
@endsection
 