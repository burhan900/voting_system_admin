<?php
namespace App\Http\Controllers;
use App\Poll;
use App\User;
use Illuminate\Http\Request;
use Auth;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.index',['pagename' => 'Admin Dashboard']);
    }
    public function logout(Request $request) {
        Auth::guard('admin')->logout();
        return redirect('/');
    }

    public function dailyReports(){
        // get users with highest votes in the system
        $userData = User::with('votesRate')->withCount('votesRate')->limit(10)->get()->toArray();
        $labelNames = [];
        $xYposition = [];
        foreach ($userData as $user){
            $labelNames[] = $user['name'];
            $xYposition[] = $user['votes_rate_count'];
        }
        $jLabels = json_encode($labelNames);
        $position = json_encode($xYposition);
        return view('admin.reports',['labels' => $jLabels,'position' =>$position ,'pagename'=>'Reports Page']);
    }
}