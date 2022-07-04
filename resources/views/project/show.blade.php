@extends('layouts.app')

@section('title', 'Project Detail')

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

        .select2-container{
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                <p class="mb-0"><i class="fa-solid fa-bars me-2"></i>Pending</p>
                            </div>
                            <div class="card-body alert-warning p-3">
                                <div class="card p-2 mb-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="fss">User CRUD ရေးရန်</span>
                                        <span><i class="fa-solid fa-ellipsis-vertical"></i></span>
                                    </div>
                                    <div class="fss">
                                        <i class="fa-solid fa-clock"></i> <span>Sep 16</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fss badge bg-danger">High</span>
                                        <span>
                                            <img src="{{ asset('image/ninja.png') }}" alt=""
                                                style="width:40px; height:40px;object-fit:cover;">
                                        </span>
                                    </div>
                                </div>

                                <div class="card p-2 mb-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="fss">User CRUD ရေးရန်</span>
                                        <span><i class="fa-solid fa-ellipsis-vertical"></i></span>
                                    </div>
                                    <div class="fss">
                                        <i class="fa-solid fa-clock"></i> <span>Sep 16</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fss badge bg-danger">High</span>
                                        <span>
                                            <img src="{{ asset('image/ninja.png') }}" alt=""
                                                style="width:40px; height:40px;object-fit:cover;">
                                        </span>
                                    </div>
                                </div>

                                <button class="btn btn-block bg-white pending-btn"><i class="fa-solid fa-plus me-2"></i>Add
                                    Task</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <p class="mb-0"><i class="fa-solid fa-bars me-2"></i>In-porgress</p>
                            </div>
                            <div class="card-body p-3 alert-info">
                                <div class="card p-2 mb-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="fss">User CRUD ရေးရန်</span>
                                        <span><i class="fa-solid fa-ellipsis-vertical"></i></span>
                                    </div>
                                    <div class="fss">
                                        <i class="fa-solid fa-clock"></i> <span>Sep 16</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fss badge bg-danger">High</span>
                                        <span>
                                            <img src="{{ asset('image/ninja.png') }}" alt=""
                                                style="width:40px; height:40px;object-fit:cover;">
                                        </span>
                                    </div>
                                </div>
                                <div class="card p-2 mb-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="fss">User CRUD ရေးရန်</span>
                                        <span><i class="fa-solid fa-ellipsis-vertical"></i></span>
                                    </div>
                                    <div class="fss">
                                        <i class="fa-solid fa-clock"></i> <span>Sep 16</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fss badge bg-danger">High</span>
                                        <span>
                                            <img src="{{ asset('image/ninja.png') }}" alt=""
                                                style="width:40px; height:40px;object-fit:cover;">
                                        </span>
                                    </div>
                                </div>
                                <button class="btn btn-block bg-white progress-btn"><i class="fa-solid fa-plus me-2"></i>Add
                                    Task</button>
                            </div>


                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <p class="mb-0"><i class="fa-solid fa-bars me-2"></i>Complete</p>
                            </div>
                            <div class="card-body alert-success">
                                <div class="card p-2 mb-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="fss">User CRUD ရေးရန်</span>
                                        <span><i class="fa-solid fa-ellipsis-vertical"></i></span>
                                    </div>
                                    <div class="fss">
                                        <i class="fa-solid fa-clock"></i> <span>Sep 16</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fss badge bg-danger">High</span>
                                        <span>
                                            <img src="{{ asset('image/ninja.png') }}" alt=""
                                                style="width:40px; height:40px;object-fit:cover;">
                                        </span>
                                    </div>
                                </div>
                                <button class="btn btn-block bg-white complete-btn"><i
                                        class="fa-solid fa-plus me-2"></i>Add Task</button>
                            </div>


                        </div>
                    </div>
                </div>
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

                        </d>
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

                $(document).on('click', '.pending-btn', function(e) {
                    e.preventDefault();
                    var member_task_option = '';

                    leaders.forEach(function(leader) {
                        member_task_option += `<option value="${leader.id}"> ${leader.name} (${leader.employee_id})  </option>`;
                    });

                    members.forEach(function(member) {
                        member_task_option += `<option value="${member.id}"> ${member.name} (${member.employee_id})  </option>`;
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
                                    <label class="form-label fs" for="dead_line">Deadline</label>
                                    <input type="text" id="dead_line" class="form-control datepicker" name="dead_line" />
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
                                    console.log(res);
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

            })
        </script>
    @endpush
