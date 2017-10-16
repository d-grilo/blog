<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PostsCreateRequest;
use App\Http\Requests\PostsEditRequest;
use App\Photo;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::lists('name', 'id')->all();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {


        # Receives the whole request
        $input = $request->all();

        # This is the authenticated user
        $user = Auth::user();

        # Takes care of receiving the photo(in case there's one)
        if($request->file('photo_id')) {

            $file = $request->file('photo_id');

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file'=>$name]);

            $input['photo_id'] = $photo->id;

        }

        # Creates a post with the input provided
        $user->posts()->create($input);

        Session::flash('created_post', 'The post has been created');

        # Redirects to posts.index
        return redirect('/admin/posts');


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
        $post = Post::findOrFail($id);

        $categories = Category::lists('name', 'id')->all();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostsEditRequest $request, $id)
    {
       $input = $request->all();

        if($request->file('photo_id')) {

            $file = $request->file('photo_id');

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file'=>'$name']);

            $input['photo_id'] = $photo->id;

        }

        Auth::user()->posts()->whereId($id)->first()->update($input);

        Session::flash('updated_post', 'The post has been updated');

        return redirect('/admin/posts');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        unlink(public_path() . $post->photo->file);

        $post->delete();

        # Create a 1 time session to tell the user the post has been deleted
        Session::flash('deleted_user', 'The post has been deleted');

        return redirect('/admin/posts');

    }



    public function post($id) {

        $post = Post::findOrFail($id);



        return view('post', compact('post'));
    }

}
