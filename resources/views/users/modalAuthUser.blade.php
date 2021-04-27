<div class="modal fade" id="modalAuthUser">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">User Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ route('updateCredential') }}" id="formUser">
                @csrf
                <div class="modal-body">

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

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>