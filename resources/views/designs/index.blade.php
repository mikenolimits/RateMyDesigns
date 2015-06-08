@extends('layouts.frontend')

@section('main')
    <div class="row light-green lighten-1 padder-sm">
        <div class="col m12">
            <h1 class="center">Choose Your Favorite Design.</h1>
            <h5 class="center">Click the circle of the design you like best
            and then click "Vote" at the bottom of the screen.
            </h5>
        </div>
    </div>

    {!! Form::open(['route' => 'ratings.store']) !!}
    @foreach (array_chunk($designs->getCollection()->toArray(), 3) as $designRow)
        <div class="row padder-sm">
        @foreach ($designRow  as $design)
            <div class="col m4 card medium">
                <div class="card-image">
                    <img class="responsive-img" src="{{Request::root()}}/{{$design['image']}}"/>
                    <span class="card-title black-text teal">{{$design['name']}}</span>
                </div>

                <div class="card-content">
                  <p>{{$design['description']}}</p>
                </div>
                <div class="card-action black-text">
                    <p>
                    {!! Form::radio('design',$design['id'],false,['id' => $design['id'],'class' => 'black-text']) !!}
                    {!! Form::label($design['id'],$design['name']) !!}
                    </p>
                </div>
            </div>
        @endforeach
        </div>
    @endforeach

    <div class="row">
        <div class="col m8">
            {!! Form::submit('VOTE!',['class' => 'btn btn-large btn-block']) !!}
        </div>
        <div class="col m4">
            <a class="btn btn-large btn-block amber darken-3" href="{{route('design.results')}}">View Results!</a>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')

    <script>
        $(document).ready(function(){
            $('.parallax').parallax();
        });

    </script>

@endsection