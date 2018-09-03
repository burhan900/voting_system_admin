<?php
/**
 * Created by PhpStorm.
 * User: burhan
 * Date: 9/2/18
 * Time: 12:24 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollOptions extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'poll_options';

    protected $fillable = ['answer','poll_id','votes'];
    /**
     * An option belongs to one poll
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}