<?php

namespace App\Http\Controllers;

use App\Models\CheckInCheckOut;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AttendanceScanController extends Controller
{
    public function scan() {
        return view('attendance_scan');
    }

    public function scanStore(Request $request) {
        $date = now()->format('Y-m-d');
        $checked_value = Hash::check($date, $request->hashed_value);
        if(!$checked_value) {
            return [
                'status' => 'error',
                'message' => 'QR code is invalid'
            ];
        }

        $user = auth()->user();
        $checkin_checkout = CheckInCheckOut::firstOrCreate([
            'user_id' => $user->id,
            'date' => now()->format('Y-m-d')
        ]);

        if(!is_null($checkin_checkout->check_in_time) && !is_null($checkin_checkout->check_out_time)) {
            return [
                'status' => 'error',
                'message' => 'User is already defined!'
            ];
        }

        if(is_null($checkin_checkout->check_in_time)) {
            $checkin_checkout->check_in_time = now();
            $message = "Successfully checked in at " . now();
        }else{
            if(is_null($checkin_checkout->check_out_time)) {
                $checkin_checkout->check_out_time = now();
                $message = "Successfully checked out at " . now();
            }
        }

        $checkin_checkout->update();
        return [
            'status' => 'success',
            'message' => $message
        ];
    }
}
