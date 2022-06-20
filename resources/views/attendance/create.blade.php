@extends('layouts.app')

@section('title', 'Create Attendance')
@section('styles')
    <style>
        .invalid-feedback {
            position: unset;
        }
    </style>
@endsection
@section('content')
    <div class="card p-4 mb-5">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ $error }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
        <form action="{{ route('attendance.store') }}" method="POST" id="create-form">
            @csrf
            <div class="mb-4">
                <label for="employee" class="mb-2">Employee</label>
                <select name="user_id" class="form-control attendance-select fs mt-3" id="employee">
                    <option value=""> -- Please Choose -- </option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" @if (old('user_id') == $employee->id) selected @endif>
                            {{ $employee->employee_id }} ({{ $employee->name }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-floating mb-4">
                <input type="text" id="date" class="form-control datepicker" name="date" value="{{ old('date') }}" />
                <label class="form-label fs" for="date">Date</label>
            </div>
            <div class="form-floating mb-4">
                <input type="text" id="check_in_time" class="form-control timepicker" name="check_in_time"
                    value="{{ old('check_in_time') }}" />
                <label class="form-label fs text-dark" for="check_in_time">Check In Time</label>
            </div>
            <div class="form-floating mb-4">
                <input type="text" id="check_out_time" class="form-control timepicker" name="check_out_time"
                    value="{{ old('check_out_time') }}" />
                <label class="form-label fs text-dark" for="check_out_time">Check Out Time</label>
            </div>
            <div class="mb-2 mt-4 col-md-6 mx-auto">
                <button type="submit" class="btn btn-secondary btn-block btn-sm">Confirm</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\StoreAttendanceRequest', '#create-form') !!}
    <script>
        $(document).ready(function() {
            // select2
            $(".attendance-select").select2({
                placeholder: "-- Choose Employee --"
            });
            // dateranger picker
            $('.datepicker').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                "drops": "down",
                "maxDate": moment(),
                "locale": {
                    "format": "YYYY-MM-DD"
                }
            });
            $('.timepicker').daterangepicker({
                "singleDatePicker": true,
                "timePicker": true,
                "drops": "down",
                "timePicker24Hour": true,
                "autoApply": true,
                "timePickerSeconds": true,
                "locale": {
                    "format": "HH:mm:ss"
                }
            }).on('show.daterangepicker', function(ev, picker) {
                picker.container.find('.calendar-table').hide();
            });
        });
    </script>
@endpush
