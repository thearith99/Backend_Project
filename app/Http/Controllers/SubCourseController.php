<?php

namespace App\Http\Controllers;
use App\Http\Requests\SubcourseStoreRequest;
use App\Http\Requests\SubcourseUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Subcourse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SubCourseController extends Controller
{
    public function getAll()
    {
        $subcourses = Subcourse::all();
        return response()->json(['subcourses' => $subcourses]);
    }

    public function getOne($id)
    {
        $subcourse = Subcourse::findOrFail($id);
        return response()->json(['subcourse' => $subcourse]);
    }

    public function create(SubcourseStoreRequest $request)
    {
        try {
            $filePath = null;

            if ($request->hasFile('lesson_file_path')) {
                $file = $request->file('lesson_file_path');
                $filePath = 'storage/' . Str::random(32) . "." . $file->getClientOriginalExtension();
                Storage::disk('public')->put($filePath, file_get_contents($file));
            }

            // Create Subcourse
            Subcourse::create([
                'name' => $request->name,
                'lesson_file_path' => $filePath,
            ]);

            return response()->json([
                'message' => 'Subcourse created successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    public function update(SubcourseStoreRequest $request, $id)
    {
        try {
            // Find the subcourse by its ID
            $subcourse = Subcourse::findOrFail($id);

            // Check if a new file is uploaded
            if ($request->hasFile('lesson_file_path')) {
                // Delete the existing file if it exists
                if ($subcourse->lesson_file_path && Storage::disk('public')->exists($subcourse->lesson_file_path)) {
                    Storage::disk('public')->delete($subcourse->lesson_file_path);
                }

                // Upload the new file
                $file = $request->file('lesson_file_path');
                $filePath = 'storage/' . Str::random(32) . "." . $file->getClientOriginalExtension();
                Storage::disk('public')->put($filePath, file_get_contents($file));

                // Update the lesson_file_path in the database
                $subcourse->lesson_file_path = $filePath;
            }

            // Update other attributes of the Subcourse
            $subcourse->name = $request->name;
            // Add other attributes if needed

            // Save the changes to the database
            $subcourse->save();

            return response()->json([
                'message' => 'Subcourse updated successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!',
            ], 500);
        }
    }
    public function delete($id)
    {
        $subcourse = Subcourse::findOrFail($id);
        $subcourse->delete();

        return response()->json(['message' => 'Subcourse deleted successfully']);
    }
}
