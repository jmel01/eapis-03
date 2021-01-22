<div class="modal fade" id="modalDocument">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Document Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ route('documents.store') }}" id="formDocument" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Requirement</label>

                        <select name="requirementID" class="form-control {!! $errors->profile->first('requirementID', 'is-invalid') !!}">
                            <option value="" disabled selected>Select Requirement</option>
                            @forelse(\App\Models\Requirement::all() as $requirement )
                            <option value="{{ $requirement->id }}" {{ old('region')==$requirement->id ? 'selected' : ''}}>{{ $requirement->description }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label>File</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="grantID" value="{{old('grantID')}}" type="hidden">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>