<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'school_name'    => SystemSetting::get('school_name',    'DIVINE WORD COLLEGE OF URDANETA'),
            'portal_name'    => SystemSetting::get('portal_name',    'JHS & SHS Admin Portal'),
            'contact_email'  => SystemSetting::get('contact_email',  'admin@dwcu.edu.ph'),
            'academic_year'  => SystemSetting::get('academic_year',  '2025 – 2026'),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'school_name'   => 'required|string|max:255',
            'portal_name'   => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'academic_year' => 'required|string|max:50',
        ]);

        SystemSetting::set('school_name',   $request->school_name);
        SystemSetting::set('portal_name',   $request->portal_name);
        SystemSetting::set('contact_email', $request->contact_email);
        SystemSetting::set('academic_year', $request->academic_year);

        return back()->with('settings_success', 'School information updated successfully.');
    }
}
