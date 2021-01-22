{{-- !-- Delete Warning Modal -->  --}}
<div class="modal fade" id="modalDelete">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form role="form" method="POST" action="" id="formDelete">
                    @csrf
                    @method('DELETE')
                    <p>Are you sure you want to delete this record?</p>
                    <button type="button" class="btn btn-default btn-sm float-right" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm mr-1 float-right">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>