@extends('layouts.app')

@section('title', 'Edit Company Setting')

@section('content')
    <div class="card p-4 mb-5">
        <form action="{{ route('company-setting.update',1) }}" method="POST" id="edit-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-outline mb-4 ">
                <input type="text" id="company_name" class="form-control" name="company_name" value="{{ $company_setting->company_name }}" autofocus />
                <label class="form-label fs" for="company_name">Company Name</label>
            </div>
            <div class="form-outline mb-4 mt-3">
                <input type="text" id="company_email" class="form-control" name="company_email" value="{{ $company_setting->company_email }}"" />
                <label class="form-label fs" for="company_email">Company Email</label>
            </div>
            <div class="form-outline mb-4">
                <input type="email" id="company_phone" class="form-control" name="company_phone" value="{{ $company_setting->company_phone }}" />
                <label class="form-label fs" for="company_phone">Company Phone</label>
            </div>
            <div class="form-outline mb-4">
                <input type="tel" id="company_address" class="form-control" name="company_address" value="{{ $company_setting->company_address }}" />
                <label class="form-label fs" for="company_address">Company Address</label>
            </div>

            <div class="form-floating mb-4">
                <input type="text" id="office_start_time" class="form-control timepicker" name="office_start_time" value="{{ $company_setting->office_start_time }}"/>
                <label class="form-label fs text-dark" for="office_start_time">Office Start Time</label>
            </div>
            <div class="form-floating mb-4">
                <input type="text" id="office_end_time" class="form-control timepicker" name="office_end_time" value="{{ $company_setting->office_end_time }}" />
                <label class="form-label fs text-dark" for="office_end_time">Office End Time</label>
            </div>

            <div class="form-floating mb-4">
                <input type="text" id="break_start_time" class="form-control timepicker" name="break_start_time" value="{{ $company_setting->break_start_time }}" />
                <label class="form-label fs text-dark" for="break_start_time">Break Start Time</label>
            </div>

            <div class="form-floating mb-4">
                <input type="text" id="break_end_time" class="form-control timepicker" name="break_end_time" value="{{ $company_setting->break_end_time }}" />
                <label class="form-label fs text-dark" for="break_end_time">Break End Time</label>
            </div>

            <div class="mb-2 col-md-6 mx-auto">
                <button type="submit" class="btn btn-secondary btn-block btn-sm">Confirm</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\StoreCompanySettingRequest', '#edit-form') !!}
    <script>
        $(document).ready(function() {
            $('.timepicker').daterangepicker({
                "singleDatePicker": true,
                "timePicker" : true,
                "timePicker24Hour": true,
                "autoApply": true,
                "locale": {
                    "format": "HH:mm:ss"
                }
            }).on('click', function() {
                $('.table-condensed').hide();
            });
        });

    </script>
@endpush
