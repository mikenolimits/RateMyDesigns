@extends('layouts.frontend')

@section('main')

<div class="container-fluid">
    <div class="row">
        <div class="col m12">
            <h2 class="center">Modify Your Settings</h2>
        </div>
    </div>

    <div class="row">
        <div class="col m4">


            @include('partials.users.profile-card')


            <ul class="collapsible" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header"><i class="fa fa-cog"></i>Personal Information</div>
                    <div class="collapsible-body">
                        <a class="btn btn-block green" href="{{route('user.settings')}}">
                            Modify Details
                        </a>
                        <a class="btn btn-block red" href="{{route('user.getPassword')}}">
                            Change Password
                        </a>
                    </div>
                </li>

                <li>
                    <div class="collapsible-header"><i class="mdi-action-credit-card"></i>Billing</div>
                    <div class="collapsible-body">
                        <a class="btn btn-block blue" href="{{route('account.billing.index')}}">View Existing</a>
                        <a class="btn btn-block green" href="{{route('account.billing.create')}}">Create New</a>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="mdi-action-polymer"></i>Subscriptions</div>
                    <div class="collapsible-body">
                        <a class="btn btn-block blue" href="{{route('user.subscriptions')}}">Manage Subscriptions</a>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="mdi-action-dns"></i>Purchases</div>
                    <div class="collapsible-body">
                        <a class="btn btn-block blue" href="{{route('user.orders.index')}}">View Purchases</a>
                    </div>
                </li>
            </ul>

        </div>

        <div class="col m8">
            @yield('body')
        </div>
    </div>

</div>

@endsection

@section('js')
    <script>
        $(".button-collapse").sideNav();
    </script>
@endsection