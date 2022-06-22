@extends('layouts.app')

@section('title', 'Salaries')

@section('content')
    @can('create_department')
        <a href="{{ route('salary.create') }}" class="btn btn-secondary btn-sm mb-3">
            <i class='bx bx-plus-circle bx-xs align-middle me-2'></i>Create Salary
        </a>
    @endcan
    <div class="card p-4 mb-5">
        <table class="table table-bordered Datatable myTable" style="width: 100%">
            <thead>
                <tr>
                    <th class="control no-search no-sort"></th>
                    <th class="text-center">Employee</th>
                    <th class="text-center">Month</th>
                    <th class="text-center">Year</th>
                    <th class="text-center">Amount (MMK)</th>
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
                ajax: '/salary/datatable/ssd',
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
                        data: 'month',
                        name: 'month',
                        class: 'text-center'
                    },
                    {
                        data: 'year',
                        name: 'year',
                        class: 'text-center'
                    },
                    {
                        data: 'amount',
                        name: 'amount',
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
                                url: `/salary/${id}`
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
