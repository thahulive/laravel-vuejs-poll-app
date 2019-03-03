<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'poll_id', 'option'
    ];
    
    public function poll()
    {
        return $this->belongsTo('App\Models\Poll');
    }
    public function votes()
    {
        return $this->hasMany('App\Models\Vote');
    }
}
