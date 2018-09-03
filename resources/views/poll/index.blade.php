@extends('layouts.dashboard')

@section('content')
    <input type="hidden" id="poll_count" value="{{$count}}">
    <div class="main  center-align lighten-2 row no-margin-bottom">
        <div class="col s12 center-align row">
            <div class="col s3 left">
                <h4 class=" no-margin-top" style="color: #3c8dbc">
                    {{$pagename}}
                </h4>
            </div>
            <div class="col s2 right">
                <a href="{{ url('/admin/poll/create') }}"
                   class="btn-floating btn-large waves-effect waves-light blue-v"><i class="material-icons">add</i></a>
            </div>

        </div>

    </div>
    @if (session('message'))
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('message') }}
        </div>
    @endif
    @if (session('danger'))
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('danger') }}
        </div>
    @endif
    <div class="container ">
        <div class="progress loader-poll blue lighten-5" style="display: none;">
            <div class="indeterminate blue-v"></div>
        </div>
        <div class="polls_cards">
            @foreach ($polls as $poll)
                <div class="row">
                    <div class="col s12 ">
                        <div class="card blue-grey lighten-2" style="background-color: #3c8dbc!important;">
                            <div class="card-content white-text">
                                <div class="right s2">
                                    <a href="{{ url('/admin/poll/edit/'.$poll->id) }}"
                                       class="btn-floating btn-small waves-effect waves-light blue-v"><i
                                                class="material-icons">edit</i></a>
                                    <a href="#modal1" onclick="pushIdToHref({{$poll->id}})"
                                       class="modal-trigger btn-floating btn-small waves-effect waves-light blue-v"><i
                                                class="material-icons">delete_forever</i></a>
                                </div>
                                <small>Poll Id : {{$poll->id}}</small>
                                <span class="card-title">{{$poll->question}}</span>


                            </div>
                            <ul class="collection">
                                @foreach($poll->options as $option)
                                    <li class="collection-item">{{$option->answer}} | @php
                                            $x = 0;
                                            if($poll->sum_votes != 0){
                                            $x = ($option->votes * 100 / ($poll->sum_votes) )  ;
                                            }
                                    echo round($x,2)." %";
                                        @endphp
                                        <div class="progress">
                                            <div class="determinate" style="width: {{$x}}%"></div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="card-content">
                                <small class="white-text">Poll Created By : {{$poll->created_by_name}}</small><br>
                                <small>Poll Expiry Date : {{date('Y/m/d H:i:s', $poll->expire_timestamp)}}</small>
                            </div>
                        </div>

                    </div>
                </div>

            @endforeach
        </div>
        <div class="progress loader-poll blue lighten-5" style="display: none;">
            <div class="indeterminate blue-v"></div>
        </div>
        <div>
            <ul class="pagination right" id="poll-pagination"></ul>
        </div>
    </div>
    <div id="modal1" class="modal bottom-sheet">
        <div class="modal-content">
            <h4>Delete Poll</h4>
            <p>Are you sure Do You Want to delete this poll ?</p>
        </div>
        <div class="modal-footer">
            <a class="btn  modal-yes waves-effect waves-green btn-flat">Yes</a>
            <a href="#!" class="modal-close waves-effect waves-green btn-flat blue-v">No</a>
        </div>
    </div>

@endsection


