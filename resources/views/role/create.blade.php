@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
    <div class="card p-4 mb-5">
        <form action="{{ route('role.store') }}" method="POST" id="create-form" autocomplete="off">
            @csrf
            <div class="form-outline mb-4 mt-3">
                <input type="text" id="name" class="form-control" name="name" autofocus />
                <label class="form-label fs" for="name">Name</label>
            </div>

            <p>Permission</p>
            <div class="row mb-3">
                @foreach ($permissions as $permission)
                    <div class="col-md-3 col-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $permission->name }}"
                                name="permissions[]" id="{{ $permission->name }}" />
                            <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->name }}</label>
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="mb-2 col-md-6 mx-auto">
                <button type="submit" class="btn btn-secondary btn-block btn-sm">Confirm</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\StoreRoleRequest', '#create-form') !!}
@endpush
