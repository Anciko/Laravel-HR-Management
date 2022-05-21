@extends('layouts.app')

@section('title', 'Employees')

@section('content')
    <a href="{{ route('employee.create') }}" class="btn btn-secondary btn-sm mb-3">
        <i class='bx bx-plus-circle bx-xs align-middle me-2'></i>Create Employee
    </a>
    <div class="card p-4 ">
        <table class="table table-bordered Datatable">
            <thead>
                <tr>
                    <th class="text-center">Employee ID</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center ">Email</th>
                    <th class="text-center">Department</th>
                    <th class="text-center">Is Present</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.Datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/employee/datatable/ssd',
                columns: [{
                        data: 'employee_id',
                        name: 'employee_id',
                        class: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        class: 'text-center'
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        class: 'text-center'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        class: 'text-center'
                    },
                    {
                        data: 'department',
                        name: 'department',
                        class: 'text-center'
                    },
                    {
                        data: 'is_present',
                        name: 'is_present',
                        class: 'text-center'
                    }
                ]
            });
        });
    </script>
@endpush
