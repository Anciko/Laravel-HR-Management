<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_project')) {
            abort(403, 'Unauthorized Action');
        }
        return view('project.index');
    }
    public function ssd()
    {
        if (!auth()->user()->can('view_project')) {
            abort(403, 'Unauthorized Action');
        }
        $projects = Project::with('leaders', 'members');
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
                $edit_icon = '';
                $delete_icon = '';
                if (auth()->user()->can('edit_project')) {
                    $edit_icon = '<a href=" ' . route('project.edit', $each->id) . ' " class="text-warning"  title="edit">
                    <i class="bx bxs-edit bx-sm"></i>
                    </a>';
                }
                if (auth()->user()->can('view_project')) {
                    $detail_icon = '<a href=" ' . route('project.show', $each->id) . ' " class="text-info mx-1" title="detail">
                    <i class="bx bx-info-circle bx-sm"></i>
                    </a>';
                }
                if (auth()->user()->can('delete_project')) {
                    $delete_icon = '<a href="' . route('project.destroy', $each->id) . '" class="text-danger delete-btn" title="delete" data-id="' . $each->id . '">
                <i class="bx bxs-trash bx-sm"></i>
                </a>';
                }

                return '<div class="d-flex justify-content-center align-items-center align-middle">' . $edit_icon . $detail_icon . $delete_icon . '</div>';
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format("Y-m-d H:i:s");
            })
            ->rawColumns(['leaders', 'members', 'priority', 'status', 'action'])
            ->make(true);
    }

    public function create()
    {
        if (!auth()->user()->can('create_project')) {
            abort(403, 'Unauthorized Action');
        }
        $employees = User::orderBy('employee_id')->get();
        return view('project.create', compact('employees'));
    }

    public function store(StoreProjectRequest $request)
    {
        if (!auth()->user()->can('create_project')) {
            abort(403, 'Unauthorized Action');
        }

        $image_names = null;
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $image_names = [];
            foreach ($images as $image) {
                $image_name = time() . '-' . uniqid() . '-' . $image->getClientOriginalName();
                Storage::disk('public')->put('project/' . $image_name,
                    file_get_contents($image));
                $image_names[] = $image_name;
            }
        }

        $pdf_names = null;
        if ($request->hasFile('pdfs')) {
            $pdfs = $request->file('pdfs');
            $pdf_names = [];
            foreach ($pdfs as $pdf) {
                $pdf_name = time() . '-' . uniqid() . '-' . $pdf->getClientOriginalName();
                Storage::disk('public')->put('project/' . $pdf_name,
                    file_get_contents($pdf));
                $pdf_names[] = $pdf_name;
            }
        }

        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->images = $image_names;
        $project->files = $pdf_names;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;

        $project->save();

        $project->leaders()->sync($request->leaders);
        $project->members()->sync($request->members);

        return redirect()->route('project.index')->with('success', 'New Project is created successfully!');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit_project')) {
            abort(403, 'Unauthorized Action');
        }
        $employees = User::orderBy('employee_id')->get();
        $project = Project::with('leaders', 'members')->findOrFail($id);
        return view('project.edit', compact('project', 'employees'));
    }

    public function update(StoreProjectRequest $request, $id)
    {
        if (!auth()->user()->can('edit_project')) {
            abort(403, 'Unauthorized Action');
        }
        $image_names = null;
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $image_names = [];
            foreach ($images as $image) {
                $image_name = time() . '-' . uniqid() . '-' . $image->getClientOriginalName();
                Storage::disk('public')->put('project/' . $image_name,
                    file_get_contents($image));
                $image_names[] = $image_name;
            }
        }

        $pdf_names = null;
        if ($request->hasFile('pdfs')) {
            $pdfs = $request->file('pdfs');
            $pdf_names = [];
            foreach ($pdfs as $pdf) {
                $pdf_name = time() . '-' . uniqid() . '-' . $pdf->getClientOriginalName();
                Storage::disk('public')->put('project/' . $pdf_name,
                    file_get_contents($pdf));
                $pdf_names[] = $pdf_name;
            }
        }

        $project = Project::findOrFail($id);
        $project->title = $request->title;
        $project->description = $request->description;
        $project->images = $image_names;
        $project->files = $pdf_names;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;

        $project->update();

        $project->leaders()->sync($request->leaders);
        $project->members()->sync($request->members);

        return redirect()->route('project.index')->with('success', 'New Project is updated successfully!');
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('project.show', compact('project'));
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete_project')) {
            abort(403, 'Unauthorized Action');
        }
        $project = Project::findOrFail($id);

        $project->leaders()->detach();
        $project->members()->detach();

        $project->delete();

        return 'success';
    }
}
