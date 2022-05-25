@extends('layouts.app')

@section('title', 'Employee\'s Details')

@section('content')
    <a href="{{ route('employee.index') }}" class="btn btn-secondary btn-sm mb-3">
        <i class='bx bx-left-arrow-circle bx-xs align-middle me-2'></i>
        Back
    </a>
    <div class="card p-4 mb-5 text-start">
        <div class="row">
            <div class="col-md-6 d-flex gap-3">
                <div>
                    <img src="{{ $employee->profile_img_path() }}" class="img-fluid rounded-circle profile_img" alt="">
                </div>
                <div class="pt-4">
                    <h5>{{ $employee->name }}</h5>
                    <p class="text-muted mb-1">{{ $employee->employee_id }}</p>
                    <p class="text-muted mb-1">{{ $employee->department ? $employee->department->name : '?' }} </p>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div class="mb-1">
                    <span class="mb-0"><i class='bx bx-phone me-2 align-middle'></i>Phone</span> -
                    <span class="text-muted"> {{ $employee->phone }} </span>
                </div>

                <div class="mb-1">
                    <span class="mb-0"><i class='bx bx-envelope me-2 align-middle'></i>Email</span> -
                    <span class=" text-muted  "> {{ $employee->email }} </span>
                </div>

                <div class="mb-1">
                    <span class="mb-0"><i class='bx bx-id-card me-2 align-middle'></i>NRC number</span> -
                    <span class="text-muted  "> {{ $employee->nrc_number ?? '?' }} </span>
                </div>

                <div class="mb-1">
                    <span class="mb-0"><i class='bx bx-leaf me-2 align-middle'></i>Gender</span> -
                    <span class="text-muted  "> {{ $employee->gender ?? '?' }} </span>
                </div>

                <div class="mb-1">
                    <span class="mb-0"><i class='bx bx-happy me-2 align-middle'></i>Birthday</span> -
                    <span class="text-muted  "> {{ $employee->birthday ?? '?' }} </span>
                </div>

                <div class="mb-1">
                    <span class="mb-0"><i class='bx bx-location-plus me-2 align-middle'></i>Address</span> -
                    <span class="text-muted  "> {{ $employee->address ?? '?' }} </span>
                </div>

                <div class="mb-1">
                    <span class="mb-0"><i class='bx bx-pyramid me-2 align-middle'></i>Is Present</span> -
                    <span class="text-muted ">
                        @if ($employee->is_present)
                            <span class="badge badge-success badge-pill">Presnet</span>
                        @else
                            <span class="badge badge-danger badge-pill">Leave</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
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
