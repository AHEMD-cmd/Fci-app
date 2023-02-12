<?php

namespace App\Http\Controllers\Api;

use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{


    public function index()
     {
         return Staff::with('department')->get();
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
             'img' => 'required|image',
             'phone' => 'required|alpha_num',
             'department_id' => 'required|exists:departments,id',
             'type' => 'required|in:assis,doc,admin'

         ]);

         if($request->hasFile('img')){
            $file = $request->file('img');
            $imageName = time().'_'. $file->getClientOriginalName();
            $file->move(\public_path('staff_photo/'),$imageName);
            $data['img'] = $imageName;
        }

        $data['password'] = Hash::make($request->post('password'));

         $student = Staff::create($data);

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
         $student = Staff::findorfail($id);

         $data = $request->validate([
            'name' => 'required|max:100|sometimes',
            'email' => 'required|string|max:100|email',
            'password' => 'required|string|max:250',
            'photo' => 'nullable|image',
            'phone' => 'required|alpha_num',
            'department_id' => 'required|exists:departments,id',
            'type' => 'required|in:assis,doc',

        ]);

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $imageName = time().'_'. $file->getClientOriginalName();
            $file->move(\public_path('staff_photo/'),$imageName);
            $data['photo'] = $imageName;
        }else{
            $data['photo'] = $student->img;
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
         $student = Staff::findorfail($id);
         $student->delete();

         return[
             'status' => 'success',
             'data' => 'staff deleted'
         ];
     }
}
