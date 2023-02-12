<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\StaffType;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function __construct()
{

        $this->middleware(StaffType::class)->except('index');

}




    public function index()
    {
        return Department::all();
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
            'code' => 'required|string|max:100',
            'years' => 'required|integer|max:20',
            'head_of_department' => 'required|string|max:255'
        ]);

        $department = Department::create($data);

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
        $department = Department::findorfail($id);
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
        $department = Department::findorfail($id);

        $data = $request->validate([
          'name' => 'nullable|string|max:100',
          'code' => 'nullable|string|max:100',
          'years' => 'nullable|integer|max:20',
          'head_of_department' => 'nullable|string|max:255'
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
        $department = Department::findorfail($id);
        $department->delete();

        return[
            'status' => 'success',
            'data' => 'department deleted'
        ];
    }
}
