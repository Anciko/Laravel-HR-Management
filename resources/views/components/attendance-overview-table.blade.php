<div class="table-responsive mt-3">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="align-middle">Employee</th>
                @foreach ($periods as $period)
                    <th class="text-center @if ($period->format('D') == 'Sat' || $period->format('D') == 'Sun') bg-danger text-white @endif">
                        {{$period->format('D')}}
                        <br>
                        {{ $period->format('d') }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr class="text-center">
                    <td class="align-middle">{{ $employee->employee_id }}</td>
                    @foreach ($periods as $period)
                        @php
                            $office_start_time = $period->format('Y-m-d') . ' ' . $company_setting->office_start_time;
                            $office_end_time = $period->format('Y-m-d') . ' ' . $company_setting->office_end_time;
                            $break_start_time = $period->format('Y-m-d') . ' ' . $company_setting->break_start_time;
                            $break_end_time = $period->format('Y-m-d') . ' ' . $company_setting->break_end_time;

                            $attendance = collect($attendances)
                                ->where('user_id', $employee->id)
                                ->where('date', $period->format('Y-m-d'))
                                ->first();

                            $checkin_icon = '';
                            $checkout_icon = '';
                            if ($attendance) {
                                // For Morning Section
                                if ($attendance->check_in_time <= $office_start_time) {
                                    $checkin_icon = '<i class="fa-solid fa-circle-check text-success"></i>';
                                } elseif ($attendance->check_in_time > $office_start_time && $attendance->check_in_time < $break_start_time) {
                                    $checkin_icon = '<i class="fa-solid fa-circle-check text-warning"></i>';
                                } else {
                                    $checkin_icon = '<i class="fa-solid fa-times-circle text-danger"></i>';
                                }
                                // For Afternoon Section
                                if ($attendance->check_out_time <= $break_end_time) {
                                    $checkout_icon = '<i class="fa-solid fa-times-circle text-danger"></i>';
                                } elseif ($attendance->check_out_time < $office_end_time && $attendance->check_out_time > $break_end_time) {
                                    $checkout_icon = '<i class="fa-solid fa-circle-check text-warning"></i>';
                                } else {
                                    $checkout_icon = '<i class="fa-solid fa-circle-check text-success"></i>';
                                }
                            }
                        @endphp
                        <td @if ($period->format('D') == 'Sat' || $period->format('D') == 'Sun') class="bg-light shadow-sm" @endif>
                            <div>{!! $checkin_icon !!}</div>
                            <div>{!! $checkout_icon !!}</div>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
