@extends('layouts.app')

@section('title', 'Attendance')
@section('styles')
    <style>
        .select2-container--default .select2-selection--single {
            height: 34px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-top: 3px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 4px;
            right: 1px;
            width: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="card p-4">
        <div class="text-center">
            <img src="{{ asset('image/scan.png') }}" alt="Scan" class="img-fluid" width="200">
            <p class="text-muted">Please Scan Attendance QR</p>
        </div>

        <div class="text-center">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-secondary" data-mdb-toggle="modal" data-mdb-target="#scanModal">
                Scan QR Code
            </button>

            <!-- Modal -->
            <div class="modal fade" id="scanModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Scan Your QR Code</h5>
                            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <video id="video" width="400" height="300"></video>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-4 mt-4">
        <div class="mb-4">
            <div class="row ">
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="month" class="form-select month-select">
                            <option value=""></option>
                            <option value="01" @if (now()->format('m') == '01') selected @endif>Jan</option>
                            <option value="02" @if (now()->format('m') == '02') selected @endif>Feb</option>
                            <option value="03" @if (now()->format('m') == '03') selected @endif>Mar</option>
                            <option value="04" @if (now()->format('m') == '04') selected @endif>Apr</option>
                            <option value="05" @if (now()->format('m') == '05') selected @endif>May</option>
                            <option value="06" @if (now()->format('m') == '06') selected @endif>Jun</option>
                            <option value="07" @if (now()->format('m') == '07') selected @endif>Jul</option>
                            <option value="08" @if (now()->format('m') == '08') selected @endif>Aug</option>
                            <option value="09" @if (now()->format('m') == '09') selected @endif>Sep</option>
                            <option value="10" @if (now()->format('m') == '10') selected @endif>Oct</option>
                            <option value="11" @if (now()->format('m') == '11') selected @endif>Nov</option>
                            <option value="12" @if (now()->format('m') == '12') selected @endif>Dec</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="year" class="form-select year-select">
                            <option value=""></option>
                            @for ($i = 0; $i < 5; $i++)
                                <option value="{{ now()->subYears($i)->format('Y') }}"
                                    @if (now()->format('Y') ==
                                        now()->subYears($i)->format('Y')) selected @endif>
                                    {{ now()->subYears($i)->format('Y') }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-secondary  btn-block search-btn"><i class="fas fa-search"></i> Search</button>
                </div>
            </div>
        </div>
        <h5 class="mb-0">Payroll</h5>
        <div class="payroll-overview-table mb-4">

        </div>
        <h5 class="mb-0">Attendace Overview</h5>
        <div class="attendance-overview-table mb-4">

        </div>
        <h5>Attendance Table</h5>
        <table class="table table-bordered Datatable myTable" style="width: 100%">
            <thead>
                <tr>
                    <th class="control no-search no-sort"></th>
                    <th class="text-center">Employee</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Check in time</th>
                    <th class="text-center">Check out time</th>
                    <th class="text-center hidden">Updated at</th>
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
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            $(".month-select").select2({
                placeholder: '--Please Choose Month--'
            });
            $(".year-select").select2({
                placeholder: '--Please Choose Year--'
            });
            var videoElem = document.getElementById('video');
            let qrScanner = new QrScanner(
                videoElem,
                function(result) {
                    console.log('decoded qr code:', result);
                    if (result) {
                        $('#scanModal').modal('hide');
                        qrScanner.stop();

                        $.ajax({
                            url: '/attendance-scan/scan-store',
                            method: 'POST',
                            data: {
                                'hashed_value': result.data,
                            },
                            success: function(res) {
                                if (res.status == 'success') {
                                    Toast.fire({
                                        icon: 'success',
                                        title: res.message
                                    });
                                } else {
                                    Toast.fire({
                                        icon: 'error',
                                        title: res.message
                                    });
                                }
                            }
                        })
                    }
                }, {
                    DetailedScanResult: true
                }
            );

            $('#scanModal').on('shown.bs.modal', function(event) {
                qrScanner.start();
            });
            $('#scanModal').on('hidden.bs.modal', function(event) {
                qrScanner.stop();
            });

            var table = $('.Datatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                mark: true,
                ajax: '/myattendance/datatable/ssd',
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

            function attendanceOverviewTable() {
                var month = $('.month-select').val();
                var year = $('.year-select').val();
                $.ajax({
                    url: `/myattendance/overview-table?month=${month}&year=${year}`,
                    method: 'GET',
                    success: function(res) {
                        $('.attendance-overview-table').html(res);
                    }
                });
                table.ajax.url(`/myattendance/datatable/ssd?month=${month}&year=${year}`).load();
            }

            function payRollOverviewTable() {
                var employee_name = $('.employee_name').val();
                var month = $('.month-select').val();
                var year = $('.year-select').val();
                $.ajax({
                    url: `/mypayroll/overview-table?month=${month}&year=${year}`,
                    method: 'GET',
                    success: function(res) {
                        $('.payroll-overview-table').html(res);
                    }
                });
            }

            payRollOverviewTable();
            attendanceOverviewTable();

            $('.search-btn').on('click', function(event) {
                event.preventDefault();
                attendanceOverviewTable();
                payRollOverviewTable();

            });
        });
    </script>
@endpush
