<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SectionController extends Controller
{
    public function sectionIndex()
    {
        $sections = Section::latest()->get();

        return response()->json($sections);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'class_id' => 'required',
            'section_name' => 'required|unique:sections|max:25'
        ]);

        Section::insert([
            'class_id' => $request->class_id,
            'section_name' => $request->section_name,
            'created_at' => Carbon::now(),
        ]);

        return response('Student Section Inserted Successfully');
    }

    public function sectionEdit($id)
    {
        $section = Section::findOrFail($id);

        return response()->json($section);
    }

    public function sectionUpdate(Request $request, $id)
    {
        Section::findOrFail($id)->update([
            'class_id' => $request->class_id,
            'section_name' => $request->section_name,
        ]);

        return response('Student Section Updated Successfully');
    }

    public function sectionDelete($id)
    {
        Section::findOrFail($id)->delete();

        return response('Student Section Deleted Successfully');
    }
}
