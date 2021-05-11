<div class="modal fade" id="modalProfilePicture">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Profile Picture Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('profiles.store') }}" accept-charset="UTF-8" id="formProfilePicture" class="form-modal" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-center">
                        <input type="file" class="form-control-file rounded-0" name="profilePicture" id="profilePicture" accept="image/*">
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="forProfilePicture" value="picture">
                    <button type="submit" form="formProfilePicture" class="btn btn-primary rounded-0">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
