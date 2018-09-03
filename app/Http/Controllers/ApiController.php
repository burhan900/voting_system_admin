<?php

namespace App\Http\Controllers;

use App\helper\PollHandler;
use App\helper\UserHandler;
use App\Poll;
use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;

class ApiController extends Controller
{
    protected $lifeTimeToken;
    protected $StatusCode;
    public function __construct()
    {
        $this->lifeTimeToken = env('AUTH', '');
    }
    public function authinticationChecker($request){
        $sAuthHeaders = $request->header('Authorization');
        if($sAuthHeaders != $this->lifeTimeToken){
            return false;
        }
        return true;
    }
    public function regeisterUser(Request $request){


        if($this->authinticationChecker($request)){
            $validation = $this->registrationValidator($request->all());
            if ($validation->fails()) {
                $this->StatusCode = 200;
                return $this->respondWithError($validation->errors());
            }
            //call user handler function to register users
            $responseUsers = UserHandler::UserRegistration($request);
            if($responseUsers['status'] == false){
                return $this->respondWithError($responseUsers['message']);
            }
            $this->StatusCode = 200;
            return $this->respondWithSuccess($responseUsers['message']);

        }else{
            $this->StatusCode = 401;
            return $this->respondWithError('Unauthorized');
        }
    }
    public function userLogin(Request $request){
        if($this->authinticationChecker($request)){
            $validation = $this->loginValidator($request->all());
            if ($validation->fails()) {
                $this->StatusCode = 200;
                return $this->respondWithError($validation->errors());
            }
            $userLoginData = UserHandler::UserLoginHandler($request);
            if(!$userLoginData){
                $this->StatusCode = 200;
                return $this->respondWithError('invalid credentials');
            }
            $this->StatusCode = 200;
            return $this->respondWithSuccess($userLoginData);
        }else {
            $this->StatusCode = 401;
            return $this->respondWithError('Unauthorized');
        }
    }
    private function voteValidator($data)
    {
        return Validator::make($data, [
            'poll_id' => 'required',
            'user_id' => 'required',
            'option_id' => 'required',
        ]);
    }
    private function loginValidator($data)
    {
        return Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    }
    private function registrationValidator($data)
    {
        return Validator::make($data, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|between:6,12|regex:/^[A-Za-z0-9@!#\$%\^&\*]+$/',

        ]);
    }
    public function getPolls(Request $request){
        if($this->authinticationChecker($request)){
            $limt = intval($request->input('limit'));
            $offset = intval($request->input('offset'));
            $user_id = intval($request->input('user_id'));
            $aPollsData = Poll::with('options')->limit($limt)->skip($offset)->orderBy('created_at', 'desc')->withCount('options')->get();
            $iPollsCount = Poll::get()->count();
            foreach($aPollsData as $poll){
                $sumVotes = $poll['options']->sum('votes');
                $poll['sum_votes'] = $sumVotes;
                //check if user has voted in one of the options
                if(!empty($poll['options'])){
                    foreach ($poll['options'] as $option){
                        $user_voted = Vote::where('poll_options_id',$option['id'])->where('user_id',$user_id)->get()->toArray();
                        if(!empty($user_voted)){
                            $poll['user_voted'] = $option['id'];
                            break;
                        }else{
                            $poll['user_voted'] = 0;
                        }
                    }
                }
            }
            $response['data'] = $aPollsData;
            $response['count'] = $iPollsCount;
            $this->StatusCode = 200;
            return response()->json(['status' => true,'result'=>$response])->setStatusCode($this->StatusCode);
        }else{
            $this->StatusCode = 401;
            return $this->respondWithError('Unauthorized');
        }


    }
    public function vote(Request $request){
        if($this->authinticationChecker($request)){
            $validation = $this->voteValidator($request->all());
            if ($validation->fails()) {
                $this->StatusCode = 200;
                return $this->respondWithError($validation->errors());
            }
            $voteHnadler = PollHandler::VoteHandler($request);
            if(!$voteHnadler){
                $this->StatusCode = 200;
                return $this->respondWithError('Something Went Wrong While Voting , Please Try Again Later');
            }
            $this->StatusCode = 200;
            return $this->respondWithSuccess('Voted Successfully');

        }else{
            $this->StatusCode = 401;
            return $this->respondWithError('Unauthorized');
        }
    }
    protected function respondWithError($error)
    {
        return response()->json(['status'=>false,'errors' => $error])->setStatusCode($this->StatusCode);
    }
    protected function respondWithSuccess($data)
    {
        return response()->json(['status'=>true,'data' => $data])->setStatusCode($this->StatusCode);
    }
}
