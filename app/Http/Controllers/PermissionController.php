<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_permission')) {
            abort(403, 'Unauthorized Action');
        }
        return view('permission.index');
    }

    public function ssd()
    {
        if (!auth()->user()->can('view_permission')) {
            abort(403, 'Unauthorized Action');
        }

        $permissions = Permission::query();
        return DataTables::of($permissions)
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('edit_permission')) {
                    $edit_icon = '<a href=" ' . route('permission.edit', $each->id) . ' " class="text-warning" title="edit">
                    <i class="bx bxs-edit bx-sm"></i>
                    </a>';
                }
                if (auth()->user()->can('delete_permission')) {
                    $delete_icon = '<a href="' . route('permission.destroy', $each->id) . '" class="text-danger delete-btn" title="delete" data-id="' . $each->id . '">
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
        if (!auth()->user()->can('create_permission')) {
            abort(403, 'Unauthorized Action');
        }
        $permissions = Permission::orderBy('name')->get();
        return view('permission.create', compact('permissions'));
    }

    public function store(StorePermissionRequest $request)
    {
        if (!auth()->user()->can('create_permission')) {
            abort(403, 'Unauthorized Action');
        }
        $permission = new Permission();
        $permission->name = $request->name;

        $permission->save();
        return redirect()->route('permission.index')->with('success', 'New Permission is created successfully!');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit_permission')) {
            abort(403, 'Unauthorized Action');
        }
        $permission = Permission::findOrFail($id);

        return view('permission.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, $id)
    {
        if (!auth()->user()->can('edit_permission')) {
            abort(403, 'Unauthorized Action');
        }
        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;

        $permission->update();
        return redirect()->route('permission.index')->with('success', 'New Permission is updated successfully!');
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete_permission')) {
            abort(403, 'Unauthorized Action');
        }
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return 'success';
    }

}
