@extends('layouts.app')

@section('title', 'Payroll')
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
    <div class="card p-4 mt-4">
        <h5>Payroll Records</h5>
        <div class="mb-3">
            <div class="row ">
                <div class="col-md-3">
                    <input type="text" class="form-control employee_name" placeholder="Employee" name="employee_name">
                </div>
                <div class="col-md-3">
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
                <div class="col-md-3">
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
                <div class="col-md-3">
                    <button class="btn btn-secondary  btn-block search-btn"><i class="fas fa-search"></i> Search</button>
                </div>
            </div>

            <div class="payroll-overview-table">

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                $(".month-select").select2({
                    placeholder: '--Please Choose Month--'
                });
                $(".year-select").select2({
                    placeholder: '--Please Choose Year--'
                });


                payRollOverviewTable();

                function payRollOverviewTable() {
                    var employee_name = $('.employee_name').val();
                    var month = $('.month-select').val();
                    var year = $('.year-select').val();
                    $.ajax({
                        url: `/payroll/overview-table?employee_name=${employee_name}&month=${month}&year=${year}`,
                        method: 'GET',
                        success: function(res) {
                            $('.payroll-overview-table').html(res);
                        }
                    });
                }

                $('.search-btn').on('click', function(event) {
                    event.preventDefault();
                    attendanceOverviewTable();
                });
            })
        });
    </script>
@endpush
