@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content')
    <div class="card p-4 mb-5">
        <form action="{{ route('permission.update', $permission->id) }}" method="POST" id="update-form" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="form-outline mb-4 mt-3">
                <input type="text" id="name" class="form-control" name="name" value="{{ $permission->name }}" autofocus />
                <label class="form-label fs" for="name">Name</label>
            </div>
            <div class="mb-2 col-md-6 mx-auto">
                <button type="submit" class="btn btn-secondary btn-block btn-sm">Confirm</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\UpdatePermissionRequest', '#update-form') !!}
@endpush
