<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'description', 'type'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function options()
    {
        return $this->hasMany('App\Models\Option');
    }

    public function votes()
    {
        return $this->hasManyThrough('App\Models\Vote', 'App\Models\Option');
    }

    public function optionRequests()
    {
        return $this->hasMany('App\Models\OptionRequest');
    }

}
