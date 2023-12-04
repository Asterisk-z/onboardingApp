<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function toArray()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "category" => $this->membershipCategories
        ];
    }

    public function membershipCategories()
    {
        return $this->belongsToMany(MembershipCategory::class, 'institution_memberships', 'institution_id', 'membership_category_id');
    }
}
