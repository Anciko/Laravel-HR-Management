@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <div class="card py-4 mb-4 text-start">
        <div class="d-md-flex justify-content-between">
            <div class="col-md-6 text-center">
                <div class="pt-3">
                    <img src="{{ $employee->profile_img_path() }}"
                        class="img-fluid img-thumbnail rounded-circle profile_img " alt="">
                </div>
                <div class="pt-4">
                    <h5>{{ $employee->name }}</h5>
                    <p class="text-muted mb-1">{{ $employee->employee_id }}</p>
                    <p class="text-muted mb-1">{{ $employee->department ? $employee->department->name : '?' }} </p>
                    @foreach ($employee->roles as $role)
                        <span class="badge badge-primary">{{ $role->name }}</span>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6 mt-4 align-self-center text-md-start text-center">
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

    <div class="card p-2">
        <a href="" class="btn btn-secondary btn-sm logout-btn"> <i class='bx bx-log-out-circle bx-sm align-middle me-1'></i>
            Logout</a>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.logout-btn').on('click', function(e) {
                e.preventDefault();

                swal({
                        text: "Are you sure you want to logout?",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                method: "POST",
                                url: `/logout`
                            }).done(function(res) {
                                window.location.reload();
                            })
                        } else {
                            swal("You are still log in!");
                        }
                    });
            })
        });
    </script>
@endpush
