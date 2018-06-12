<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $user = User::find(Auth::id());
        $edit = true;
        return view('users.profile', compact('user', 'edit'));

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
        if (!empty($request->input('name')) && !empty($request->input('email'))) {
            $user = User::find(Auth::id());
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            
            if (!empty($request->input('password'))) {
                $user->password = bcrypt($request->input('password'));
            }
            
            $user->about = $request->input('about');
            
            if ($request->hasFile('photo')) {
                $this->validate($request, [
                  'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $image = $request->file('photo');
                $name = str_slug($request->input('name')).'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/avatars');
                $imagePath = $destinationPath. "/".  $name;
                $image->move($destinationPath, $name);
                $user->avatar = $name;
            }
            $user->save();
        }
        return back();
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
}
