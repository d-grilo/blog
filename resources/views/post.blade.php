@extends('layouts.blog-post')


@section('content')

    <!-- Blog Post -->

    <!-- Title -->
    <h1>{{$post->title}}</h1>

    <!-- Author -->
    <p class="lead">
        by <a href="#">{{$post->user->name}}</a>
    </p>

    <hr>

    <!-- Date/Time -->
    <p><span class="glyphicon glyphicon-time"></span> Posted {{$post->created_at->diffForHumans()}}</p>

    <hr>

    <!-- Preview Image -->
    <img style="height: 300px; width: 900px;" class="img-responsive" src="{{$post->photo->file}}" alt="">

    <hr>

    <!-- Post Content -->
    <p>{{$post->body}}</p>

    <hr>

    @if(Session::has('comment_created'))
    <p class="bg-success">{{session('comment_created')}}</p>
    @endif

    <!-- Blog Comments -->
    @if(Auth::check())
        <!-- Comments Form -->
        <div class="well">
            <h4>Leave a Comment:</h4>

            {!! Form::open(['method'=>'POST', 'action'=>'PostCommentsController@store']) !!}

            <input type="hidden" name="post_id" value="{{$post->id}}">

            <div class="form-group">
                {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>3]) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Submit comment', ['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    @endif

    <hr>

    <!-- Posted Comments -->
    @if(count($comments) > 0)

        @foreach($comments as $comment)
            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img style="height: 64px; width: 64px;" class="media-object" src="/images/{{$comment->photo}}" alt="">
                </a>
                <div class="media-body">

                    <h4 class="media-heading">{{$comment->author}}
                        <small>{{$comment->created_at->diffForHumans()}}</small>
                    </h4>

                    <p>{{$comment->body}}</p>

                    {{-- Reply button and div --}}
                    <div class="comment-reply-container">

                        <button class="toggle-reply btn btn-primary pull-right">Reply</button>

                        <div class="comment-reply">
                            {!! Form::open(['method'=>'POST', 'action'=>'CommentRepliesController@createReply']) !!}
                            <input type="hidden" name="comment_id" value="{{$comment->id}}">
                            <div class="form-group">
                                {!! Form::label('body', 'Message:') !!}
                                {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>1]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>


                    @if(count($comment->replies) > 0)

                        @foreach($comment->replies as $reply)

                            @if($reply->is_active == 1)

                            <!-- Nested Comment -->
                                <div class="media">
                                    <a class="pull-left" href="#">
                                        <img style="height: 64px; width: 64px;" class="media-object" src="/images/{{$reply->photo}}" alt="">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">{{$reply->author}}
                                            <small>{{$reply->created_at->diffForHumans()}}</small>
                                        </h4>
                                        {{$reply->body}}

                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

        @endforeach
    @endif

@endsection

@section('scripts')

    <script>

        $(".comment-reply-container .toggle-reply").click(function () {

            $(this).next().fadeToggle("fast");
        });


    </script>


@endsection