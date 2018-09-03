
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
