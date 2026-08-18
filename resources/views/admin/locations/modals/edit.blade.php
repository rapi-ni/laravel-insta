{{-- Edit --}}
    <div class="modal fade" id="edit-location-{{$location->id}}">
        <div class="modal-dialog">
            <div class="modal-content border-warning">
                <form action="{{ route('admin.locations.update', $location->id) }}" method="post">      
                    @csrf
                    @method('PATCH')                       
                    <div class="modal-header border-warning">
                        <h3 class="h5 modal-title text-dark">
                            <i class="fa-regular fa-pen-to-square"></i> Edit location
                        </h3>
                    </div>
                    <div class="modal-body">
                        <div>
                            <input type="text" 
                               name="location_name" id="location-{{ $location->id }}" class="form-control" value="{{ old('location_name', $location->name) }}" required autofocus>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-warning btn-sm" data-bs-dismiss="modal">
                                Cancel</button>
                            <button type="submit" class="btn btn-warning btn-sm">Update</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>