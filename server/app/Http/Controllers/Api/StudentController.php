<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function studentIndex()
    {
        $students = Student::latest()->get();

        return response()->json($students);
    }

    public function studentStore(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:students|max:25',
            'email' => 'required|unique:students|max:25'
        ]);

        Student::insert([
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $request->photo,
            'gender' => $request->gender,
            'created_at' => Carbon::now(),
        ]);

        return response('Student Inserted Successfully');
    }
}
