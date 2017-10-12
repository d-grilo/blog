@extends('layouts.admin')


@section('content')

    <h1>Users</h1>

    <table class="table">
        <thead>
          <tr>
              <th>ID</th>
              <th>Photo</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Created</th>
              <th>Updated</th>
          </tr>
        </thead>
        @if($users)
            @foreach($users as $user)
                <tbody>
                    <tr>
                        <td>{{$user->id}}</td>
                        <td><img style="height: 40px;" src="{{$user->photo ? $user->photo->file : '/images/default.png'}}" class="img-responsive img-circle" alt="no photo"></td>
                        <td><a href="{{route('admin.users.edit', $user->id)}}">{{$user->name}}</a></td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role->name}}</td>
                        <td>{{$user->is_active == 1 ? 'Active' : 'Not Active'}}</td>
                        <td>{{$user->created_at->diffForHumans()}}</td>
                        <td>{{$user->updated_at->diffForHumans()}}</td>
                    </tr>
            @endforeach
        @endif
        </tbody>
     </table>

    @endsection