<div class="modal fade" id="modalEthnoGroup">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">EthnoGroup Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ route('ethnogroups.store') }}" id="formEthnoGroup">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Region</label>
                        <select name="region" class="form-control {{$errors->ethnoGroup->first('ipgroup') == null ? '' : 'is-invalid'}}">
                            <option disabled selected>Select Region</option>
                            @foreach ($regions as $region)
                            <option value="{{ $region->code }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Ethnolinguistic Group</label>
                        <input name="ipgroup" type="text" value="{{old('ipgroup')}}" class="form-control {{$errors->ethnoGroup->first('ipgroup') == null ? '' : 'is-invalid'}}">

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