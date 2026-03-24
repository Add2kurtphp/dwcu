<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FacultyController extends Controller
{
    public function index()
    {
        $faculty = Faculty::orderBy('faculty_id')->get();
        return view('admin.faculty', compact('faculty'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'faculty_id'  => 'required|unique:faculty,faculty_id',
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'department'  => 'required|string|max:255',
            'password'    => 'required|string|min:6',
        ]);

        $faculty = Faculty::create([
            'faculty_id'  => $request->faculty_id,
            'name'        => $request->name,
            'designation' => $request->designation,
            'department'  => $request->department,
            'status'      => 'active',
            'password'    => Hash::make($request->password),
        ]);

        return response()->json(['success' => true, 'faculty' => $faculty]);
    }

    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'designation'  => 'required|string|max:255',
            'department'   => 'required|string|max:255',
            'new_password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name'        => $request->name,
            'designation' => $request->designation,
            'department'  => $request->department,
        ];

        if ($request->filled('new_password')) {
            $data['password'] = Hash::make($request->new_password);
        }

        $faculty->update($data);

        return response()->json(['success' => true, 'faculty' => $faculty]);
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        return response()->json(['success' => true]);
    }
}
