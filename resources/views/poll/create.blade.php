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
                    <form action="{{url('admin/poll/store')}}" method="POST" role="form" >
                        {{ csrf_field() }}
                    <div class="col s12 ">
                        <div class="row">
                            <div class="input-field col s12">
                                <textarea id="question" name="question" class="materialize-textarea" required></textarea>
                                <label for="question">Your Question</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="expiry_datetime" name="expiry_datetime" required >
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

                                <div class="input-field col s12">
                                    <input type="text" id="option_1" name="options[0]" required >
                                    <label for="option_1">Answer 1</label>
                                </div>
                                <div class="input-field col s12">
                                    <input type="text" id="option_2" id="question" name="options[1]" required >
                                    <label for="option_2">Answer 2</label>
                                </div>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <br>
                        <div class="row">

                            <div class="col s12">
                                <button type="submit" class="waves-effect waves-light blue-v btn ">Create Poll</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
        </div>
    </div>

@endsection


