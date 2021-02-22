<div class="modal fade" id="modalEmployment">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Employment Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ route('employments.store') }}" id="formEmployment">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Employment Date</label>
                        <input name="yearEmployed" type="date" value="{{old('yearEmployed')}}" class="form-control {{$errors->employment->first('yearEmployed') == null ? '' : 'is-invalid'}}">
                    </div>

                    <div class="form-group">
                        <label>Type of Employment</label>
                        <select name="employerType" class="form-control {{$errors->employment->first('employerType') == null ? '' : 'is-invalid'}}">
                            <option disabled selected>Select Level</option>
                            <option value="FE" {{ old('employerType') == "FE" ? 'selected' : ''}}>FE</option>
                            <option value="PE" {{ old('employerType') == "PE" ? 'selected' : ''}}>PE</option>
                            <option value="SE" {{ old('employerType')== "SE" ? 'selected' : ''}}>SE</option>
                            <option value="GO/NGO/CSO" {{ old('employerType')== "GO/NGO/CSO" ? 'selected' : ''}}>GO/NGO/CSO</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Position/Title</label>
                        <input name="position" type="text" value="{{old('position')}}" class="form-control {{$errors->employment->first('position') == null ? '' : 'is-invalid'}}">
                    </div>

                    <div class="form-group">
                        <label>Department / Agency / Office / Company</label>
                        <input name="employerName" type="text" value="{{old('employerName')}}" class="form-control {{$errors->employment->first('employerName') == null ? '' : 'is-invalid'}}">
                    </div>

                    <div class="form-group">
                        <label>Employer Address</label>
                        <input name="employerAddress" type="text" value="{{old('employerAddress')}}" class="form-control {{$errors->employment->first('employerAddress') == null ? '' : 'is-invalid'}}">
                    </div>

                </div>
                <div class="modal-footer">
                    <input name="user_id" value="{{old('user_id')}}" type="hidden">   
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>