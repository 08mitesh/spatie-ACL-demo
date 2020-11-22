<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    public function __construct(Role $role) 
    {
        $this->middleware('auth');
        $this->role = $role;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->role::all();

        return view('role.index',['roles'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|string|unique:roles',
            'permission'=>'nullable'
        ]);

        $role = $this->role->create([
            'name' => $request->name
        ]);

        if($request->has('permissions'))
        {
            $role->givePermissionTo($request->permissions);
        }

        return response()->json('Role created',200);
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

        // $role = $this->role::find($id);
        // $permissions = $role->getAllPermissions();

        // $data = [
        //     'role_name' => $role->name,
        //     'permissions' => $permissions
        // ];
      
        return view('role.edit',['role_id'=>$id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $role)
    {
        $role = $this->role::find($role);
        $role->update([
            'name' => $request['name']
        ]);

        //sync permission if user has revoked any permission for respective role
        $role->syncPermissions($request['permissions']);

        /*

            //Get the existing permissions and will revoke if any present in revoke array.
            $permissions = $role->getAllPermissions();

            foreach($permissions as $permision)
                $oldPermission[] = $permision['name']; 
            
            $permissionsToRevoke = array_diff($oldPermission,$request['permissions']);

            if($permissionsToRevoke){
                foreach($permissionsToRevoke as $revokePermission){
                    $role->revokePermissionTo($revokePermission);       
                }
            }

            // Adding new permissions
            if($request->has('permissions'))
            {
                $role->givePermissionTo($request['permissions']);
            }
        */   
        return response('success',200);
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

    public function getAssociatedRolesPermissions($role_id)
    {
        $role = $this->role::find($role_id);
        $permissions = $role->getAllPermissions();

        $data = [
            'name' => $role->name,
            'permissions' => $permissions
        ];

        return response()->json($data,200);
      
    }

    
}
