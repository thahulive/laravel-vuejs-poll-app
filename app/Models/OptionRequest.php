<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'poll_id', 'option', 'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function poll()
    {
        return $this->belongsTo('App\Models\Poll');
    }
}
