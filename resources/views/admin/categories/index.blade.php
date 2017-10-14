@extends('layouts.admin')


@section('content')

    @if(Session::has('created_category'))
        <p class="bg-info text-center">{{session('created_category')}}</p>
        @elseif(Session::has('deleted_category'))
        <p class="bg-danger text-center">{{session('deleted_category')}}</p>
        @elseif(Session::has('updated_category'))
        <p class="bg-success text-center">{{session('updated_category')}}</p>
    @endif

    <h1>Categories</h1>

    <div class="row">

        <div class="col-sm-6">

            {!! Form::open(['method'=>'POST', 'action'=>'AdminCategoriesController@store']) !!}

            <div class="form-group">
                {!! Form::label('name', 'Name:') !!}
                {!! Form::text('name', null, ['class'=>'form-control']) !!}
            </div>
            <div class="btn-group">
                {!! Form::submit('Create category', ['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}

            <div class="row">
                @include('includes.form_error')
            </div>


        </div>

        <div class="col-sm-6">

            @if($categories)
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td><a href="{{route('admin.categories.edit', $category->id)}}">{{$category->name}}</a></td>
                            <td>{{$category->created_at ? $category->created_at->diffForHumans() : 'no date'}}</td>
                            <td>{{$category->updated_at ? $category->updated_at->diffForHumans() : 'no date'}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif

        </div>

    </div> {{-- row --}}




    @endsection

