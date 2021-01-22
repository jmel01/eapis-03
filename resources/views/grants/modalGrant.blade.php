<div class="modal fade" id="modalGrant">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Grant Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ route('grants.store') }}" id="formGrant">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Region</label>
                        <select name="region" class="form-control">
                            <option disabled selected>Select Region</option>
                            @foreach ($regions as $region)
                            <option value="{{ $region->code }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class=col-md-3>
                            <div class="form-group">
                                <label>Academic Year From:</label>
                                <input name="acadYr" type="number" min="1980" step="1" id="acadYr" onchange="acadYrChange()"
                                value="{{old('name')}}" class="form-control {{$errors->user->first('name') == null ? '' : 'is-invalid'}}">

                            </div>
                        </div>
                        <div class=col-md-3>
                            <div class="form-group">
                                <label>To:</label>
                                <input name="acadYrEnd" class="form-control" disabled>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Opening Date:</label>
                                <input name="applicationOpen" type="date" id="applicationOpen" onchange="applicationClosedMinDate()" 
                                value="{{old('name')}}" class="form-control {{$errors->user->first('name') == null ? '' : 'is-invalid'}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Closing Date:</label>
                                <input name="applicationClosed" type="date" id="applicationClosed" 
                                value="{{old('name')}}" class="form-control {{$errors->user->first('name') == null ? '' : 'is-invalid'}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="id" type="hidden">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>