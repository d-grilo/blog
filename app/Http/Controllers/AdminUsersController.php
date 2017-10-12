<?php

namespace App\Http\Controllers;

# Include
use App\User;
use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
use App\Role;
use App\Photo;


use Illuminate\Http\Request;

use App\Http\Requests;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin/users/index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = Role::pluck('name', 'id')->all();



        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    # UsersRequest(custom request class) for this store method
    public function store(UsersRequest $request)
    {

        # Object representing all user input
        $input = $request->all();


        # Check if a file was submitted with the name 'photo_id'
        if($request->file('photo_id')) {

            # Create a new object for that
            $file = $request->file('photo_id');

            # Create the name of the file by concatenating the time + the original name of the file
            $name = time() . $file->getClientOriginalName();

            # Move the file to the public directory images with the name of the variable
           $file->move('images', $name);

           # Mass assignment creation of the file(photo)
           $photo = Photo::create(['file'=>$name]);

           # Assign the ID of the photo to the input object
           $input['photo_id'] = $photo->id;
        }

        # Encrypt the password attribute of the input object
        $input['password'] = bcrypt($request->password);

        # Mass assignment creation of a user using the input object
        User::create($input);

        # Redirect
        return redirect('/admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.users.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = User::findOrFail($id);
        $roles = Role::lists('name', 'id')->all();


        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {

        $user = User::findOrFail($id);

        # Check if the password field is empty
        if(trim($request->password) == '') {

            # If it's empty, the input is equal to everything expect the password field
            $input = $request->except('password');
        }
        # In case the password isn't empty
        else {
            # Input includes everything from request
            $input = $request->all();
            # and hashes the password field
            $input['password'] = bcrypt($request->password);
        }


        if($request->file('photo_id')) {

            $file = $request->file('photo_id');

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file'=>$name]);

            $input['photo_id'] = $photo->id;

        }

        $user->update($input);


        return redirect('/admin/users');

        //return $request->all();


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
