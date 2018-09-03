<?php

namespace App\Console\Commands;

use App\Http\Controllers\ReportController;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
class SendReportsEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send_reports_email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dt = Carbon::create();
        $currentDate = $dt->copy()->format('Y-m-d');
        $oReport = new ReportController();
        $todayCreatedVotes = $oReport->getVotesByDate($currentDate);
        if(is_null($todayCreatedVotes)){
            print "No Votes Created Today".PHP_EOL;
            return false;
        }
        Artisan::call('view:clear');
        $subject = 'Today Created Votes Date '.$currentDate;
        Mail::send('emails.DailyVotesReport',['polls'=>$todayCreatedVotes], function ($message) use ($subject) {
            $message->from('testlaravelemail90@gmail.com', $subject);
            $message->to('m.burhan.hamed@gmail.com', $name = null)->subject($subject);
        });
    }
}
