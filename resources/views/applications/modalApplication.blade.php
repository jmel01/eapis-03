<div class="modal fade" id="modalApplication">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Application Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form role="form" method="POST" action="{{ route('applications.store') }}" id="formApplication">
                @csrf
                <div class="modal-body">
                    @if(isset($grants) && count($grants) > 0)
                    <div class="form-group">
                        <label>Select Scholarship/Grant</label>
                        <select name="grant_id" class="form-control {{$errors->application->first('grant_id') == null ? '' : 'is-invalid'}}">
                            <option disabled selected>Select Scholarship/Grant</option>
                            @foreach ($grants as $grant)
                            <option value="{{ $grant->id}}" {{ old('grant_id')==$grant->id ? 'selected' : ''}}>{{ $grant->psgCode->name}} SY {{ $grant->acadYr}}-{{ $grant->acadYr+1}}</option>
                            @endforeach
                        </select>
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

                    @else
                    <p class="text-center">No available scholarship/grant as of the moment.<br>
                        Please come back later.<br>
                        Thank you.
                    </p>
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    @if(isset($grants) && count($grants) > 0)
                    <input name="user_id" value="{{old('user_id')}}" type="hidden">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    @endif
                </div>
            </form>

        </div>
    </div>
</div>