<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <p class="mb-0"><i class="fa-solid fa-bars me-2"></i>Pending</p>
            </div>
            <div class="card-body alert-warning p-3">
                @foreach (collect($project->tasks)->where('status', 'pending') as $task)
                    <div class="card p-2 mb-2">
                        <div class="d-flex justify-content-between">
                            <span class="fss">{{ $task->title }}</span>
                            <span>
                                <a href="#" class="text-warning edit_pending_task_btn"
                                    data-task="{{ base64_encode(json_encode($task)) }}"
                                    data-task-members="{{ base64_encode(json_encode(collect($task->members)->pluck('id')->toArray())) }}">
                                    <i class="fa-solid fa-edit"></i></a>
                                <a href="#" class="text-danger delete_task_btn" data-id="{{ $task->id }}"><i class="fa-solid fa-trash"></i></a>
                            </span>
                        </div>
                        <div class="fss">
                            <i class="fa-solid fa-clock"></i>
                            <span> {{ Carbon\Carbon::parse($task->start_date)->format('M d') }} </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            @if ($task->priority == 'high')
                                <span class="fss badge bg-danger">High</span>
                            @elseif ($task->priority == 'middle')
                                <span class="fss badge bg-warning">Middle</span>
                            @elseif ($task->priority == 'low')
                                <span class="fss badge bg-dark">Low</span>
                            @endif
                            <span>
                                @foreach ($task->members as $member)
                                    <img src="{{ asset($member->profile_img_path()) }}" alt=""
                                        style="width:40px; height:40px;object-fit:cover;">
                                @endforeach
                            </span>
                        </div>
                    </div>
                @endforeach
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
                @foreach (collect($project->tasks)->where('status', 'in_progress') as $task)
                    <div class="card p-2 mb-2">
                        <div class="d-flex justify-content-between">
                            <span class="fss">{{ $task->title }}</span>
                            <span>
                                <a href="#" class="text-warning edit_pending_task_btn"
                                    data-task="{{ base64_encode(json_encode($task)) }}"
                                    data-task-members="{{ base64_encode(json_encode(collect($task->members)->pluck('id')->toArray())) }}">
                                    <i class="fa-solid fa-edit"></i></a>
                                <a href="#" class="delete_task_btn text-danger" data-id="{{ $task->id }}"><i class="fa-solid fa-trash"></i></a>
                            </span>
                        </div>
                        <div class="fss">
                            <i class="fa-solid fa-clock"></i>
                            <span> {{ Carbon\Carbon::parse($task->start_date)->format('M d') }} </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            @if ($task->priority == 'high')
                                <span class="fss badge bg-danger">High</span>
                            @elseif ($task->priority == 'middle')
                                <span class="fss badge bg-warning">Middle</span>
                            @elseif ($task->priority == 'low')
                                <span class="fss badge bg-dark">Low</span>
                            @endif
                            <span>
                                @foreach ($task->members as $member)
                                    <img src="{{ asset($member->profile_img_path()) }}" alt=""
                                        style="width:40px; height:40px;object-fit:cover;">
                                @endforeach
                            </span>
                        </div>
                    </div>
                @endforeach
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
            <div class="card-body p-3 alert-success">
                @foreach (collect($project->tasks)->where('status', 'complete') as $task)
                    <div class="card p-2 mb-2">
                        <div class="d-flex justify-content-between">
                            <span class="fss">{{ $task->title }}</span>
                            <span>
                                <a href="#" class="text-warning edit_pending_task_btn"
                                    data-task="{{ base64_encode(json_encode($task)) }}"
                                    data-task-members="{{ base64_encode(json_encode(collect($task->members)->pluck('id')->toArray())) }}">
                                    <i class="fa-solid fa-edit"></i></a>
                                <a href="#" class="delete_task_btn text-danger" data-id="{{ $task->id }}"><i class="fa-solid fa-trash"></i></a>
                            </span>
                        </div>
                        <div class="fss">
                            <i class="fa-solid fa-clock"></i>
                            <span> {{ Carbon\Carbon::parse($task->start_date)->format('M d') }} </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            @if ($task->priority == 'high')
                                <span class="fss badge bg-danger">High</span>
                            @elseif ($task->priority == 'middle')
                                <span class="fss badge bg-warning">Middle</span>
                            @elseif ($task->priority == 'low')
                                <span class="fss badge bg-dark">Low</span>
                            @endif
                            <span>
                                @foreach ($task->members as $member)
                                    <img src="{{ asset($member->profile_img_path()) }}" alt=""
                                        style="width:40px; height:40px;object-fit:cover;">
                                @endforeach
                            </span>
                        </div>
                    </div>
                @endforeach

                <button class="btn btn-block bg-white complete-btn"><i class="fa-solid fa-plus me-2"></i>Add
                    Task</button>
            </div>
        </div>
    </div>
</div>
