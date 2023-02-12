<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class courseController extends Controller
{
    public function __construct(){

        $this->middleware(StaffType::class)->except('index');
    }


    public function index()
    {
        return Course::all();
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
            'term' => 'required|string|max:100',
            'level' => 'required|string|max:20',
            'link' => 'required|string|max:255',
            'hours' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'data' => 'required|string|max:255',
            'material_id' => 'required|string|max:250|exists:materials,id',

        ]);

        $course = Course::create($data);

        return[
            'data' => $course
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
        $department = Course::findorfail($id);
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
        $course = Course::findorfail($id);

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'term' => 'required|string|max:100',
            'level' => 'required|string|max:20',
            'link' => 'required|string|max:255',
            'hours' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'data' => 'required|string|max:255',
            'material_id' => 'required|string|max:250|exists:materials,id',

        ]);

      $course->update($data);

      return[
          'data' => $course
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
        $course = Course::findorfail($id);
        $course->delete();

        return[
            'status' => 'success',
            'data' => 'department deleted'
        ];
    }
}
