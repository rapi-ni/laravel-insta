{{-- Delete --}}
    <div class="modal fade" id="delete-location-{{$location->id}}">
        <div class="modal-dialog">
            <div class="modal-content border-danger">
                <form action="{{ route('admin.locations.destroy', $location->id) }}" method="post">      
                    @csrf
                    @method('DELETE')                       
                    <div class="modal-header border-danger">
                        <h3 class="h5 modal-title text-danger">
                            <i class="fa-solid fa-trash-can"></i> Delete location
                        </h3>
                    </div>
                    <div class="modal-body">
                        <p>
                            Are you sure you want to delete <span class="fw-bold">{{ $location->name }}</span> ?
                            <br>
                            <br>
                            This action will affect all the posts under this location. Posts without a location will fall under No Location Assigned.
                        </p>
                    </div>
                    <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                                Cancel</button>
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>