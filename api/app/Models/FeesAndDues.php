<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesAndDues extends Model
{
    use HasFactory;
    protected $table = 'fees_and_dues';
    protected $guarded = [];
    protected $appends = ['active'];

    public function getActiveAttribute()
    {
        return !$this->is_del ? true : false;
    }
}
