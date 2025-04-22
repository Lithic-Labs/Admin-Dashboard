<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Reward;

class Reward_details extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function reward()
    {
        return $this->belongsTo(Reward::class,'reward_id');
    }
}
