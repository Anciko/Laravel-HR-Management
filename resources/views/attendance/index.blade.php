@extends('layouts.app')

@section('title', 'Attendance (Employee)')

@section('content')
    @can('create_attendance')
        <a href="{{ route('attendance.create') }}" class="btn btn-secondary btn-sm mb-3">
            <i class='bx bx-plus-circle bx-xs align-middle me-2'></i>Create Attendance
        </a>
    @endcan
    <div class="card p-4 mb-5">
        <table class="table table-bordered Datatable myTable" style="width: 100%">
            <thead>
                <tr>
                    <th class="control no-search no-sort"></th>
                    <th class="text-center">Employee</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Check in time</th>
                    <th class="text-center">Check out time</th>
                    <th class="text-center hidden">Updated at</th>
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
                ajax: '/attendance/datatable/ssd',
                columns: [{
                        data: 'plus-icon',
                        name: 'plus-icon',
                        class: 'control'
                    },
                    {
                        data: 'user_id',
                        name: 'user_id',
                        class: 'text-center'
                    },
                    {
                        data: 'date',
                        name: 'date',
                        class: 'text-center'
                    },
                    {
                        data: 'check_in_time',
                        name: 'check_in_time',
                        class: 'text-center'
                    },
                    {
                        data: 'check_out_time',
                        name: 'check_out_time',
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
                    [2, "desc"]
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
                        'target': 2,
                        'visible': true
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
                                url: `/attendance/${id}`
                            }).done(function(res) {
                                console.log("deleted");
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
