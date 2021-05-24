<div class="modal fade" id="modalGrantPayment">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Disbursement Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ route('costs.store') }}" id="formGrantPayment">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Date Received <span class="text-danger">*</span></label>
                        <input name="dateRcvd" type="date" value="{{old('dateRcvd')}}" class="form-control {{$errors->cost->first('dateRcvd') == null ? '' : 'is-invalid'}}" required>
                    </div>

                    <div class="form-group">
                        <label>School Year <span class="text-danger">*</span></label>
                        <input name="schoolYear" type="text" value="{{old('schoolYear')}}" class="form-control {{$errors->cost->first('schoolYear') == null ? '' : 'is-invalid'}}" required>
                    </div>

                    <div class="form-group">
                        <label>Semester <span class="text-danger">*</span></label>
                        <select name="semester" class="form-control {!! $errors->cost->first('semester', 'is-invalid') !!}" required>
                            <option value="" disabled selected>Select Semester</option>
                            <option value="First Semester" {{ old('semester')=='First Semester' ? 'selected' : ''}}>First Semester</option>
                            <option value="Second Semester" {{ old('semester')=='Second Semester' ? 'selected' : ''}}>Second Semester</option>
                            <option value="Not Applicable" {{ old('semester')=='First SNot Applicable' ? 'selected' : ''}}>Not Applicable</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Payee <span class="text-danger">*</span></label>
                        <input name="payee" type="text" value="{{old('payee')}}" class="form-control {{$errors->cost->first('payee') == null ? '' : 'is-invalid'}}" required>
                    </div>

                    <div class="form-group">
                        <label>Particulars <span class="text-danger">*</span></label>
                        <input name="particulars" type="text" value="{{old('particulars')}}" class="form-control {{$errors->cost->first('particulars') == null ? '' : 'is-invalid'}}" required>
                    </div>

                    <div class="form-group">
                        <label>Amount <span class="text-danger">*</span></label>
                        <input name="amount" type="number" step=".01" value="{{old('amount')}}" class="form-control {{$errors->cost->first('amount') == null ? '' : 'is-invalid'}}" required>
                    </div>

                    <div class="form-group">
                        <label>Mode of Payment/Reference No. <span class="text-danger">*</span></label>
                        <input name="checkNo" type="text" value="{{old('checkNo')}}" class="form-control {{$errors->cost->first('checkNo') == null ? '' : 'is-invalid'}}" required>
                    </div>


                </div>
                <div class="modal-footer">
                    <input name="id" value="{{old('id')}}" type="hidden">
                    <input name="grant_id" value="{{old('grant_id')}}" type="hidden">
                    <input name="user_id" value="{{old('user_id')}}" type="hidden">
                    <input name="application_id" value="{{old('application_id')}}" type="hidden">
                    <input name="province" value="{{old('province')}}" type="hidden">
                    <p class="text-danger text-left">* required field</p>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>