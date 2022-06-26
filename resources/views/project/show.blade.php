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

        ul {
            list-style: none;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex gap-4">
        <div class="col-md-9">
            <div class="col-12 mb-4">
                <div class="card p-3">
                    <h5 class="text-dark">{{ $project->title }}</h5>
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
                            <span class="bg-dark rounded-pill">{{ $project->priority }}</span>
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
                    <span>
                        {{ $project->description }}
                    </span>
                </div>
            </div>

            <div class="col-12 mb-3">
                <div class="card p-2">
                    <p class="text-dark">Images</p>
                    <div id="images" class="d-flex flex-wrap">
                        @if ($project->images)
                            @foreach ($project->images as $image)
                                <img src="{{ asset('storage/project/' . $image) }}" alt=""
                                    class="img-fluid detail-project-img">
                            @endforeach
                        @endif
                        {{-- ..... --}}
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="card p-2">
                    <p class="text-dark">Files</p>
                    <div class="d-flex flex-wrap gap-2">
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
        <div class="col-md-3">
            <div class="col-12 mb-3">
                <div class="card p-3">
                    <h5 class="text-dark">Project Leaders</h5>
                    <div id="leaders" class="d-flex flex-wrap gap-2">
                        @if ($project->leaders)
                            @foreach ($project->leaders as $leader)
                                <img src="{{ $leader->profile_img_path() }}" alt=""
                                    class="img-fluid img-thumbnail" width="75" height="75">
                            @endforeach
                        @endif
                        </d>
                    </div>
                </div>

                <div class="col-12 mb-3 mt-3">
                    <div class="card p-3">
                        <h5 class="text-dark">Project Members</h5>
                        <div id="members" class="d-flex flex-wrap gap-2">
                            @if ($project->members)
                                @foreach ($project->members as $member)
                                    <img src="{{ $member->profile_img_path() }}" alt=""
                                        class="img-fluid img-thumbnail" width="75" height="75">
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
                const images = new Viewer(document.getElementById('images'));
                const leaders = new Viewer(document.getElementById('leaders'));
                const members = new Viewer(document.getElementById('members'));


                // Then show the image by clicking it.
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



            })
        </script>
    @endpush
