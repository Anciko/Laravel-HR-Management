@extends('layouts.app')

@section('title', 'Create Salary')

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
    <div class="card p-4 mb-5">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
            @endforeach
        @endif
        <form action="{{ route('salary.store') }}" method="POST" id="create-form">
            @csrf
            <div class="form-floating mb-4">
                <select class="form-select salary-select" id="user_id" name="user_id">
                    <option value=""></option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}"> {{ $employee->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-4">
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
            <div class="form-group mb-4">
                <select name="year" class="form-select year-select">
                    <option value=""></option>
                    @for ($i = 0; $i < 15; $i++)
                        <option value="{{ now()->subYears($i)->format('Y') }}" @if (now()->format('Y') == now()->subYears($i)->format('Y')) selected @endif>
                            {{ now()->subYears($i)->format('Y') }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-outline mb-4 mt-3">
                <input type="text" id="amount" class="form-control" name="amount" />
                <label class="form-label fs" for="year">Amount (MMK)</label>
            </div>

            <div class="mb-2 col-md-6 mx-auto">
                <button type="submit" class="btn btn-secondary btn-block btn-sm">Confirm</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\StoreSalaryRequest', '#create-form') !!}

    <script>
        $(document).ready(function() {
            $(".salary-select").select2({
                placeholder: '-- Please Choose Employee--'
            });
            $(".month-select").select2({
                placeholder: 'Month'
            });
            $(".year-select").select2({
                placeholder: 'Year'
            });
        })
    </script>
@endpush
