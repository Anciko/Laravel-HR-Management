@extends('layouts.app')

@section('title', 'My Project Detail')

@section('styles')
    <style>
        .detail-project-img {
            width: 50px;
            height: 50px;
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 2px;
        }

        .pdf-icn {
            font-size: 45px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .pdf-fs {
            font-size: 13px;
        }

        .fss {
            font-size: 12px !important;
        }

        .select2-container {
            z-index: 999999;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="col-12 mb-4">
                <div class="card p-3">
                    <h5 class="text-dark ">{{ $project->title }}</h5>
                    <p>
                        Start Date - <span class="text-muted">{{ $project->start_date }}</span>,
                        Deadline - <span class="text-muted">{{ $project->deadline }}</span>
                    </p>
                    <p>
                        Priority :
                        @if ($project->priority == 'high')
                            <span class="badge rounded-pill bg-danger"> {{ $project->priority }} </span>
                        @elseif ($project->priority == 'middle')
                            <span class="badge rounded-pill bg-warning"> {{ $project->priority }} </span>
                        @else
                            <span class="badge bg-dark rounded-pill">{{ $project->priority }}</span>
                        @endif
                    </p>
                    <p>
                        Status :
                        @if ($project->status == 'pending')
                            <span class="badge badge-warning rounded-pill"> {{ $project->status }} </span>
                        @elseif ($project->status == 'on-progress')
                            <span class="badge badge-info rounded-pill"> {{ $project->status }} </span>
                        @else
                            <span class="badge badge-success rounded-pill">{{ $project->status }}</span>
                        @endif
                    </p>
                    <p class="text-dark mb-0">Description <i class="fa-solid fa-info-circle text-info"></i> </p>
                    <p>
                        {{ $project->description }}
                    </p>

                    <div class="mb-3">
                        <p class="mb-1">Leaders</p>
                        <div id="leaders">
                            @if ($project->leaders)
                                @foreach ($project->leaders as $leader)
                                    <img src="{{ $leader->profile_img_path() }}" alt=""
                                        class="img-fluid img-thumbnail" style="width: 75px; height: 75px;object-fit:cover;">
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div>
                        <p class="mb-1">Members</p>
                        <div id="members">
                            @if ($project->members)
                                @foreach ($project->members as $member)
                                    <img src="{{ $member->profile_img_path() }}" alt=""
                                        class="img-fluid img-thumbnail" style="width: 75px; height: 75px;object-fit:cover;">
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-3">
                <h5>Tasks</h5>
                <div class="tasks_data"></div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="col-12 mb-3">
                <div class="card p-3">
                    <h5 class="text-dark">Images</h5>
                    <div id="images" class="d-flex flex-wrap gap-2">
                        @if ($project->images)
                            @foreach ($project->images as $image)
                                <img src="{{ asset('storage/project/' . $image) }}" alt=""
                                    class="img-fluid detail-project-img">
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-12 mb-3 mt-3">
                <div class="card p-3">
                    <h5 class="text-dark">PDF files</h5>
                    <div id="members" class="d-flex flex-wrap gap-2">
                        @if ($project->files)
                            @foreach ($project->files as $file)
                                <a href="{{ asset('storage/project/' . $file) }}" class="pdf-icn px-2">
                                    <i class="fa-solid fa-file-pdf"></i>
                                    <p class="pdf-fs m-0">File 1</p>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            var project_id = "{{ $project->id }}";
            var members = @json($project->members);
            var leaders = @json($project->leaders);

            new Viewer(document.getElementById('images'));
            new Viewer(document.getElementById('leaders'));
            new Viewer(document.getElementById('members'));

            function taskData() {
                $.ajax({
                    method: "GET",
                    url: `/tasks-data?project_id=${project_id}`,
                    success: function(res) {
                        $('.tasks_data').html(res);
                    }
                })
            }
            taskData();

            $(document).on('click', '.pending-btn', function(e) {
                e.preventDefault();
                var member_task_option = '';

                leaders.forEach(function(leader) {
                    member_task_option +=
                        `<option value="${leader.id}"> ${leader.name} (${leader.employee_id})  </option>`;
                });

                members.forEach(function(member) {
                    member_task_option +=
                        `<option value="${member.id}"> ${member.name} (${member.employee_id})  </option>`;
                });


                Swal.fire({
                    title: "Add Pending Task",
                    confirmButtonText: 'Confirm',
                    html: `
                            <form  class="text-start" id="pending_task_form">
                                <input type="hidden" name="project_id" value="${project_id}" />
                                <input type="hidden" name="status" value="pending" />
                                <div class="form-group mb-4 mt-3">
                                    <input type="text" id="title" class="form-control" name="title" placeholder="Title" autofocus />
                                </div>
                                <div class="form-group mb-4">
                                    <textarea class="form-control" name="description" id="description" rows="4" placeholder="Description"></textarea>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label fs" for="start_date">Start Date</label>
                                    <input type="text" id="start_date" class="form-control datepicker" name="start_date" />
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fs" for="deadline">Deadline</label>
                                    <input type="text" id="deadline" class="form-control datepicker" name="deadline" />
                                </div>
                                <div class=" mb-4">
                                    <label class="form-label fs">Member</label>
                                    <select name="members[]" class="form-control member-select" multiple>
                                        ${member_task_option}
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label fs" for="priority">Priority</label>
                                    <select name="priority" class="form-select priority-select">
                                        <option value="high">High</option>
                                        <option value="middle">Middle</option>
                                        <option value="low">Low</option>
                                    </select>
                                </div>
                            </form>
                        `
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form_data = $("#pending_task_form").serialize();

                        $.ajax({
                            url: '/task',
                            method: 'POST',
                            data: form_data,
                            success: function(res) {
                                taskData();
                            }
                        })
                    }
                })
                $(".member-select").select2();

                $('.datepicker').daterangepicker({
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "autoApply": true,
                    "drops": "up",
                    "locale": {
                        "format": "YYYY-MM-DD"
                    }
                });
            })

            $(document).on('click', '.progress-btn', function(e) {
                e.preventDefault();
                var member_task_option = '';

                leaders.forEach(function(leader) {
                    member_task_option +=
                        `<option value="${leader.id}"> ${leader.name} (${leader.employee_id})  </option>`;
                });

                members.forEach(function(member) {
                    member_task_option +=
                        `<option value="${member.id}"> ${member.name} (${member.employee_id})  </option>`;
                });


                Swal.fire({
                    title: "Add Progress Task",
                    confirmButtonText: 'Confirm',
                    html: `
                            <form  class="text-start" id="progress_task_form">
                                <input type="hidden" name="project_id" value="${project_id}" />
                                <input type="hidden" name="status" value="in_progress" />
                                <div class="form-group mb-4 mt-3">
                                    <input type="text" id="title" class="form-control" name="title" placeholder="Title" autofocus />
                                </div>
                                <div class="form-group mb-4">
                                    <textarea class="form-control" name="description" id="description" rows="4" placeholder="Description"></textarea>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label fs" for="start_date">Start Date</label>
                                    <input type="text" id="start_date" class="form-control datepicker" name="start_date" />
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fs" for="deadline">Deadline</label>
                                    <input type="text" id="deadline" class="form-control datepicker" name="deadline" />
                                </div>
                                <div class=" mb-4">
                                    <label class="form-label fs">Member</label>
                                    <select name="members[]" class="form-control member-select" multiple>
                                        ${member_task_option}
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label fs" for="priority">Priority</label>
                                    <select name="priority" class="form-select priority-select">
                                        <option value="high">High</option>
                                        <option value="middle">Middle</option>
                                        <option value="low">Low</option>
                                    </select>
                                </div>
                            </form>
                        `
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form_data = $("#progress_task_form").serialize();

                        $.ajax({
                            url: '/task',
                            method: 'POST',
                            data: form_data,
                            success: function(res) {
                                taskData();
                            }
                        })
                    }
                })
                $(".member-select").select2();

                $('.datepicker').daterangepicker({
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "autoApply": true,
                    "drops": "up",
                    "locale": {
                        "format": "YYYY-MM-DD"
                    }
                });
            })

            $(document).on('click', '.complete-btn', function(e) {
                e.preventDefault();
                var member_task_option = '';

                leaders.forEach(function(leader) {
                    member_task_option +=
                        `<option value="${leader.id}"> ${leader.name} (${leader.employee_id})  </option>`;
                });

                members.forEach(function(member) {
                    member_task_option +=
                        `<option value="${member.id}"> ${member.name} (${member.employee_id})  </option>`;
                });


                Swal.fire({
                    title: "Add Complete Task",
                    confirmButtonText: 'Confirm',
                    html: `
                            <form  class="text-start" id="complete_task_form">
                                <input type="hidden" name="project_id" value="${project_id}" />
                                <input type="hidden" name="status" value="complete" />
                                <div class="form-group mb-4 mt-3">
                                    <input type="text" id="title" class="form-control" name="title" placeholder="Title" autofocus />
                                </div>
                                <div class="form-group mb-4">
                                    <textarea class="form-control" name="description" id="description" rows="4" placeholder="Description"></textarea>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label fs" for="start_date">Start Date</label>
                                    <input type="text" id="start_date" class="form-control datepicker" name="start_date" />
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fs" for="deadline">Deadline</label>
                                    <input type="text" id="deadline" class="form-control datepicker" name="deadline" />
                                </div>
                                <div class=" mb-4">
                                    <label class="form-label fs">Member</label>
                                    <select name="members[]" class="form-control member-select" multiple>
                                        ${member_task_option}
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label fs" for="priority">Priority</label>
                                    <select name="priority" class="form-select priority-select">
                                        <option value="high">High</option>
                                        <option value="middle">Middle</option>
                                        <option value="low">Low</option>
                                    </select>
                                </div>
                            </form>
                        `
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form_data = $("#complete_task_form").serialize();

                        $.ajax({
                            url: '/task',
                            method: 'POST',
                            data: form_data,
                            success: function(res) {
                                taskData();
                            }
                        })
                    }
                })
                $(".member-select").select2();

                $('.datepicker').daterangepicker({
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "autoApply": true,
                    "drops": "up",
                    "locale": {
                        "format": "YYYY-MM-DD"
                    }
                });
            })

            $(document).on('click', '.edit_pending_task_btn', function(e) {
                e.preventDefault();

                var task = JSON.parse(atob($(this).data('task')));
                var task_members = JSON.parse(atob($(this).data('task-members')));

                var member_task_option = '';
                leaders.forEach(function(leader) {
                    member_task_option +=
                        `<option value="${leader.id}" ${(task_members.includes(leader.id) ? 'selected': '' )} > ${leader.name} (${leader.employee_id})  </option>`;
                });
                members.forEach(function(member) {
                    member_task_option +=
                        `<option value="${member.id}" ${(task_members.includes(member.id) ? 'selected': '')}> ${member.name} (${member.employee_id})  </option>`;
                });

                Swal.fire({
                    title: "Edit Pending Task",
                    confirmButtonText: 'Confirm',
                    html: `
                            <form  class="text-start" id="edit_task_form">
                                <input type="hidden" name="project_id" value="${project_id}" />
                                <input type="hidden" name="status" value="pending" />
                                <div class="form-group mb-4 mt-3">
                                    <input type="text" id="title" class="form-control" name="title" placeholder="Title" value="${task.title}" autofocus />
                                </div>
                                <div class="form-group mb-4">
                                    <textarea class="form-control" name="description" id="description" rows="4" placeholder="Description"> ${task.description} </textarea>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label fs" for="start_date">Start Date</label>
                                    <input type="text" id="start_date" class="form-control datepicker" name="start_date" value="${task.start_date}" />
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fs" for="deadline">Deadline</label>
                                    <input type="text" id="deadline" class="form-control datepicker" name="deadline"
                                     value="${task.deadline}" />
                                </div>
                                <div class=" mb-4">
                                    <label class="form-label fs">Member</label>
                                    <select name="members[]" class="form-control member-select" multiple>
                                        ${member_task_option}
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label fs" for="priority">Priority</label>
                                    <select name="priority" class="form-select priority-select">
                                        <option value="high" ${(task.priority == 'high' ? 'selected' : '')} >High</option>
                                        <option value="middle" ${(task.priority == 'middle' ? 'selected' : '')} >Middle</option>
                                        <option value="low" ${(task.priority == 'low' ? 'selected' : '')}>Low</option>
                                    </select>
                                </div>
                            </form>
                        `
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form_data = $("#edit_task_form").serialize();

                        $.ajax({
                            url: `/task/${task.id}`,
                            type: 'PUT',
                            data: form_data,
                            success: function(res) {
                                taskData();
                            }
                        })
                    }
                })
                $(".member-select").select2();

                $('.datepicker').daterangepicker({
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "autoApply": true,
                    "drops": "up",
                    "locale": {
                        "format": "YYYY-MM-DD"
                    }
                });
            })

            $(document).on('click', '.delete_task_btn', function(e) {
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
                                url: `/task/${id}`
                            }).done(function(res) {
                                taskData();
                            })
                        } else {
                            swal("Your imaginary file is safe!");
                        }
                    });
            })

        })
    </script>
@endpush
