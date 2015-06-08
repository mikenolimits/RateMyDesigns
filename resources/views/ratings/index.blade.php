@extends('layouts.frontend')

@section('main')
    <div class="row light-green lighten-1 padder-sm">
        <div class="col m12">
            <h1 class="center">Design Results</h1>
        </div>
    </div>

    <div class="row">
        <div class="col m12">
    <table class="striped centered hoverable responsive-table">
        <thead>
        <tr>
            <th data-field="name">Design Name</th>
            <th data-field="votes">Votes</th>
            <th data-field="image">Image</th>
        </tr>
        </thead>
        <tbody>
    @foreach($designs as $design)
        <tr>
            <td>{{$design['name']}}</td>
            <td>{{$design['votes']}}</td>
            <td><img height="100" src="{{Request::root()}}/{{$design['image']}}" class=""/></td>
        </tr>
    @endforeach

    </tbody>
    </table>
    </div>
    </div>
@endsection

