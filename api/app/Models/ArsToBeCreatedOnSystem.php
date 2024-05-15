<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsToBeCreatedOnSystem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['ar'];

    public function ar()
    {
        return $this->hasOne(User::class, 'id', 'ar_id');
    }
}
