<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function index()
     {
         return Student::with('department')->get();
     }

     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
         $data = $request->validate([
             'name' => 'required|string|max:100',
             'email' => 'required|string|max:100|email',
             'password' => 'required|string|max:250',
             'photo' => 'required|image',
             'phone' => 'required|alpha_num',
             'address' => 'required|string|max:255',
             'age' => 'required|integer|max:255',
             'gender' => 'required|string|max:255',
             'birthday' => 'required|string|max:500',
             'department_id' => 'required|exists:departments,id'

         ]);

         if($request->hasFile('photo')){
            $file = $request->file('photo');
            $imageName = time().'_'. $file->getClientOriginalName();
            $file->move(\public_path('student_photo/'),$imageName);
            $data['photo'] = $imageName;
        }

         $student = Student::create($data);

         return[
             'data' => $student
         ];
     }

     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function show($id)
     {

     }

     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request, $id)
     {
         $student = Student::findorfail($id);

         $data = $request->validate([
            'name' => 'required|max:100|sometimes',
            'email' => 'required|string|max:100|email',
            'password' => 'required|string|max:250',
            'photo' => 'nullable|image',
            'phone' => 'required|alpha_num',
            'address' => 'required|string|max:255',
            'age' => 'required|integer|max:255',
            'gender' => 'required|string|max:255',
            'birthday' => 'required|string|max:500',
            'department_id' => 'required|exists:departments,id'

        ]);

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $imageName = time().'_'. $file->getClientOriginalName();
            $file->move(\public_path('student_photo/'),$imageName);
            $data['photo'] = $imageName;
        }else{
            $data['photo'] = public_path('student_photo/sK6afh.jpg');
        }

       $student->update($data);

       return[
           'data' => $student
       ];
     }

     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy($id)
     {
         $student = Student::findorfail($id);
         $student->delete();

         return[
             'status' => 'success',
             'data' => 'student deleted'
         ];
     }
}
