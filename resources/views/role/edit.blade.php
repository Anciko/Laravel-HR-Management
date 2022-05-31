@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
    <div class="card p-4 mb-5">
        <form action="{{ route('role.update', $role->id) }}" method="POST" id="update-form" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="form-outline mb-4 mt-3">
                <input type="text" id="name" class="form-control" name="name" value="{{ $role->name }}" autofocus />
                <label class="form-label fs" for="name">Name</label>
            </div>

            <p>Permission</p>
            <div class="row mb-3">
                @foreach ($permissions as $permission)
                    <div class="col-md-3 col-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $permission->name }}"
                                name="permissions[]" id="{{ $permission->name }}"
                                @if (in_array($permission->id, $old_permissions)) checked @endif />
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
    {!! JsValidator::formRequest('App\Http\Requests\UpdateRoleRequest', '#update-form') !!}
@endpush
