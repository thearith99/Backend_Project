<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CourseStoreRequest;

class CourseController extends Controller
{
    // public function create(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'title' => 'nullable|string|max:255',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $imagePath = null;

    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         $imageName = time() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('uploads'), $imageName); // Changed 'upload' to 'uploads' and added a slash before $imageName
    //         $imagePath = 'uploads/' . $imageName; // Added a slash before $imageName
    //     }

    //     $course = Course::create([
    //         'name' => $request->input('name'),
    //         'title' => $request->input('title'),
    //         'image' => $imagePath,
    //     ]);

    //     return response()->json(['data' => $course]);
    // }

    // public function getAllCourses()
    // {
    //     $courses = Course::all();

    //     return response()->json(['data' => $courses]);
    // }

    // public function getOneCourse($id)
    // {
    //     $course = Course::find($id);

    //     if (!$course) {
    //         return response()->json(['error' => 'Course not found']);
    //     }

    //     return response()->json(['data' => $course]);
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'title' => 'nullable|string|max:255',
    //         'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $course = Course::find($id);

    //     if (!$course) {
    //         return response()->json(['error' => 'Course not found']);
    //     }

    //     if ($request->hasFile('image')) {
    //         // Handle image upload
    //         $image = $request->file('image');
    //         $imageName = time() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('uploads'), $imageName);
    //         $imagePath = 'uploads/' . $imageName;

    //         // Delete the previous image if it exists
    //         if ($course->image) {
    //             $previousImagePath = public_path($course->image);
    //             if (file_exists($previousImagePath)) {
    //                 unlink($previousImagePath);
    //             }
    //         }

    //         // Update the course with the new image path
    //         $course->image = $imagePath;
    //     }

    //     // Update other fields
    //     $course->name = $request->input('name');
    //     $course->title = $request->input('title', 'default_title'); // Set a default value in case 'title' is not present in the request
    //     $course->save();

    //     return response()->json(['data' => $course]);
    // }



    // public function delete($id)
    // {
    //     $course = Course::find($id);

    //     if (!$course) {
    //         return response()->json(['error' => 'Course not found']);
    //     }

    //     $course->delete();

    //     return response()->json(['message' => 'Course deleted successfully']);
    // }





    public function getAllCourses()
    {
       // All Course
       $course = Course::all();
      
       // Return Json Response
       return response()->json([
          'Course' => $course
       ],200);
    }
  
    public function create(CourseStoreRequest $request)
    {
        try {
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
      
            // Create Product
            Course::create([
                'name' => $request->name,
                'image' => $imageName,
                'title' => $request->title
            ]);
      
            // Save Image in Storage folder
            Storage::disk('public')->put($imageName, file_get_contents($request->image));
      
            // Return Json Response
            return response()->json([
                'message' => "Course successfully created."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ],500);
        }
    }
  
    public function getOneCourse($id)
    {
       // Course Detail 
       $course = Course::find($id);
       if(!$course){
         return response()->json([
            'message'=>'Course Not Found.'
         ],404);
       }
      
       // Return Json Response
       return response()->json([
          'Course' => $course
       ],200);
    }
  
    public function update(CourseStoreRequest $request, $id)
    {
        try {
            // Find Course
            $course = Course::find($id);
            if(!$course){
              return response()->json([
                'message'=>'Course Not Found.'
              ],404);
            }
      
            //echo "request : $request->image";
            $course->name = $request->name;
            $course->title = $request->title;
      
            if($request->image) {
 
                // Public storage
                $storage = Storage::disk('public');
      
                // Old iamge delete
                if($storage->exists($course->image))
                    $storage->delete($course->image);
      
                // Image name
                $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
                $course->image = $imageName;
      
                // Image save in public folder
                $storage->put($imageName, file_get_contents($request->image));
            }
      
            // Update Product
            $course->save();
      
            // Return Json Response
            return response()->json([
                'message' => "Course successfully updated."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ],500);
        }
    }
  
    public function delete($id)
    {
        // Detail 
        $course = Course::find($id);
        if(!$course){
          return response()->json([
             'message'=>'Product Not Found.'
          ],404);
        }
      
        // Public storage
        $storage = Storage::disk('public');
      
        // Iamge delete
        if($storage->exists($course->image))
            $storage->delete($course->image);
      
        // Delete Product
        $course->delete();
      
        // Return Json Response
        return response()->json([
            'message' => "Product successfully deleted."
        ],200);
    }
}
