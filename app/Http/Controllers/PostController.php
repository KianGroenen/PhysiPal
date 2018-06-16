<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Comment;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderByDesc('created_at')->get();
        $users = User::all();
        $comments = Comment::all();
        return view('home', compact('posts', 'users', 'comments'));
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
        if (!empty($request->post)) {
            $post = New Post;
            $post->userid = Auth::id();
            $post->post = $request->post;

            if ($request->hasFile('photo')) {
                $this->validate($request, [
                  'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $image = $request->file('photo');
                $name = str_slug(substr($request->input('post'), 0, 30)).'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/media');
                $imagePath = $destinationPath. "/".  $name;
                $image->move($destinationPath, $name);
                $post->media = $name;
            }

            $post->save();
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Post::where('userid', $id)->orderByDesc('created_at')->get();
        $user = User::find($id);
        $users = User::all();
        $comments = Comment::all();
        return view('users.profile', compact('posts', 'user', 'comments', 'users'));
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
        $post = Post::find($id);
        if (!empty($request->post)) {
            $post->post = $request->post;
            $post->save();
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
        $post = Post::find($id);
        $post->delete();
        return back();
    }
}
