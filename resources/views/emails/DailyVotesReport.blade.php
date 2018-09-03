

<html>
<head>
</head>
<body>
<div class="container ">
<div class="polls_cards">
    @foreach ($polls as $poll)
        <div class="row">
            <div class="col s12 ">
                <div style="width: 320px;padding: 10px;border: 5px solid gray;margin: 0;" class="box lighten-2" >
                    <div class="card-content white-text">
                        <div class="right s2">

                        </div>
                        <small>Poll Id : {{$poll->id}}</small>
                        <br>
                        <span class="card-title">{{$poll->question}}</span>


                    </div>
                    <ul class="collection">
                        @foreach($poll->options as $option)
                            <li class="collection-item">{{$option->answer}}
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
        <br>
    @endforeach
</div>
</div>
</body>
<style>
    .box {
        width: 320px;
        padding: 10px;
        border: 5px solid gray;
        margin: 0;
    }
</style>
</html>