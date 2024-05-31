<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionGroup extends Model
{
    use HasFactory;
    protected $with = ['positions'];

    public function positions()
    {
        return $this->hasMany(Position::class, 'position_group_id', 'id');
    }
}
