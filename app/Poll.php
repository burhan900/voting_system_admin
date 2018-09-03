<?php
/**
 * Created by PhpStorm.
 * User: burhan
 * Date: 9/2/18
 * Time: 12:23 AM
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = ['id','question','expire_timestamp','created_at','created_by_name','created_by_id'];
    public function options()
    {
        return $this->hasMany(PollOptions::class);
    }



}