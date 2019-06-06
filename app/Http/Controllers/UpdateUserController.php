<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Roles;
use Auth;
class UpdateUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request){
        
        $users = User::all();
        $roles = Roles::all()/*->toArray()*/;

        /*$currentUser =  auth()->user();
        if($currentUser){

            $currentUserRoleId = $currentUser->role_id;
            $currentUserRole = $currentUser->find($currentUserRoleId)->rola;
            $currentUserRoleName = $currentUserRole->role;
            $userRoleName = User::find(auth()->user()->role_id)->rola->role;
            //dump($currentUserRoleName);
            //dump($userRoleName);

            $userWithRole = array(
                "name" => $currentUser->name,
                "email" => $currentUser->email,
                "role" => $userRoleName,
                "role_id" => $currentUserRoleId
            );

            
        }*/
        
        $data = [];
            
        foreach($users as $user){
            
            $userWithRole = new \stdClass();
            $userWithRole->user_id = $user->id;
            $userWithRole->name = $user->name;
            $userWithRole->email = $user->email;
            $userWithRole->role_id = $user->role_id;
            $userWithRole->status = $user->status;
            $userWithRole->role_name = User::find($user->id)->rola->role;
            array_push($data,$userWithRole);

        }

        return view("pages.userList")->with(compact("roles","data"));
        
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
        $user = User::find($id);
        $this->authorize('isAdmin', $user);
        $this->validate($request, [
            /*"name" => "filled|required",
            "email" => "filled|required",*/
            "role_id" => "filled|required|integer",
            "status" => "filled|required|integer|min:0|max:1"
        ]);
    
        $user->role_id = $request->input("role_id");
        $user->status = $request->input("status");
        $user->save();

        $users = User::all();
        $roles = Roles::all();

        $data = [];
            
        foreach($users as $user){
            
            $userWithRole = new \stdClass();
            $userWithRole->user_id = $user->id;
            $userWithRole->name = $user->name;
            $userWithRole->email = $user->email;
            $userWithRole->role_id = $user->role_id;
            $userWithRole->status = $user->status;
            $userWithRole->role_name = User::find($user->id)->rola->role;
            array_push($data,$userWithRole);

        }

        return back()->with(compact("roles","data"))->with("success", "User info changed");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        
    }
}
