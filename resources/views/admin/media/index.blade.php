@extends('layouts.admin')


@section('content')

    @if(Session::has('deleted_photo'))
        <p class="text-center bg-info">{{session('deleted_photo')}} <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></p>
        @elseif(Session::has('number_photos_deleted'))
        <p class="text-center bg-info">{{session('number_photos_deleted')}} <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></p>
    @endif


    <h1>Media</h1>

    @if($photos)

        <form id="box-form" action="delete/media" method="post" class="form-inline">

            {{csrf_field()}}
            {{method_field('delete')}}

            <div class="form-group">
                <select name="checkBoxArray" id="" class="form-control">
                    <option value="delete">Delete</option>
                </select>
            </div>

            <div class="form-group">
                <input id="box-delete-btn" type="submit" class="btn-primary">
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th><input id="options" type="checkbox"></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Owned</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($photos as $photo)
                  <tr>
                      <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="{{$photo->id}}"></td>
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

        </form>
    @endif


@endsection

@section('scripts')

    <script>

        $(document).ready(function() {

            $('#options').click(function () {

                if(this.checked) {
                    $('.checkBoxes').each(function() {
                        this.checked = true;
                    });
                }
                else {
                    $('.checkBoxes').each(function() {
                        this.checked = false;
                    });
                }
            });


            $("#box-form").submit(function(event){

                if ($("#box-form input:checkbox:checked").length < 1)
                {
                    event.preventDefault();
                    alert('Please check at least one image');
                }

            });







        });

    </script>

@endsection