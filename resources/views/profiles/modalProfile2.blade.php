<div class="modal fade" id="modalProfile">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Profile Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ route('profiles.store') }}" id="formProfile">
                @csrf
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <input name="id" value="{{old('id')}}" type="hidden">

                    <div style="overflow:auto;">
                        <div style="float:right;">
                            <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="btn btn-default">Previous</button>
                            <button type="button" id="nextBtn" onclick="nextPrev(1)" class="btn btn-primary">Next</button>
                        </div>
                    </div>
                    <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button> -->
                </div>
            </form>
        </div>
    </div>
</div>