@extends('layouts.app')

@section('title', 'Employees')

@section('content')
    @can('create_employee')
        <a href="{{ route('employee.create') }}" class="btn btn-secondary btn-sm mb-3">
            <i class='bx bx-plus-circle bx-xs align-middle me-2'></i>Create Employee
        </a>
    @endcan
    <div class="card p-4 mb-5">
        <table class="table  table-bordered Datatable myTable" style="width: 100%">
            <thead>
                <tr>
                    <th class=" control no-search no-sort"></th>
                    <th class="text-center no-sort"></th>
                    <th class="text-center">Employee ID</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center ">Email</th>
                    <th class="text-center">Department</th>
                    <th class="text-center">Roles</th>
                    <th class="text-center hidden">Is Present</th>
                    <th class="text-center">Updated at</th>
                    <th class="text-center no-sort">Action</th>
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
            var table = $('.Datatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                mark: true,
                ajax: '/employee/datatable/ssd',
                columns: [{
                        data: 'plus-icon',
                        name: 'plus-icon',
                        class: 'control'
                    },
                    {
                        data: 'profile_img',
                        name: 'profile_img',
                        class: 'text-center'
                    },
                    {
                        data: 'employee_id',
                        name: 'employee_id',
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
                        data: 'department_name',
                        name: 'department_name',
                        class: 'text-center'
                    },
                    {
                        data: 'role_name',
                        name: 'role_name',
                        class: 'text-center'
                    },
                    {
                        data: 'is_present',
                        name: 'is_present',
                        class: 'text-center'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        class: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                "order": [
                    [8, "desc"]
                ],
                columnDefs: [{
                        'target': 0,
                        'class': 'control'
                    },
                    {
                        'target': 'no-search',
                        'searchable': false
                    },
                    {
                        'target': 'no-sort',
                        'orderable': false
                    },
                    {
                        'target': 'hidden',
                        'visible': false
                    },
                    {
                        'target': 8,
                        'visible': false,
                        'searchable': true,
                    }
                ],
            });
            new $.fn.dataTable.FixedHeader(table);

            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                swal({
                        text: "Are you sure you want to delete?",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                method: "DELETE",
                                url: `/employee/${id}`
                            }).done(function(res) {
                                table.ajax.reload();
                            })
                        } else {
                            swal("Your imaginary file is safe!");
                        }
                    });
            })


            @if (session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'Continue'
                });
            @endif

        });
    </script>
@endpush
