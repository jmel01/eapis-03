<div class="modal fade" id="modalApplicationEdit">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Application Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
           
            <form role="form" method="POST" action="{{ route('applications.store') }}" id="formApplicationEdit">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control {{$errors->profile->first('civilStatus') == null ? '' : 'is-invalid'}}">
                            <option disabled selected>Select Type</option>
                            <option value="Regular" {{ old('type')=='Regular' ? 'selected' : ''}}>Regular</option>
                            <option value="Merit-Based" {{ old('type')=='Merit-Based' ? 'selected' : ''}}>Merit-Based</option>
                            <option value="PDAF" {{ old('type')=='PDAF' ? 'selected' : ''}}>PDAF</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Level</label>
                        <select name="level" class="form-control {{$errors->profile->first('civilStatus') == null ? '' : 'is-invalid'}}">
                            <option disabled selected>Select Level</option>
                            <option value="Post Study" {{ old('type') == "Post Study" ? 'selected' : ''}}>Post Study</option>
                            <option value="College" {{ old('type') == "College" ? 'selected' : ''}}>College</option>
                            <option value="Vocational" {{ old('type')== "Vocational" ? 'selected' : ''}}>Vocational</option>
                            <option value="High School" {{ old('type')== "High School" ? 'selected' : ''}}>High School</option>
                            <option value="Elementary" {{ old('type')== "Elementary" ? 'selected' : ''}}>Elementary</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>School</label>
                        <input name="school" type="text" value="{{old('amount')}}" class="form-control {{$errors->application->first('amount') == null ? '' : 'is-invalid'}}">
                    </div>

                    <div class="form-group">
                        <label>Course/Level</label>
                        <input name="course" type="text" value="{{old('checkNo')}}" class="form-control {{$errors->application->first('checkNo') == null ? '' : 'is-invalid'}}">
                    </div>

                    <div class="form-group">
                        <label>Contribution</label>
                        <input name="contribution" type="text" value="{{old('province')}}" class="form-control {{$errors->application->first('province') == null ? '' : 'is-invalid'}}">
                    </div>

                    <div class="form-group">
                        <label>Plans</label>
                        <input name="plans" type="text" value="{{old('province')}}" class="form-control {{$errors->application->first('province') == null ? '' : 'is-invalid'}}">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control {{$errors->profile->first('status') == null ? '' : 'is-invalid'}}">
                            <option disabled selected>Select Status</option>
                            
                            <option value="On Process" {{ old('type') == "On Process" ? 'selected' : ''}}>On Process</option>
                            <option value="Approved" {{ old('type')== "Approved" ? 'selected' : ''}}>Approved</option>
                            <option value="Graduated" {{ old('type') == "Graduated" ? 'selected' : ''}}>Graduated</option>
                            <option value="Terminated-FSD" {{ old('type')== "Terminated-FSD" ? 'selected' : ''}}>Terminated-FSD</option>
                            <option value="Terminated-FG" {{ old('type')== "Terminated-FG" ? 'selected' : ''}}>Terminated-FG</option>
                            <option value="Terminated-DS" {{ old('type')== "Terminated-DS" ? 'selected' : ''}}>Terminated-DS</option>
                            <option value="Terminated-NE" {{ old('type')== "Terminated-NE" ? 'selected' : ''}}>Terminated-NE</option>
                            <option value="Terminated-FPD" {{ old('type')== "Terminated-FPD" ? 'selected' : ''}}>Terminated-FPD</option>
                            <option value="Terminated-EOGS" {{ old('type')== "Terminated-EOGS" ? 'selected' : ''}}>Terminated-EOGS</option>
                            <option value="Terminated-Others" {{ old('type')== "Terminated-Others" ? 'selected' : ''}}>Terminated-Others</option>
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <input name="remarks" type="text" value="{{old('remarks')}}" class="form-control {{$errors->application->first('remarks') == null ? '' : 'is-invalid'}}">
                    </div>

                </div>
                <div class="modal-footer">
                    <input name="user_id" value="{{old('user_id')}}" type="hidden">
                    <input name="grant_id" value="{{old('grant_id')}}" type="hidden">
                    <input name="id" value="{{old('id')}}" type="hidden">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
           
        </div>
    </div>
</div>