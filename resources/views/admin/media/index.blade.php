@extends('layouts.admin')


@section('content')

    @if(Session::has('deleted_photo'))
        <p class="text-center bg-info">{{session('deleted_photo')}} <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></p>
    @endif


    <h1>Media</h1>

    @if($photos)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Owned</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach($photos as $photo)
              <tr>
                  <td>{{$photo->id}}</td>
                  <td><img style="height: 50px; width: 50px;" class="img-responsive img-rounded" src="{{$photo->file}}"> </td>
                  <td>
                      @if($photo->user || $photo->post)
                          <span style="color:green">Yes</span>
                      @else
                         <span style="color: red;">No</span>
                      @endif
                  </td>
                  <td>{{$photo->created_at ? $photo->created_at->diffForHumans() : 'No date'}}</td>

                  <td>
                      {!! Form::model($photo, ['method'=>'DELETE', 'action'=>['AdminMediasController@destroy', $photo->id]]) !!}
                      <div class="form-group">
                          {!! Form::submit('X', ['class'=>'btn btn-danger']) !!}
                      </div>
                      {!! Form::close() !!}
                  </td>

              </tr>
                    @endforeach
            </tbody>
         </table>
    @endif


@endsection