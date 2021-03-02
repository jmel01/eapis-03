<div class="modal fade" id="modalUser">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">User Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ route('users.store') }}" id="formUser">
                @csrf
                <div class="modal-body">
                    @role('Admin')
                    <div class="form-group">
                        <label>Region</label>
                        <select name="region" class="form-control {!! $errors->profile->first('region', 'is-invalid') !!}">
                            <option disabled selected>Select Region</option>
                            @foreach ($regions as $region)
                            <option value="{{ $region->code }}" {{ old('region')==$region->code ? 'selected' : ''}}>{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <input name="region" type="hidden" value="{{Auth::user()->region ?? ''}}">
                    @endrole

                    <div class="form-group">
                        <label>Username</label>
                        <input name="name" type="text" value="{{old('name')}}" class="form-control {{$errors->user->first('name') == null ? '' : 'is-invalid'}}" placeholder="Juan Dela Cruz">
                    </div>

                    <div class="form-group">
                        <label>Email address</label>
                        <input name="email" type="email" value="{{old('email')}}" class="form-control {{$errors->user->first('email') == null ? '' : 'is-invalid'}}" placeholder="juandelacruz@email.com">
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Password</label>
                            <input name="password" type="password" value="{{old('password')}}" class="form-control {{$errors->user->first('password') == null ? '' : 'is-invalid'}}" placeholder="Password">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Confirm Password</label>
                            <input name="confirm-password" type="password" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Select Role</label>
                        <div class="select2-primary">
                            <select name="roles[]" id="roles" class="form-control select2 {!! $errors->user->first('roles', 'is-invalid') !!}" multiple>
                                @foreach ($roles as $role)
                                <option value="{{ $role }}" {{ (collect(old('roles'))->contains($role)) ? 'selected':'' }}>{{ $role }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input name="id" value="{{old('id')}}" type="hidden">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>