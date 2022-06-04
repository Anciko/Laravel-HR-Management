@extends('layouts.app')

@section('title', 'Company Setting')

@section('content')
    <div class="card p-4 mb-5">
        <div class="row">
            <div class="col-md-6">
                <p class="text-dark">Company Name</p>
                <p class="text-muted">{{ $company_setting->company_name }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-dark">Company Email</p>
                <p class="text-muted">{{ $company_setting->company_email }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-dark">Company Phone</p>
                <p class="text-muted">{{ $company_setting->company_phone }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-dark">Company Address</p>
                <p class="text-muted">{{ $company_setting->company_address }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-dark">Office Start Time</p>
                <p class="text-muted">{{ $company_setting->office_start_time }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-dark">Office End Time</p>
                <p class="text-muted">{{ $company_setting->office_end_time }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-dark">Break Start Time</p>
                <p class="text-muted">{{ $company_setting->break_start_time }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-dark">Break End Time</p>
                <p class="text-muted">{{ $company_setting->break_end_time }}</p>
            </div>
        </div>
        <div class="mt-4 text-center">
            <a href="{{ route('company-setting.edit', 1) }}" class="btn btn-warning"> <i class="fa fa-edit me-2"></i> Edit
                Company Setting</a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'Continue'
            });
        @endif
    </script>
@endpush
