@extends('layouts.frontend')

@section('main')

    <div class="row padder-sm light-green lighten-1 ">
        <div class="col m12">
           <h1 class="center"> Remove Designs..</h1>
        </div>
    </div>

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
                        {!! Form::open(['method' => 'delete','route' => ['designs.destroy',$design['id']]]) !!}
                        {!! Form::submit('Delete!',['class' => 'btn btn-large red']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

@endsection
