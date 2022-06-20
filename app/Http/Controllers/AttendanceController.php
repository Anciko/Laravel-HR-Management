<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Models\CheckInCheckOut;
use App\Models\CompanySetting;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_attendance')) {
            abort(403, 'Unauthorized Action');
        }
        return view('attendance.index');
    }

    public function ssd()
    {
        if (!auth()->user()->can('view_attendance')) {
            abort(403, 'Unauthorized Action');
        }
        $attendances = CheckInCheckOut::with('employee')->get();

        return DataTables::of($attendances)
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->editColumn('user_id', function ($each) {
                return $each->employee->employee_id;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';
                if (auth()->user()->can('edit_attendance')) {
                    $edit_icon = '<a href=" ' . route('attendance.edit', $each->id) . ' " class="text-warning"   title="edit">
                    <i class="bx bxs-edit bx-sm"></i>
                    </a>';
                }
                if (auth()->user()->can('delete_attendance')) {
                    $delete_icon = '<a href="' . route('attendance.destroy', $each->id) . '" class="text-danger delete-btn" title="delete" data-id="' . $each->id . '">
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
        if (!auth()->user()->can('create_attendance')) {
            abort(403, 'Unauthorized Action');
        }
        $employees = User::all();
        return view('attendance.create', compact('employees'));
    }

    public function store(StoreAttendanceRequest $request)
    {
        if (!auth()->user()->can('create_department')) {
            abort(403, 'Unauthorized Action');
        }

        if (CheckInCheckOut::where('user_id', $request->user_id)->where('date', $request->date)->exists()) {
            return back()->withErrors(['fail' => 'Already definded.'])->withInput();
        }

        $attendances = new CheckInCheckOut();
        $attendances->user_id = $request->user_id;
        $attendances->date = $request->date;
        $attendances->check_in_time = $attendances->date . ' ' . $request->check_in_time;
        $attendances->check_out_time = $attendances->date . ' ' . $request->check_out_time;

        $attendances->save();

        return redirect()->route('attendance.index')->with('success', 'New Attendance is created successfully!');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit_department')) {
            abort(403, 'Unauthorized Action');
        }
        $attendance = CheckInCheckOut::with('employee')->findOrFail($id);
        $employees = User::all();

        return view('attendance.edit', compact('attendance', 'employees'));
    }

    public function update(StoreAttendanceRequest $request, $id)
    {
        if (!auth()->user()->can('edit_department')) {
            abort(403, 'Unauthorized Action');
        }

        $attendance = CheckInCheckOut::findOrFail($id);

        if (CheckInCheckOut::where('user_id', $request->user_id)->where('date', $request->date)->where('id', '!=', $attendance->id)->exists()) {
            return back()->withErrors(['fail' => 'Already defined!'])->withInput();
        }

        $attendance->date = $request->date;
        $attendance->check_in_time = $request->date . ' ' . $request->check_in_time;
        $attendance->check_out_time = $request->date . ' ' . $request->check_out_time;

        $attendance->update();
        return redirect()->route('attendance.index')->with('success', 'Attendance is updated successfully!');
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete_department')) {
            abort(403, 'Unauthorized Action');
        }
        $attendance = CheckInCheckOut::findOrFail($id);
        $attendance->delete();

        return 'success';
    }

    public function overview()
    {
        if (!auth()->user()->can('view_attendance_overview')) {
            abort(403, 'Unauthorized Action');
        }

        return view('attendance.overview');
    }

    public function overviewTable(Request $request)
    {
        if (!auth()->user()->can('view_attendance_overview')) {
            abort(403, 'Unauthorized Action');
        }

        $month = $request->month;
        $year = $request->year;
        $startOfMonth = $year . '-' . $month . '-01'; // 2022-02-01
        $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d'); // 2022-02-28

        $periods = new CarbonPeriod($startOfMonth, $endOfMonth);
        $employees = User::orderBy('employee_id')->where('name', 'like', '%' . $request->employee_name . '%')->get();

        $attendances = CheckInCheckOut::whereMonth('date', $month)->whereYear('date', $year)->get();
        $company_setting = CompanySetting::findOrFail(1);
        return view('components.attendance-overview-table', compact('periods', 'employees', 'attendances', 'company_setting'))->render();
    }
}
