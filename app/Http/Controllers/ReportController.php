<?php

namespace App\Http\Controllers;

use App\Poll;
use Illuminate\Http\Request;

use App\Http\Requests;

class ReportController extends Controller
{
    public function getVotesByDate($sDate){
        $aPollsCreated = Poll::with('options')->whereDate('created_at','=',$sDate)->get();
        return $aPollsCreated;
    }
}
