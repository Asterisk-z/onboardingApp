<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetencyFramework extends Model
{
    use HasFactory;
    protected $table = 'competency_frameworks';
    protected $guarded = [];
    protected $appends = ['active', 'ar_response'];
    protected $with = ['position_obj', 'category_obj'];

    public function getActiveAttribute()
    {
        return !$this->is_del ? true : false;
    }

    public function getArResponseAttribute()
    {
        return Competency::where('framework_id', $this->id)->where('ar_id', auth()->user()->id)->first();
    }

    public function position_obj()
    {
        return $this->hasOne(Position::class, 'id', 'position');
    }

    public function category_obj()
    {
        return $this->hasOne(MembershipCategory::class, 'id', 'member_category');
    }
}
