<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return view('permission.index');
    }

    public function create()
    {
        $permissions = Permission::orderBy('name')->get();
        return view('permission.create', compact('permissions'));
    }

    public function store(StorePermissionRequest $request)
    {
        $permission = new Permission();
        $permission->name = $request->name;

        $permission->save();
        return redirect()->route('permission.index')->with('success', 'New Permission is created successfully!');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('permission.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;

        $permission->update();
        return redirect()->route('permission.index')->with('success', 'New Permission is updated successfully!');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return 'success';
    }

    public function ssd()
    {
        $permissions = Permission::query();
        return DataTables::of($permissions)
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href=" ' . route('permission.edit', $each->id) . ' " class="text-warning" title="edit">
                    <i class="bx bxs-edit bx-sm"></i>
                    </a>';

                $delete_icon = '<a href="' . route('permission.destroy', $each->id) . '" class="text-danger delete-btn" title="delete" data-id="' . $each->id . '">
                <i class="bx bxs-trash bx-sm"></i>
                </a>';

                return '<div class="d-flex justify-content-center align-items-center align-middle">' . $edit_icon . $delete_icon . '</div>';
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format("Y-m-d H:i:s");
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
