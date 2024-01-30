<?php

namespace App\Http\Controllers;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    // Create a new grade
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $grade = Grade::create([
            'name' => $request->input('name'),
        ]);

        return response()->json($grade);
    }

    // Get all grades
    public function getAll()
    {
        $grades = Grade::all();
        return response()->json(['data' => $grades]);
    }

    // Get one grade by ID
    public function getOne($id)
    {
        // $grade = Grade::find($id);

        // if (!$grade) {
        //     return response()->json(['message' => 'Grade not found']);
        // }

        // return response()->json($grade);

        //one to many

        $grade = Grade::find($id);
        $all_course = $grade->getAllGrade;
        $grade->Course = $all_course;
        return response()->json( $grade);
    }

    // Update a grade by ID
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $grade = Grade::find($id);

        if (!$grade) {
            return response()->json(['message' => 'Grade not found'], 404);
        }

        $grade->name = $request->input('name');
        $grade->save();

        return response()->json(['message' => 'Grade updated successfully', 'data' => $grade]);
    }
    

    // Delete a grade by ID
    public function delete($id)
    {
        $grade = Grade::find($id);

        if (!$grade) {
            return response()->json(['message' => 'Grade not found'], 404);
        }

        $grade->delete();

        return response()->json(['message' => 'Grade deleted successfully']);
    }
}
