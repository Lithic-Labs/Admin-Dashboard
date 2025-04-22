<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reward_details;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reward extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    // Each reward belongs to a single user.
    // The user_id column in the rewards table stores the reference to the users table.
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function rewardDetails()
    {
        return $this->hasMany(Reward_details::class,'reward_id');
    }
}
