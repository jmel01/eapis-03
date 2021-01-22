<div class="modal fade" id="modalApplication">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Application Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if(isset($grants) && count($grants) > 0)
            <form role="form" method="POST" action="{{ route('applications.store') }}" id="formApplication">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label>Select Scholarship/Grant</label>
                        <select name="grant_id" class="form-control {{$errors->profile->first('civilStatus') == null ? '' : 'is-invalid'}}">
                            <option disabled selected>Select Scholarship/Grant</option>
                            @foreach ($grants as $grant)
                            <option value="{{ $grant->id}}" {{ old('grant_id')=='$grant->id' ? 'selected' : ''}}>Region: {{ $grant->region}} SY {{ $grant->acadYr}}-{{ $grant->acadYr+1}}</option>
                            @endforeach
                        </select>
                    </div>

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

                </div>
                <div class="modal-footer">
                    <input name="user_id" value="{{old('user_id')}}" type="hidden">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            @else
            <div class="modal-body">
                <p class="text-center">No available scholarship/grant as of the moment.<br>
                Please come back later.<br>
                Thank you.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            @endif
        </div>
    </div>
</div>