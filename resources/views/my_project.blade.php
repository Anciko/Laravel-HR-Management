@extends('layouts.app')

@section('title', 'My Project')

@section('styles')
    <style>
        .profile-img {
            width: 35px;
            height: 35px;
            border-radius: 10%;
            border: 1px solid #ddd;
            padding: 2px;
        }
    </style>
@endsection

@section('content')
    <div class="card p-4 mb-5">
        <table class="table table-bordered Datatable myTable" style="width: 100%">
            <thead>
                <tr>
                    <th class="control no-search no-sort"></th>
                    <th class="text-center">Title</th>
                    <th class="text-center">Description</th>
                    <th class="text-center no-sort">Leaders</th>
                    <th class="text-center no-sort">Members</th>
                    <th class="text-center">Start__Date</th>
                    <th class="text-center">Deadline</th>
                    <th class="text-center">Priority</th>
                    <th class="text-center">Status</th>
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
                ajax: '/myproject/datatable/ssd',
                columns: [{
                        data: 'plus-icon',
                        name: 'plus-icon',
                        class: 'control'
                    },
                    {
                        data: 'title',
                        name: 'title',
                        class: 'text-center'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        class: 'text-center'
                    },
                    {
                        data: 'leaders',
                        name: 'leaders',
                        class: 'text-center'
                    },
                    {
                        data: 'members',
                        name: 'members',
                        class: 'text-center'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                        class: 'text-center'
                    },
                    {
                        data: 'deadline',
                        name: 'deadline',
                        class: 'text-center'
                    },
                    {
                        data: 'priority',
                        name: 'priority',
                        class: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        class: 'text-center'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        class: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        class: 'text-center'
                    }
                ],
                order: [
                    [9, 'desc']
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
                                url: `/project/${id}`
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
