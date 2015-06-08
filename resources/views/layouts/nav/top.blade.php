<nav class="navbar navbar-inverse text-white bg-black shadow-z-3" role="navigation">
    <div class="container-fluid">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target=".navbar-responsive-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="row">
                        <span class="col-md-12">
                         <a class="navbar-brand" href="/">The Masqline</a>
                            </span>
                    </div>
                </div>

                <div class="navbar-collapse collapse navbar-responsive-collapse">
                    <ul class="nav navbar-nav navbar-center">

                        <li class="dropdown">
                        <a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle"
                           data-toggle="dropdown" style="padding-top: 0!important;padding-bottom: 0!important;">
                            <i class="fa fa-caret-down fa-2x "></i>
                            <img src="/images/brandassets/logo.png"  class="padder-sides-sm" width="60px"/>
                            <i class="fa fa-caret-down fa-2x"></i></a>
                            <ul class="dropdown-menu text-thin text-extra-sm">

                                @if($group !== 0)
                                    <li><a href="">LOGOUT</a></li>
                                @if($group === 2 || $group === 1)
                                    <li><a href="{{route('courses.create')}}">New Course</a></li>
                                    <li><a href="/instructor/{{Auth::id()}}">View Dashboard</a></li>
                                @endif

                                @else
                                  <li><a href="{{route('courses.index')}}">Discover Courses</a></li>

                                @endif
                            </ul>
                    </ul>
                    @if(!Auth::check())
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/user/register" class="btn btn-primary btn-md text-white">SIGN UP</a></li>
                        <li><a></a></li>
                        <li><a></a></li>
                        <li><a href="/user/login">LOGIN</a></li>
                    </ul>
                    @else
                        <ul class="nav navbar-nav navbar-right">
                        <li><a><span class="fa-stack fa-sm">
                                    <i class="fa fa-circle text-primary fa-stack-2x"></i>
                                    <b class="fa fa-stack-1x">M</b></span>
                                Hello, {{Auth::user()->name}}!</a></li>

                        </ul>
                    @endif
                </div>
            </div>
        </nav>