<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    use HasFactory;
    protected $table = 'broadcasts';
    protected $guarded = [];

    protected $appends = ['full_name', 'position_obj', 'category_obj'];

    public function getCategoryObjAttribute()
    {
        $positions = MembershipCategory::whereIn('id', json_decode($this->category))->get();
        return $positions;
    }

    public function getPositionObjAttribute()
    {
        $positions = Position::whereIn('id', json_decode($this->position))->get();
        return $positions;
    }

    public function getFullNameAttribute()
    {
        return "Full Name";
    }

}
