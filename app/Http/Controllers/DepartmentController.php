<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Department;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_department')) {
            abort(403, 'Unauthorized Action');
        }
        return view('department.index');
    }
    public function ssd()
    {
        if (!auth()->user()->can('view_department')) {
            abort(403, 'Unauthorized Action');
        }
        $deparments = Department::query();
        return DataTables::of($deparments)
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';
                if (auth()->user()->can('edit_department')) {
                    $edit_icon = '<a href=" ' . route('department.edit', $each->id) . ' " class="text-warning"   title="edit">
                    <i class="bx bxs-edit bx-sm"></i>
                    </a>';
                }
                if (auth()->user()->can('delete_department')) {
                    $delete_icon = '<a href="' . route('department.destroy', $each->id) . '" class="text-danger delete-btn" title="delete" data-id="' . $each->id . '">
                <i class="bx bxs-trash bx-sm"></i>
                </a>';
                }

                return '<div class="d-flex justify-content-center align-items-center align-middle">' . $edit_icon . $delete_icon . '</div>';
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format("Y-m-d H:i:s");
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (!auth()->user()->can('create_department')) {
            abort(403, 'Unauthorized Action');
        }
        $departments = Department::orderBy('name')->get();
        return view('department.create', compact('departments'));
    }

    public function store(StoreDepartmentRequest $request)
    {
        if (!auth()->user()->can('create_department')) {
            abort(403, 'Unauthorized Action');
        }
        $department = new Department();
        $department->name = $request->name;

        $department->save();
        return redirect()->route('department.index')->with('success', 'New Department is created successfully!');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit_department')) {
            abort(403, 'Unauthorized Action');
        }
        $department = Department::findOrFail($id);

        return view('department.edit', compact('department'));
    }

    public function update(StoreDepartmentRequest $request, $id)
    {
        if (!auth()->user()->can('edit_department')) {
            abort(403, 'Unauthorized Action');
        }
        $department = Department::findOrFail($id);
        $department->name = $request->name;

        $department->update();
        return redirect()->route('department.index')->with('success', 'New Department is updated successfully!');
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete_department')) {
            abort(403, 'Unauthorized Action');
        }
        $department = Department::findOrFail($id);
        $department->delete();

        return 'success';
    }
}
