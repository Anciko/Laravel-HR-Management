<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanySetting;
use App\Http\Requests\StoreCompanySettingRequest;

class CompanySettingController extends Controller
{
    public function show($id) {
        $company_setting = CompanySetting::findOrFail($id);
        return view('company_setting.show', compact('company_setting'));
    }

    public function edit($id) {
        $company_setting = CompanySetting::findOrFail($id);

        return view('company_setting.edit', compact('company_setting'));
    }

    public function update(StoreCompanySettingRequest $request, $id) {
        $company_setting = CompanySetting::findOrFail($id);
        $company_setting->company_name = $request->company_name;
        $company_setting->company_email = $request->company_email;
        $company_setting->company_phone = $request->company_phone;
        $company_setting->company_address = $request->company_address;
        $company_setting->office_start_time = $request->office_start_time;
        $company_setting->office_end_time = $request->office_end_time;
        $company_setting->break_start_time = $request->break_start_time;
        $company_setting->break_end_time = $request->break_end_time;

        $company_setting->update();

        return redirect()->route('company-setting.show',1)->with('success', 'Company Setting is updated!');
    }
}
