<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CourseStoreRequest;

class CourseController extends Controller
{
    public function getAllCourses()
    {
       // All Course
       $course = Course::all();
      
       // Return Json Response
       return response()->json([
          'Course' => $course
       ]);
    }
  
    public function create(CourseStoreRequest $request)
    {
        try {
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
      
            // Create Product
            Course::create([
                'name' => $request->name,
                'image' => $imageName,
                'title' => $request->title,
                'grade_id' => $request->grade_id,
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
            $course->grade_id = $request->grade_id;
            
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
