<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'option_id'
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
