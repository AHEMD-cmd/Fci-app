<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\testimonial;
use Illuminate\Http\Request;

class testimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return testimonial::all();
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
            'content' => 'required|string|max:100',
            'user_id' => 'required|exists:users,id',

        ]);

        $department = testimonial::create($data);

        return[
            'data' => $department
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
        $department = testimonial::findorfail($id);
        return $department;
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
        $department = testimonial::findorfail($id);

        $data = $request->validate([
            'content' => 'required|string|max:100',
            'student_id' => 'required|exists:students,id',

        ]);

      $department->update($data);

      return[
          'data' => $department
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

        $testimonial = testimonial::findorfail($id);
        $testimonial->delete();

        return[
            'status' => 'success',
            'data' => 'deleted'
        ];
    }
}
