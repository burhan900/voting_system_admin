@extends('layouts.dashboard')

@section('content')

    @if (count($errors))
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ $errors->all()[0] }}
        </div>
    @endif
    <div class="main  center-align lighten-2 row no-margin-bottom">
        <div class="col s12 center-align row">
            <div class="col s3 left">
                <h4 class=" no-margin-top" style="color: #3c8dbc">
                    {{$pagename}}
                </h4>
            </div>


        </div>

        <div class="container">

            <div class="row">
                <form action="{{url('admin/poll/update/'.$polls[0]->id)}}" method="POST" role="form" >

                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="col s12 ">
                        <div class="row">

                            <div class="input-field col s12">
                                <textarea id="question" name="question" class="materialize-textarea" required >{{ $polls[0]->question  }}</textarea>
                                <label for="question">Your Question</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="expiry_datetime" name="expiry_datetime" value="{{ date('Y-m-d H:i:s',$polls[0]->expire_timestamp)  }}" required >
                                <label for="expiry_datetime">Select Expiry Date</label>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <br>
                        <div class="row">
                            <div class="col s4 right">
                                <button class="waves-effect waves-light blue-v btn add_more_question">Add More Answers</button>
                            </div>
                        </div>

                        <div class="divider"></div>
                        <div class="answers">
                            <div class="row">
                                @foreach($polls[0]->options  as $key => $option)
                                    <div class="input-field col s12">
                                        <input type="text" id="option_{{$key}}" name="options[{{$option->id}}]" value="{{$option->answer}}" required >
                                        <label for="option_{{$key}}">Answer {{$key + 1}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="divider"></div>
                        <br>
                        <div class="row">

                            <div class="col s12">
                                <button type="submit" class="waves-effect waves-light blue-v btn ">Update Poll</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


