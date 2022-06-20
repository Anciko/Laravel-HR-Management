@extends('layouts.app')

@section('title', 'Create Employee')

@section('content')
    <div class="card p-4 mb-5">
        <form action="{{ route('employee.store') }}" method="POST" id="create-form" enctype="multipart/form-data">
            @csrf
            <div class="form-outline mb-4 ">
                <input type="text" id="employeeid" class="form-control" name="employeeid" />
                <label class="form-label fs" for="employeeid">Employee ID</label>
            </div>
            <div class="form-outline mb-4 mt-3">
                <input type="text" id="name" class="form-control" name="name" />
                <label class="form-label fs" for="name">Name</label>
            </div>
            <div class="form-outline mb-4">
                <input type="email" id="email" class="form-control" name="email" />
                <label class="form-label fs" for="email">Email</label>
            </div>
            <div class="form-outline mb-4">
                <input type="tel" id="phone" class="form-control" name="phone" />
                <label class="form-label fs" for="phone">Phone</label>
            </div>
            <div class="form-outline mb-4">
                <input type="text" id="nrc" class="form-control" name="nrc" />
                <label class="form-label fs" for="nrc">NRC</label>
            </div>
            <div class="form-floating mb-4">
                <select class="form-select" id="department" name="department">
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}"> {{ $department->name }} </option>
                    @endforeach
                </select>
                <label for="department">Department</label>
            </div>

            <div class=" mb-4">
                <label for="role">Roles</label>
                <select class="form-select ninja-select fs" id="role" name="roles[]" multiple>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}"> {{ $role->name }} </option>
                    @endforeach
                </select>
            </div>

            <div class="form-floating mb-4">
                <input type="text" id="birthday" class="form-control datepicker" name="birthday" />
                <label class="form-label fs" for="birthday">Birthday</label>
            </div>
            <div class="form-floating mb-4">
                <select class="form-select fs" name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <label for="gender">Gender</label>
            </div>

            <div class="form-outline mb-4">
                <textarea class="form-control" id="address" rows="4" name="address"></textarea>
                <label class="form-label fs" for="address">Address</label>
            </div>
            <div class="form-floating mb-4">
                <input type="text" id="dateOfJoin" class="form-control datepicker" name="dateOfJoin" />
                <label class="form-label fs" for="dateOfJoin">Date Of Join</label>
            </div>
            <div class="mb-4">
                <label for="profile_img fs">Profile Image</label>
                <input type="file" class="form-control form-control-md" id="profile_img" name="profile_img">
                <div class="preview_img mt-2"></div>
            </div>
            <div class="form-floating mb-4">
                <select class="form-select fs" name="present">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <label for="gender fs">Is Present?</label>
            </div>

            <div class="form-outline mb-4">
                <input type="text" id="password" class="form-control" name="password" />
                <label class="form-label fs" for="password">Password</label>
            </div>

            <div class="form-outline mb-4">
                <input type="number" id="pincode" class="form-control" name="pincode" />
                <label class="form-label fs" for="pincode">Pin Code</label>
            </div>

            <div class="mb-2 col-md-6 mx-auto">
                <button type="submit" class="btn btn-secondary btn-block btn-sm">Confirm</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\StoreEmployeeRequest', '#create-form') !!}
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
                $('.preview_img').append(`<img src="${URL.createObjectURL(event.target.files[i])}" class="img-fluid me-2" width="100" />`);
            }
        })
    </script>
@endpush
