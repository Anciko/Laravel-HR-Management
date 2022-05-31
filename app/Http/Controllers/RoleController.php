<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        return view('role.index');
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = new Role();
        $role->name = $request->name;

        $role->save();

        $role->givePermissionTo($request->permissions);

        return redirect()->route('role.index')->with('success', 'New Role is created successfully!');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $old_permissions = $role->permissions->pluck('id')->toArray();

        return view('role.edit', compact('role', 'permissions', 'old_permissions'));
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->name = $request->name;

        $role->update();

        $old_permissions = $role->permissions->pluck('name')->toArray();
        $role->revokePermissionTo($old_permissions);
        $role->givePermissionTo($request->permissions);
        return redirect()->route('role.index')->with('success', 'New Department is updated successfully!');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return 'success';
    }

    public function ssd()
    {
        $roles = Role::query();
        return DataTables::of($roles)
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->addColumn('permissions', function($each) {
                $output = '';
                foreach($each->permissions as $permission) {
                    $output .= '<span class="badge badge-pill badge-primary m-1">'.$permission->name.'</span>';
                }

                return $output;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href=" ' . route('role.edit', $each->id) . ' " class="text-warning" title="edit">
                    <i class="bx bxs-edit bx-sm"></i>
                    </a>';

                $delete_icon = '<a href="' . route('role.destroy', $each->id) . '" class="text-danger delete-btn" title="delete" data-id="' . $each->id . '">
                <i class="bx bxs-trash bx-sm"></i>
                </a>';

                return '<div class="d-flex justify-content-center align-items-center align-middle">' . $edit_icon . $delete_icon . '</div>';
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format("Y-m-d H:i:s");
            })
            ->rawColumns(['action', 'permissions'])
            ->make(true);
    }
}
