@extends('layouts.app')

@section('title', 'Create Employee')

@section('content')
    <a href="{{ route('employee.index') }}" class="btn btn-secondary btn-sm mb-3">
        <i class='bx bx-left-arrow-circle bx-xs align-middle me-2'></i>
        Back
    </a>
    <div class="card p-4 mb-5">
        <form action="" method="POST">
            @csrf
            <div class="form-outline mb-4">
                <input type="email" id="employeeid" class="form-control" name="employeeid" />
                <label class="form-label fs" for="employeeid">Employee ID</label>
            </div>
            <div class="form-outline mb-4">
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
                <label class="form-label" for="address">Address</label>
            </div>
            <div class="form-floating mb-4">
                <input type="text" id="dateOfJoin" class="form-control datepicker" name="dateOfJoin" />
                <label class="form-label fs" for="dateOfJoin">Date Of Join</label>
            </div>
            <div class="form-floating mb-4">
                <select class="form-select fs" name="present">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <label for="gender">Is Present?</label>
            </div>
            <div class="mb-2">
                <button type="submit" class="btn btn-secondary btn-sm btn-block w-50 mx-auto">Confirm</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
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
    </script>
@endpush
