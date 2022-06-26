@extends('layouts.app')

@section('title', 'Create Project')

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
        <form action="{{ route('project.store') }}" method="POST" id="create-form" enctype="multipart/form-data">
            @csrf
            <div class="form-outline mb-4 mt-3">
                <input type="text" id="title" class="form-control" name="title" autofocus />
                <label class="form-label fs" for="title">Title</label>
            </div>
            <div class="form-outline mb-4">
                <textarea class="form-control" name="description" id="description" rows="4"></textarea>
                <label class="form-label" for="description">Description</label>
            </div>

            <div class="mb-4">
                <label for="project_img fs">Images</label>
                <input type="file" class="form-control form-control-md" id="project_img" name="images[]" multiple
                    accept="image/*">
                <div class="preview_img mt-2"></div>
            </div>

            <div class="mb-4">
                <label for="pdfs fs">PDF files</label>
                <input type="file" class="form-control form-control-md" id="pdfs" name="pdfs[]" multiple
                    accept="application/pdf">
            </div>

            <div class="form-floating mb-4">
                <input type="text" id="start_date" class="form-control datepicker" name="start_date" />
                <label class="form-label fs" for="start_date">Start Date</label>
            </div>

            <div class="form-floating mb-4">
                <input type="text" id="deadline" class="form-control datepicker" name="deadline" />
                <label class="form-label fs" for="deadline">Deadline</label>
            </div>

            <div class="form-group mb-4">
                <label for="leaders">Select leader or leaders</label>
                <select name="leaders[]" class="leader-select form-control" id="leaders" multiple>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}"> {{ $employee->name }} ({{ $employee->employee_id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="members">Select member or members</label>
                <select name="members[]" class="member-select form-control" id="members" multiple>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}"> {{ $employee->name }} ({{ $employee->employee_id }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-4">
                <select name="priority" class="form-select priority-select">
                    <option value=""></option>
                    <option value="high">High</option>
                    <option value="middle">Middle</option>
                    <option value="low">Low</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <select name="status" class="form-select status-select">
                    <option value=""></option>
                    <option value="pending">Pending</option>
                    <option value="on-progress">On Progress</option>
                    <option value="complete">Complete</option>
                </select>
            </div>

            <div class="mb-2 col-md-6 mx-auto">
                <button type="submit" class="btn btn-secondary btn-block btn-sm">Confirm</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\StoreProjectRequest', '#create-form') !!}
    <script>
        $(document).ready(function() {
            $('.datepicker').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                "drops": "up",
                "maxDate": moment(),
                "locale": {
                    "format": "YYYY-MM-DD"
                }
            });

            $('#project_img').on('change', function() {
                let file_length = document.getElementById('project_img').files.length;
                $('.preview_img').html("");
                for (let i = 0; i < file_length; i++) {
                    $('.preview_img').append(
                        `<img src="${URL.createObjectURL(event.target.files[i])}" class="img-fluid me-2" width="100" />`
                        );
                }
            })

            $(".priority-select").select2({
                placeholder: 'Select Priority'
            });
            $(".status-select").select2({
                placeholder: 'Select Status'
            });
            $(".leader-select").select2();
            $(".member-select").select2();
        });
    </script>
@endpush
