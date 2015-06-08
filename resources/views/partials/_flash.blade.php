@if(Session::has('global'))
    <div class="row">
    <div class="panel-body wrapper-lg">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <i class="fa fa-ok-sign"></i><strong>  {!! Session::get('global') !!} </strong>
        </div>
    </div>
    </div>
@endif

@if(Session::has('success'))
    <div class="row">
        <div class="card-panel wrapper-lg">
            <div class="green-text lighten-1 h3">
                <i class="fa fa-ok-sign"></i>{!! Session::get('success') !!}
            </div>
        </div>
    </div>
@endif