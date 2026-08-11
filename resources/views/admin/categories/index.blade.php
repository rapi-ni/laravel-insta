@extends('layouts.app')
 
@section('title', 'Admin: Categories')
 
@section('content')
    <!-- Form -->
    <div class="mb-3 w-50">
        <form action="{{ route('admin.categories.store') }}" method="post">
            @csrf
            <div class="row gx-2">
                <div class="col">
                    <input type="text" name="category" id="category" class="form-control" placeholder="Add a category" required autofocus>
                </div>
                <div class="col-auto">
                    <button type="submit" name="btn_add" class="btn btn-primary w-100 fw-bold">
                        <i class="fa-solid fa-plus"></i>Add
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table -->
    <table class="table table-hover align-middle bg-white border text-secondary w-75 text-center">
        <thead class="small table-warning text-secondary">
            <tr>
                <th>#</th>
                <th>NAME</th>
                <th>COUNT</th>
                <th>LAST UPDATE</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ ucfirst($category->name) }}</td>
                    <td>{{ $category->categorypost_count }}</td>
                    <td>{{ $category->updated_at }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-warning me-2" data-bs-toggle="modal" data-bs-target="#edit-category-{{ $category->id }}">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-category-{{ $category->id }}">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                        @include('admin.categories.modals.edit')
                        @include('admin.categories.modals.delete')
                    </td>
                </tr>
            @endforeach
                <tr>
                    <td></td>
                    <td>
                        Uncategorized
                        <div class="text-muted small">Hidden posts are not included.</div>
                    </td>
                    <td>{{ $uncategorized_count}}</td>
                    <td></td>
                    <td></td>
                </tr>
        </tbody>
    </table>
@endsection
 