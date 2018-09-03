<?php
/**
 * Created by PhpStorm.
 * User: burhan
 * Date: 9/2/18
 * Time: 12:24 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id','poll_options_id'];
    protected $table = 'votes';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}