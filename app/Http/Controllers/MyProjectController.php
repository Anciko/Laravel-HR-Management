<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Project;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Request;

class MyProjectController extends Controller
{
    public function project()
    {
        return view('my_project');
    }

    public function show($id) {
        $project = Project::findOrFail($id);
        return view('my_project_show', compact('project'));
    }
    
    public function ssd()
    {
        $projects = Project::with('leaders', 'members')
            ->whereHas('leaders', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->orWhereHas('members', function ($query) {
                $query->where('user_id', auth()->user()->id);
            });
        return DataTables::of($projects)
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->editColumn('description', function ($each) {
                return Str::limit($each->description, 100, '...');
            })
            ->addColumn('leaders', function ($each) {
                $output = "<div class='d-flex flex-wrap justify-content-between'>";
                foreach ($each->leaders as $leader) {
                    $output .= '<img src=" ' . $leader->profile_img_path() . ' " class="img-fluid profile-img" />';
                }

                $output .= "</div>";
                return $output;
            })
            ->addColumn('members', function ($each) {
                $output = "<div class='d-flex justify-content-between'>";
                foreach ($each->members as $member) {
                    $output .= '<img src=" ' . $member->profile_img_path() . ' " class="img-fluid profile-img" />';
                }
                $output .= "</div>";
                return $output;
            })
            ->editColumn('priority', function ($each) {
                $priority = '';
                if ($each->priority == 'high') {
                    $priority = '<span class="badge bg-danger badge-pill">' . $each->priority . '</span>';
                } else if ($each->priority == 'middle') {
                    $priority = '<span class="badge badge-pill bg-info">' . $each->priority . '</span>';
                } else {
                    $priority = '<span class="badge badge-pill bg-dark">' . $each->priority . '</span>';
                }
                return $priority;
            })
            ->editColumn('status', function ($each) {
                $status = '';
                if ($each->status == 'pending') {
                    $status = '<span class="badge badge-pill badge-warning">' . $each->status . '</span>';
                } else if ($each->status == 'on-progress') {
                    $status = '<span class="badge badge-pill badge-info">' . $each->status . '</span>';
                } else {
                    $status = '<span class="badge badge-pill badge-success">' . $each->status . '</span>';
                }
                return $status;
            })
            ->addColumn('action', function ($each) {
                $detail_icon = '';

                if (auth()->user()->can('view_project')) {
                    $detail_icon = '<a href=" ' . route( 'my-project.show' , $each->id) . ' " class="text-info mx-1" title="detail">
                    <i class="bx bx-info-circle bx-sm"></i>
                    </a>';
                }


                return '<div class="d-flex justify-content-center align-items-center align-middle">' . $detail_icon . '</div>';
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format("Y-m-d H:i:s");
            })
            ->rawColumns(['leaders', 'members', 'priority', 'status', 'action'])
            ->make(true);
    }

}
