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
                        <label>Status</label>
                        <select name="status" class="form-control {{$errors->application->first('status') == null ? '' : 'is-invalid'}}">
                            <option disabled selected>Select Status</option>

                            <option value="On Process" {{ old('status') == "On Process" ? 'selected' : ''}}>On Process</option>
                            <option value="Approved" {{ old('status')== "Approved" ? 'selected' : ''}}>Approved</option>
                            <option value="Graduated" {{ old('status') == "Graduated" ? 'selected' : ''}}>Graduated</option>
                            <option value="Terminated-FSD" {{ old('tystatuspe')== "Terminated-FSD" ? 'selected' : ''}}>Terminated-FSD</option>
                            <option value="Terminated-FG" {{ old('status')== "Terminated-FG" ? 'selected' : ''}}>Terminated-FG</option>
                            <option value="Terminated-DS" {{ old('status')== "Terminated-DS" ? 'selected' : ''}}>Terminated-DS</option>
                            <option value="Terminated-NE" {{ old('status')== "Terminated-NE" ? 'selected' : ''}}>Terminated-NE</option>
                            <option value="Terminated-FPD" {{ old('status')== "Terminated-FPD" ? 'selected' : ''}}>Terminated-FPD</option>
                            <option value="Terminated-EOGS" {{ old('status')== "Terminated-EOGS" ? 'selected' : ''}}>Terminated-EOGS</option>
                            <option value="Terminated-Others" {{ old('status')== "Terminated-Others" ? 'selected' : ''}}>Terminated-Others</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <input name="remarks" type="text" value="{{old('remarks')}}" class="form-control {{$errors->application->first('remarks') == null ? '' : 'is-invalid'}}">
                    </div>

                    <div class="form-group">
                        <label>Type of Assistance</label>
                        <select name="type" class="form-control {{$errors->application->first('type') == null ? '' : 'is-invalid'}}">
                            <option disabled selected>Select Type</option>
                            <option value="Regular" {{ old('type')=='Regular' ? 'selected' : ''}}>Regular</option>
                            <option value="Merit-Based" {{ old('type')=='Merit-Based' ? 'selected' : ''}}>Merit-Based</option>
                            <option value="PDAF" {{ old('type')=='PDAF' ? 'selected' : ''}}>PDAF</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Assistance Applied/Level</label>
                        <select name="level" class="form-control {{$errors->application->first('level') == null ? '' : 'is-invalid'}}">
                            <option disabled selected>Select Level</option>
                            <option value="Post Study" {{ old('level') == "Post Study" ? 'selected' : ''}}>Post Study</option>
                            <option value="College" {{ old('level') == "College" ? 'selected' : ''}}>College</option>
                            <option value="Vocational" {{ old('level')== "Vocational" ? 'selected' : ''}}>Vocational</option>
                            <option value="High School" {{ old('level')== "High School" ? 'selected' : ''}}>High School</option>
                            <option value="Elementary" {{ old('level')== "Elementary" ? 'selected' : ''}}>Elementary</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>School</label>
                        <input name="school" type="text" value="{{old('school')}}" class="form-control {{$errors->application->first('school') == null ? '' : 'is-invalid'}}">
                    </div>

                    <div class="form-group">
                        <label>Course/Level</label>
                        <input name="course" type="text" value="{{old('course')}}" class="form-control {{$errors->application->first('course') == null ? '' : 'is-invalid'}}">
                    </div>

                    <div class="form-group">
                        <label>What possible contribution/s that you may extend to your community or fellow ICCs/IPs while studying?</label>
                        <textarea name="contribution" rows="5" class="form-control {{$errors->application->first('contribution') == null ? '' : 'is-invalid'}}">{{old('contribution')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label>What are your plans after graduation?</label>
                        <textarea name="plans" rows="5" class="form-control {{$errors->application->first('plans') == null ? '' : 'is-invalid'}}">{{old('plans')}}</textarea>
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