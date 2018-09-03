@extends('layouts.dashboard')

@section('content')
    <div class="main  center-align lighten-2 row no-margin-bottom">
        <div class="col s12 center-align row">
            <div class="col s4 left">
                <h4 class=" no-margin-top" style="color: #3c8dbc">
                   {{$pagename}}
                </h4>
            </div>

        </div>
        <div class="container">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
                <div class="row">
                    <div class="col s12 ">
                        <div class="card blue-grey lighten-2" style="background-color: #3c8dbc!important;">
                            <div class="card-content white-text">
                                <h5>Welcome To Admin DashBoard</h5>
                            </div>
                        </div>
                        </div>
                </div>
        </div>
    </div>
@endsection


