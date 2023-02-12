<?php

namespace App\Http\Controllers\Api;

use App\Models\reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class replyController extends Controller
{


    public function index()
     {
         return reply::all();
     }




     public function store(Request $request)
     {
         $data = $request->validate([
             'title' => 'required|string|max:250',
             'student_id' => 'required|string|max:250|exists:students,id',
             'content' => 'required|string|max:2000',

         ]);

         $post = reply::create($data);

         return[
             'data' => $post
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
        $reply = reply::findorfail($id);
        return $reply;

     }





     public function update(Request $request, $id)
     {

        $staff = Auth::guard('sanctum')->user();

        if($request->student_id == $id || $staff->type == 'admin' ){

         $reply = reply::findorfail($id);

         $data = $request->validate([
            'title' => 'required|string|max:250',
            'student_id' => 'required|string|max:250|exists:students,id',
            'content' => 'required|string|max:2000',
            'img' => 'required|image',

        ]);

       $reply->update($data);

       return[
           'data' => $reply
       ];
     }
    }





     public function destroy($id)
     {

        $staff = Auth::guard('sanctum')->user();

        if(Auth::guard('sanctum')->user()->id == $id || $staff->type == 'admin' ){

         $reply = reply::findorfail($id);
         $reply->delete();

         return[
             'status' => 'success',
             'data' => 'staff deleted'
         ];
     }
}
}
