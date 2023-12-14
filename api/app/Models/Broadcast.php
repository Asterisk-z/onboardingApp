<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    use HasFactory;
    protected $table = 'broadcasts';
    protected $guarded = [];

    protected $with = ['category_obj', 'position_obj'];

    public function category_obj()
    {
        return $this->belongsTo(MembershipCategory::class, 'category');
    }

    public function position_obj()
    {
        return $this->belongsTo(Position::class, 'position');
    }

}
