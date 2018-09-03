<?php

namespace App\Http\Controllers;
use App\Poll;
use App\PollOptions;
use App\Vote;
use App\helper\PollHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {

        $aPollsData = Poll::with('options')->limit(10)->skip(0)->orderBy('created_at', 'desc')->withCount('options')->get();

        foreach($aPollsData as $poll){
            $sumVotes = $poll['options']->sum('votes');
            $poll['sum_votes'] = $sumVotes;
        }
        $iPollsCount = Poll::all()->count();
        return view('poll.index',['polls'=>$aPollsData,'pagename'=>'Available Polls','count' => $iPollsCount]);
    }
    //this function is used for rendering view partial to use it in ajax call
    public function ajaxPoll($offset){
        $resposne = [];
        try{
            if($offset <= 0){
                $resposne['status'] = false;
                $resposne['message'] = 'Offset '.$offset.' Not Correct';
            }
            $aPollsData = Poll::with('options')->limit(10)->skip(intval($offset))->orderBy('created_at', 'desc')->withCount('options')->get();

            foreach($aPollsData as $poll){
                $sumVotes = $poll['options']->sum('votes');
                $poll['sum_votes'] = $sumVotes;
            }

            $iPollsCount = Poll::all()->count();
            $resposne['status'] = true;
            $resposne['data'] = view('poll.ajax-poll',['polls'=>$aPollsData,'pagename'=>'Available Polls','count' => $iPollsCount])->render();
        }catch (\Exception $e){
            $resposne['status'] = false;
            $resposne['message'] = 'Something Went Wrong, Please Try again Later';
        }
        return json_encode($resposne);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('poll.create',['pagename' => 'Create Poll']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate poll input
        $this->validate($request,[
            'question' => 'required',
            'expiry_datetime' => 'required',
            'options' => 'required',
        ]);

        //create poll handler to create polls and options
        PollHandler::createPollsHandler($request);

        return redirect('/admin/poll')->with('message', 'Poll added successfully ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        try{
            $oPoll = Poll::find($id);
            if(!empty($oPoll)){
                $aPollData = Poll::where('id',$id)->with('options')->get();
                return view('poll.edit',['polls'=>$aPollData,'pagename'=>'Edit Polls']);
            }else{
                $sMessage = 'Poll Not Found';
                $sType = 'danger';
            }
        }catch (\Exception $e){
            $sMessage = 'Something Went Wrong , Please Try Again Later ';
            $sType = 'danger';
        }
        return redirect('/admin/poll')->with($sType, $sMessage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'question' => 'required',
            'expiry_datetime' => 'required',
            'options' => 'required',
        ]);
        PollHandler::updatePollHandler($request,$id);
        return redirect('/admin/poll')->with('message', 'Poll Updated successfully ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sMessage = 'Poll Deleted successfully';
        $sType = 'message';
        try{
            // check at first if the poll avalible
            $oPoll = Poll::find($id);
            if(!empty($oPoll)){
                //only user who created it can delete it
                if($oPoll->created_by_id == Auth::guard('admin')->user()->id) {
                    //delete votes first
                    $optionsIds = PollOptions::where('poll_id', $id)->pluck('id')->toArray();
                    //delete votes first
                    Vote::whereIN('poll_options_id',$optionsIds)->delete();
                    // delete all releated answers from pollOption Table
                    PollOptions::where('poll_id', $id)->delete();
                    // after that we delete the poll
                    $oPoll->delete();
                }else{
                    $sMessage = 'You Cant Delete This Poll Only User Who Created It Can Delete it';
                    $sType = 'danger';
                }
            }else{
                $sMessage = 'Poll Not Found';
                $sType = 'danger';
            }
        }catch (\Exception $e){
            print $e->getMessage();die;
        }
        return redirect('/admin/poll')->with($sType, $sMessage);
    }
}
