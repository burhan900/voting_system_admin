<?php
/**
 * Created by PhpStorm.
 * User: burhan
 * Date: 9/2/18
 * Time: 4:39 PM
 */
namespace App\helper;
use App\Poll;
use App\PollOptions;
use App\Vote;
use Illuminate\Support\Facades\Auth;
class PollHandler
{
    public static function createPollsHandler($request){

        try{
            $exipryDateTimeStamp =  \Carbon\Carbon::parse( $request['expiry_datetime'])->timestamp;
            $rowCount = Poll::get()->count() + 1;

            $poll = new Poll([
                'id' => $rowCount,
                'question' => $request['question'],
                'expire_timestamp' => $exipryDateTimeStamp,
                'created_by_name' => Auth::guard('admin')->user()->name,
                'created_by_id' => Auth::guard('admin')->user()->id,
            ]);
            $poll->save();
            $pollId = $poll->id;
            foreach ($request['options'] as $option){
                $pollOptions = new PollOptions([
                    'answer' => $option,
                    'poll_id' => $pollId
                ]);
                $pollOptions->save();
            }
            return true;
        }catch (\Exception $e) {
            print $e->getMessage();die;
            return false;
        }

    }
    public static function updatePollHandler($request,$pollID){

        try {
            $oPoll = Poll::find($pollID);
            $exipryDateTimeStamp = \Carbon\Carbon::parse($request['expiry_datetime'])->timestamp;
            if ($oPoll->question != $request['question']) {
                $oPoll->question = $request['question'];
            }
            if ($oPoll->expire_timestamp != $exipryDateTimeStamp) {
                $oPoll->expire_timestamp = $exipryDateTimeStamp;
            }
            $oPoll->update();

            foreach ($request['options'] as $key => $option) {
                PollOptions::updateOrCreate(['answer' => $option,'poll_id' => $pollID])->where('id',$key)->where('poll_id' , $pollID);
            }
        }catch (\Exception $e) {
            return false;
        }
        return true;
    }
    public static function VoteHandler($request){
        try{
            Vote::create([
                'user_id' =>$request['user_id'],
                'poll_options_id' => $request['option_id'],
            ]);
            $pollOptions = PollOptions::find($request['option_id']);
            $pollOptions->votes +=1;
            $pollOptions->update();
            return true;
        }catch(\Exception $e) {
            return false;
        }
    }

}