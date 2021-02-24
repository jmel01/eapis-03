<div class="modal fade" id="modalShowAnnouncement">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Announcement/Event</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Date/Time Start</label>
                    <input name="datestart" type="datetime-local" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label>Date/Time End</label>
                    <input name="dateend" type="datetime-local" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label>Region</label>
                    <select name="region" id="region" class="form-control {!! $errors->profile->first('region', 'is-invalid') !!}" disabled>
                        @foreach (App\Models\Psgc::where('level','Reg')->get() as $region)
                        <option value="{{ $region->code }}" {{ old('region')==$region->code ? 'selected' : ''}}>{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Title</label>
                    <input name="title" type="text" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Enter ..." readonly></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->