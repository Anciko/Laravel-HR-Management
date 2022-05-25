<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee.index');
    }

    public function ssd()
    {
        $users = User::with('department')->get();
        return DataTables::of($users)
            ->addColumn('department', function ($each) {
                return $each->department->name ?? '-';
            })
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href=" ' . route('employee.edit', $each->id) . ' " class="text-warning" title="edit">
                    <i class="bx bxs-edit bx-sm"></i>
                    </a>';
                $detail_icon = '<a href=" ' . route('employee.show', $each->id) . ' " class="text-info mx-1" title="detail">
                    <i class="bx bx-info-circle bx-sm"></i>
                    </a>';

                $delete_icon = '<a href="'. route('employee.destroy', $each->id) .'" class="text-danger delete-btn" title="delete" data-id="'.$each->id.'">
                <i class="bx bxs-trash bx-sm"></i>
                </a>';

                return '<div class="d-flex justify-content-center align-items-center align-middle">' . $edit_icon . $detail_icon . $delete_icon . '</div>';
            })
            ->editColumn('is_present', function ($each) {
                return $each->is_present == 1 ? "<span class='badge badge-pill badge-success p-2'>Present</span>" : "<span class='badge badge-pill badge-danger p-2'>Leave</span>";
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format("Y-m-d H:i:s");
            })
            ->rawColumns(['is_present', 'action'])
            ->make(true);
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('employee.create', compact('departments'));
    }

    public function store(StoreEmployeeRequest $request)
    {

        if ($request->hasFile('profile_img')) {
            $profile_img_file = $request->file('profile_img');
            $profile_img_name = time() . '-' . uniqid() . '-' . $profile_img_file->getClientOriginalName();

            Storage::disk('public')->put('employee/' . $profile_img_name,
                file_get_contents($profile_img_file));
        }

        $employee = new User();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->password = Hash::make($request->password);
        $employee->employee_id = $request->employeeid;
        $employee->nrc_number = $request->nrc;
        $employee->birthday = $request->birthday;
        $employee->gender = $request->gender;
        $employee->address = $request->address;
        $employee->department_id = $request->department;
        $employee->date_of_join = $request->dateOfJoin;
        $employee->profile_img = $profile_img_name;
        $employee->is_present = $request->present;

        $employee->save();
        return redirect()->route('employee.index')->with('success', 'Employee is created successfully!');
    }

    public function show($id)
    {
        $employee = User::with('department')->findOrFail($id);
        return view('employee.show', compact('employee'));
    }

    public function edit($id)
    {
        $employee = User::findOrFail($id);
        $departments = Department::orderBy('name')->get();

        return view('employee.edit', compact('employee', 'departments'));
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        $employee = User::findOrFail($id);

        $profile_img_name = $employee->profile_img;
        if ($request->hasFile('profile_img')) {
            echo "Hello";
            $profile_img_file = $request->file('profile_img');
            $profile_img_name = time() . '-' . uniqid() . '-' . $profile_img_file->getClientOriginalName();

            Storage::disk('public')->put('employee/' . $profile_img_name,
                file_get_contents($profile_img_file));
        }
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->password = $request->password ? Hash::make($request->password) : $employee->password;
        $employee->employee_id = $request->employeeid;
        $employee->nrc_number = $request->nrc;
        $employee->birthday = $request->birthday;
        $employee->gender = $request->gender;
        $employee->address = $request->address;
        $employee->department_id = $request->department;
        $employee->date_of_join = $request->dateOfJoin;
        $employee->profile_img = $profile_img_name;
        $employee->is_present = $request->present;

        $employee->update();
        return redirect()->route('employee.index')->with('success', 'Employee is updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return 'success';
    }
}
