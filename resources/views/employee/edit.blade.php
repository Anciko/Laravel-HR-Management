@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
    <div class="card p-4 mb-5">
        <form action="{{ route('employee.update', $employee->id) }}" id="edit-form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-outline mb-5 ">
                <input type="text" id="employeeid" class="form-control" name="employeeid"
                    value="{{ $employee->employee_id }}" />
                <label class="form-label  fs" for="employeeid">Employee ID</label>
            </div>
            <div class="form-outline mb-5">
                <input type="text" id="name" class="form-control" name="name" value="{{ $employee->name }}" />
                <label class="form-label fs" for="name">Name</label>
            </div>
            <div class="form-outline mb-5">
                <input type="email" id="email" class="form-control" name="email" value="{{ $employee->email }}" />
                <label class="form-label fs" for="email">Email</label>
            </div>
            <div class="form-outline mb-4">
                <input type="tel" id="phone" class="form-control" name="phone" value="{{ $employee->phone }}" />
                <label class="form-label fs" for="phone">Phone</label>
            </div>
            <div class="form-outline mb-4">
                <input type="text" id="nrc" class="form-control" name="nrc" value="{{ $employee->nrc_number }}" />
                <label class="form-label fs" for="nrc">NRC</label>
            </div>
            <div class="form-floating mb-4">
                <select class="form-select" id="department" name="department">
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @if ($department->id == $employee->department_id) selected @endif>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                <label for="department">Department</label>
            </div>
            <div class="form-floating mb-4">
                <input type="text" id="birthday" class="form-control datepicker" name="birthday"
                    value="{{ $employee->birthday }}" />
                <label class="form-label fs" for="birthday">Birthday</label>
            </div>
            <div class="form-floating mb-4">
                <select class="form-select fs" name="gender">
                    <option value="male" @if ($employee->gender == 'male') selected @endif>Male</option>
                    <option value="female" @if ($employee->gender == 'female') selected @endif>Female</option>
                </select>
                <label for="gender">Gender</label>
            </div>
            <div class="form-outline mb-4">
                <input type="text" id="password" class="form-control" name="password" />
                <label class="form-label fs" for="password">Password</label>
            </div>
            <div class="form-outline mb-4">
                <textarea class="form-control" id="address" rows="4" name="address">
                    {{ $employee->address }}
                </textarea>
                <label class="form-label" for="address">Address</label>
            </div>
            <div class="form-floating mb-4">
                <input type="text" id="dateOfJoin" class="form-control datepicker" name="dateOfJoin"
                    value="{{ $employee->date_of_join }}" />
                <label class="form-label fs" for="dateOfJoin">Date Of Join</label>
            </div>
            <div class="mb-4">
                <label for="profile_img fs">Profile Image</label>
                <input type="file" class="form-control form-control-md" id="profile_img" name="profile_img">
                <div class="preview_img mt-2">
                    <img src="{{ $employee->profile_img_path() }}" class="img-fluid mt-2 rounded-1 me-2" width="100">
                </div>
            </div>
            <div class="form-floating mb-4">
                <select class="form-select fs" name="present">
                    <option value="1" @if ($employee->is_present == 1) selected @endif>Yes</option>
                    <option value="0" @if ($employee->is_present == 0) selected @endif>No</option>
                </select>
                <label for="gender">Is Present?</label>
            </div>
            <div class="mb-2 col-md-6 mx-auto">
                <button type="submit" class="btn btn-secondary btn-block btn-sm">Confirm</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateEmployeeRequest', '#edit-form') !!}
    <script>
        $(document).ready(function() {
            $('.datepicker').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                "drops": "up",
                "maxDate": moment(),
                "locale": {
                    "format": "YYYY-MM-DD"
                }
            });
        });
        $('#profile_img').on('change', function() {
            let file_length = document.getElementById('profile_img').files.length;
            $('.preview_img').html("");
            for (let i = 0; i < file_length; i++) {
                $('.preview_img').append(
                    `<img src="${URL.createObjectURL(event.target.files[i])}" class="img-fluid me-2" width="100" />`
                );
            }
        });
    </script>
@endpush
