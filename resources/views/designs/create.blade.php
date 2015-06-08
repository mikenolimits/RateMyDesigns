@extends('layouts.frontend')

@section('main')

    <div class="row">
        <div class="col m12">
        {!! Form::open(['files' => 'true','route' => 'designs.store']) !!}
        <div class="input-field">
        {!! Form::label('name','Design Name:') !!}
        {!! Form::text('name','',['class' => 'validate']) !!}
            @if ($errors->has('name'))
                <div class="red-text">
                    {{ $errors->first('name') }}
                </div>
            @endif
        </div>
        <div class="input-field">
        {!! Form::label('name','Design Description:') !!}
        {!! Form::textarea('description','',['class' => 'materialize-textarea']) !!}
        </div>
            <div>
                {!! Form::label('image','Design Image:') !!}
            </div>
            <div class="input-field">
                {!! Form::file('image') !!}
                @if ($errors->has('image'))
                    <div class="red-text">
                        {{ $errors->first('image') }}
                    </div>
                @endif
            </div>
            <div class="input-field">
                {!! Form::submit('Submit',['class' => 'btn btn-large']) !!}
            </div>
        {!! Form::close() !!}
        </div>
    </div>

@endsection