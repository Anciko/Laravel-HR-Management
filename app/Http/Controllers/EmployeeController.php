<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
                $detail_icon = '<a href=" ' . route('employee.show', $each->id) . ' " class="text-info" title="detail">
                    <i class="bx bx-info-circle bx-sm"></i>
                    </a>';
                return '<div class="d-flex justify-content-center align-items-center align-middle">' .$edit_icon . $detail_icon. '</div>';
            })
            ->editColumn('is_present', function ($each) {
                return $each->is_present == 1 ? "<span class='badge badge-pill badge-success p-2'>Present</span>" : "<span class='badge badge-pill badge-danger p-2'>Absence</span>";
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format("Y-m-d H:i:s");
            })
            ->rawColumns(['is_present', 'action'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('employee.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $employee->is_present = $request->present;

        $employee->save();
        return redirect()->route('employee.index')->with('success', 'Employee is created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
