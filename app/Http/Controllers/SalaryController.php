<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Salary;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\StoreSalaryRequest;
use App\Models\Employee;
use App\Models\User;

class SalaryController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_salary')) {
            abort(403, 'Unauthorized Action');
        }
        return view('salary.index');
    }

    public function ssd()
    {
        if (!auth()->user()->can('view_salary')) {
            abort(403, 'Unauthorized Action');
        }
        $salaries = Salary::query();
        return DataTables::of($salaries)
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->editColumn('user_id', function($each) {
                return $each->employee->employee_id ?? "-";
            })
            ->editColumn('month', function($each) {
                return Carbon::parse(`2021-{$each->month}-01`)->format('M');
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';
                if (auth()->user()->can('edit_salary')) {
                    $edit_icon = '<a href=" ' . route('salary.edit', $each->id) . ' " class="text-warning"   title="edit">
                    <i class="bx bxs-edit bx-sm"></i>
                    </a>';
                }
                if (auth()->user()->can('delete_salary')) {
                    $delete_icon = '<a href="' . route('salary.destroy', $each->id) . '" class="text-danger delete-btn" title="delete" data-id="' . $each->id . '">
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
        if (!auth()->user()->can('create_salary')) {
            abort(403, 'Unauthorized Action');
        }
        $employees = User::all();
        return view('salary.create', compact('employees'));
    }

    public function store(StoreSalaryRequest $request)
    {
        if (!auth()->user()->can('create_salary')) {
            abort(403, 'Unauthorized Action');
        }
        $salary = new Salary();
        $salary->user_id = $request->user_id;
        $salary->month = $request->month;
        $salary->year = $request->year;
        $salary->amount = $request->amount;

        $salary->save();
        return redirect()->route('salary.index')->with('success', 'Salary is created successfully!');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit_salary')) {
            abort(403, 'Unauthorized Action');
        }

        $salary = Salary::findOrFail($id);
        $employees = User::all();

        return view('salary.edit', compact('salary', 'employees'));
    }

    public function update(StoreSalaryRequest $request, $id)
    {
        if (!auth()->user()->can('edit_salary')) {
            abort(403, 'Unauthorized Action');
        }
        $salary = Salary::findOrFail($id);
        $salary->user_id = $request->user_id;
        $salary->month = $request->month;
        $salary->year = $request->year;
        $salary->amount = $request->amount;
        
        $salary->update();
        return redirect()->route('salary.index')->with('success', 'New Department is updated successfully!');
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete_salary')) {
            abort(403, 'Unauthorized Action');
        }
        $salary = Salary::findOrFail($id);
        $salary->delete();

        return 'success';
    }
}
