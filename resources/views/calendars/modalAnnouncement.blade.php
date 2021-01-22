<div class="modal fade" id="modalAnnouncement">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Announcement/Event Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ route('calendars.store') }}" id="formCalendar">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Date/Time Start</label>
                            <input name="dateTimeStart" type="datetime-local" class="form-control {{$errors->calendar->first('dateTimeStart') == null ? '' : 'is-invalid'}}">
                            @if($errors->calendar->first('dateTimeStart') != null)
                            <span class="invalid-feedback" role="alert">*{{ $errors->calendar->first('dateTimeStart') }}</span>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label>Date/Time End</label>
                            <input name="dateTimeEnd" type="datetime-local" class="form-control {{$errors->calendar->first('dateTimeEnd') == null ? '' : 'is-invalid'}}">
                            @if($errors->calendar->first('dateTimeEnd') != null)
                            <span class="invalid-feedback" role="alert">*{{ $errors->calendar->first('dateTimeEnd') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            @role('Admin')
                            <div class="form-group">
                                <label>Region</label>
                                <select name="region" id="region" class="form-control {!! $errors->profile->first('region', 'is-invalid') !!}">
                                    <option disabled selected>Select Region</option>
                                    @foreach ($regions as $region)
                                    <option value="{{ $region->code }}" {{ old('region')==$region->code ? 'selected' : ''}}>{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                            <input name="region" type="hidden" value="{{Auth::user()->region ?? ''}}">
                            @endrole

                        </div>

                        <!-- Color Picker -->
                        <div class="form-group col-md-6">
                            <label>Color</label>
                            <div class="input-group my-colorpicker2">
                                <input name="color" type="text" class="form-control">

                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input name="title" type="text" class="form-control {{$errors->calendar->first('title') == null ? '' : 'is-invalid'}}">
                        @if($errors->calendar->first('title') != null)
                        <span class="invalid-feedback" role="alert">*{{ $errors->calendar->first('title') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <input name="description" type="text" class="form-control {{$errors->calendar->first('description') == null ? '' : 'is-invalid'}}">
                        @if($errors->calendar->first('description') != null)
                        <span class="invalid-feedback" role="alert">*{{ $errors->calendar->first('description') }}</span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="id" type="hidden">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->