@extends('layouts.app')

@section('title', 'Create Department')

@section('content')
    <div class="card p-4 mb-5">
        <form action="{{ route('department.store') }}" method="POST" id="create-form">
            @csrf
            <div class="form-outline mb-4 mt-3">
                <input type="text" id="name" class="form-control" name="name" />
                <label class="form-label fs" for="name">Name</label>
            </div>
            <div class="mb-2 col-md-6 mx-auto">
                <button type="submit" class="btn btn-secondary btn-block btn-sm">Confirm</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\StoreDepartmentRequest', '#create-form') !!}
@endpush
