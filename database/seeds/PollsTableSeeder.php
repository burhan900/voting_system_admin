<?php

use Illuminate\Database\Seeder;

class PollsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
            $nowTimeStamp = time();
            $nowTimeStampLater = $nowTimeStamp + 700000;
            $nowTimeStampAgo = $nowTimeStamp - 700000;
            //insert random polls
            for ($i=0;$i<= 100;$i++){
                $iPollId = ($i + 1);
                $qusetion = str_random(50).' ?';
                $randoumUserId  = mt_rand(1,1000);
                $oUsers = \App\User::find($randoumUserId);
                DB::table('polls')->insert([
                    'id' => $iPollId ,
                    'question' => $qusetion,
                    'expire_timestamp' => mt_rand($nowTimeStampAgo,$nowTimeStampLater),
                    'created_at' => date('Y-m-d H:i:s',$nowTimeStamp),
                    'created_by_name' => $oUsers->name,
                    'created_by_id' => $oUsers->id,
                ]);

            }
            //insert random answers
            $iUsersCount = \App\User::all()->count();
            for ($i=1;$i<= 100;$i++){

                $counter = 0;


                //at least 2 answers for each question
                while($counter < 4){
                    DB::table('poll_options')->insert([
                        'answer' => str_random(40).' .',
                        'poll_id' => $i,
                    ]);
                    $counter  = $counter + 1;
                }
            }
            //insert random votes
            $iPollOptionsCount = \App\PollOptions::all()->count();
            for ($i=1;$i<10000;$i++){
                $randoumUserId  = mt_rand(1,$iUsersCount);
                $randomOption = mt_rand(1,$iPollOptionsCount);
                DB::table('votes')->insert([
                    'user_id' => $randoumUserId,
                    'poll_options_id' => $randomOption,
                ]);
                $oOptions = \App\PollOptions::find($randomOption);
                $oOptions->votes = ($oOptions->votes + 1);
                $oOptions->update();
            }
        }catch (\Exception $e){
            print $e->getMessage();
        }

    }
}
