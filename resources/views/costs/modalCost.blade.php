<div class="modal fade" id="modalCost">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Disbursement Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ route('costs.store') }}" id="formCost">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Date Received</label>
                        <input name="dateRcvd" type="date" value="{{old('dateRcvd')}}" class="form-control {{$errors->cost->first('dateRcvd') == null ? '' : 'is-invalid'}}">
                    </div>

                    <div class="form-group">
                        <label>Payee</label>
                        <input name="payee" type="text" value="{{old('payee')}}" class="form-control {{$errors->cost->first('payee') == null ? '' : 'is-invalid'}}">
                    </div>

                    <div class="form-group">
                        <label>Particulars</label>
                        <input name="particulars" type="text" value="{{old('particulars')}}" class="form-control {{$errors->cost->first('particulars') == null ? '' : 'is-invalid'}}">
                    </div>

                    <div class="form-group">
                        <label>Amount</label>
                        <input name="amount" type="number" step=".01" value="{{old('amount')}}" class="form-control {{$errors->cost->first('amount') == null ? '' : 'is-invalid'}}">
                    </div>

                    <div class="form-group">
                        <label>Mode of Payment/Reference No.</label>
                        <input name="checkNo" type="text" value="{{old('checkNo')}}" class="form-control {{$errors->cost->first('checkNo') == null ? '' : 'is-invalid'}}">
                    </div>

                    <div class="form-group">
                        <label>Province</label>
                        <select name="province" class="form-control {{$errors->cost->first('province') == null ? '' : 'is-invalid'}}">
                            <option disabled selected>Select Province</option>
                            @foreach ($provinces as $province)
                            <option value="{{ $province->code }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <input name="id" value="{{old('id')}}" type="hidden">
                    <input name="grant_id" value="{{old('grant_id',$grant->id)}}" type="hidden">
                    <input name="user_id" value="{{old('user_id')}}" type="hidden">
                    <input name="application_id" value="{{old('application_id')}}" type="hidden">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>