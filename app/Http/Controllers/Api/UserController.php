<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {

            $this->middleware(StaffType::class)->except('store', 'update');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
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
            'name' => 'required|string|max:250',
            'email' => 'required|string|max:250|email',
            'password' => 'required|string|max:250',
            'img' => 'required|image',
            'ssn' =>'required',
            'phone' => 'required|alpha_num',
            'department_id' => 'required|exists:departments,id',

        ]);

        if($request->hasFile('img')){
           $file = $request->file('img');
           $imageName = time().'_'. $file->getClientOriginalName();
           $file->move(\public_path('user_img/'),$imageName);
           $data['img'] = $imageName;
       }

       $data['password'] = Hash::make($request->post('password'));

        $student = User::create($data);

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
        if(Auth::guard('sanctum')->user()->id == $id){

            $user = User::findorfail($id);
            return $user;
        }
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
        if(Auth::guard('sanctum')->user()->id == $id){

        $student = User::findorfail($id);

        $data = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|max:250|email',
            'password' => 'required|string|max:250',
            'img' => 'required|image',
            'ssn' =>'required',
            'phone' => 'required|alpha_num',
            'department_id' => 'required|exists:departments,id',

        ]);

       if($request->hasFile('img')){
           $file = $request->file('img');
           $imageName = time().'_'. $file->getClientOriginalName();
           $file->move(\public_path('user_img/'),$imageName);
           $data['img'] = $imageName;
       }else{
           $data['img'] = $student->img;
       }

      $student->update($data);

      return[
          'data' => $student
      ];
    }}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::guard('sanctum')->user()->id == $id){

        $user = User::findorfail($id);
        $user->delete();

        return[
            'data' => $user
        ];

    }}
}
