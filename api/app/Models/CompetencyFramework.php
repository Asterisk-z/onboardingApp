<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetencyFramework extends Model
{
    use HasFactory;
    protected $table = 'competency_frameworks';
    protected $guarded = [];
    protected $appends = ['active'];

    public function getActiveAttribute()
    {
        return !$this->is_del ? true : false;
    }
}
