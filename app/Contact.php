<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [ 'user1_id', 'user2_id', 'room_id'];

    protected $with = ['user1', 'user2', 'room'];

    public function user1()
    { 
        return $this->belongsTo(User::class);
    }

    public function user2()
    { 
        return $this->belongsTo(User::class);
    }

    public function room()
    { 
        return $this->belongsTo(Room::class);
    }
    
    public function scopeFor($query, $user_id)
    {
        return $query->where('user1_id', $user_id)->orWhere('user2_id',$user_id);
    }
}
