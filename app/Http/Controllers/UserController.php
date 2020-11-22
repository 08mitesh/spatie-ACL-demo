<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index'); 
    }

    public function getAllUsers()
    {
        $user = User::all();

        return response()->json(['users' => $user],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function profile()
    {
        return view('profile.index');
    }

    public function postProfile(Request $request){
        
        $user = auth()->user();

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users,email,'.$user->id,
            'phone'=>'required'
        ]);

        $user->update($request->all());

        return redirect()->back()->with('success','Uploaded successfully');

    }

    public function getPasswordPage(){
        return view('profile.password');
    }

    public function updatePassword(Request $request){

        
        $user = auth()->user();

        $validatedData = $request->validate([
            'newPassword' => 'required|min:6|confirmed',
        ]);

        //update fields
        $user->update([
            'password' => bcrypt($request->newPassword)
        ]);

        return redirect()->back()->with('success','Password updated successfully');
    }
}
