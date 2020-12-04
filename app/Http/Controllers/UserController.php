<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UserApprovedNotification;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('role:Admin', ['only' => ['index']]);
    }

    public function index()
    {
        return view('user.index'); 
    }

    public function getAllUsers()
    {
        $users = User::with('roles')->paginate(10);

        return response()->json(['users' => $users],200);
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
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone' => $request->phone,
            'password' =>bcrypt($request->password)
        ]);

        // $activity = Activity::all()->last();
        
        if($request['role']){
            foreach($request['role'] as $role):
                $rolesToSync[]=$role['name'];
            endforeach;
            
            $user->syncRoles($rolesToSync);
        }

        $user->syncPermissions($request['permissions']);

        return response("success",200);
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

    public function getSelectedUserDetails($user_id)
    {
        $user = User::find($user_id);
        
        $roles = $user->roles->pluck('name')->toArray();

        $permissions = $user->permissions->pluck('name')->toArray();

        $data = [
            'user' => $user,
            'permissions' => $permissions,
            'roles'=>$roles
        ];

        return response()->json($data,200);
    }

    public function updateSelectedUser(Request $request, $user_id){
    
        $user = User::find($user_id);

        //get the value before update
        $is_approved = $user->is_approved;
        
        $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'is_approved'=>($request['is_approved'] == 'true' ? 1 : 0)
        ]);

        if($request['password']){
            $user->update([
                'password' => bcrypt($request->newPassword)
            ]);
        }

        if($is_approved == 0 && $user->is_approved == 1){
            $user->update([
               'approved_by' => auth()->user()->id
            ]);

            $user->notify(New UserApprovedNotification());
        }

        //sync permission if user has revoked any permission for respective role
        if($request['role']){
            foreach($request['role'] as $role):
                $rolesToSync[]=$role['name'];
            endforeach;
            
            $user->syncRoles($rolesToSync);
        }
        
        //since permission is directly passed with name only 
        $user->syncPermissions($request['permissions']);

        return response()->json(['success'],200);
    }
}
