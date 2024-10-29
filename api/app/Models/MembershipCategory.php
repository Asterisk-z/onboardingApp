<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const DEACTIVATE = "1";
    const ACTIVATE = "0";
    const CATEGORIES = [
        "DEALING_MEMBER_BANK" => 1,
        "DEALER_MEMBER_SPECIALIST" => 2,
        "ASSOCIATE_MEMBER_BROKERS" => 3,
        "ASSOCIATE_MEMBER_INTER_DEALERS_BROKERS" => 4,
        "ASSOCIATE_MEMBER_CLIENTS" => 5,
        "REGISTRATION_MEMBER_LISTINGS" => 6,
        "REGISTRATION_MEMBER_QUOTATIONS" => 7,
        "REGISTRATION_MEMBER_LISTINGS_QUOTATIONS" => 8,
        "AFFILIATE_MEMBER_STANDARD_INDIVIDUAL" => 9,
        "AFFILIATE_MEMBER_STANDARD_CORPORATE" => 10,
        "AFFILIATE_MEMBER_FOREIGN_EXCHANGE_TRADING" => 11,
        "AFFILIATE_MEMBER_FIXED_INCOME" => 12,
        "AFFILIATE_MEMBER_REGULATOR" => 13,
        "FOREIGN_EXCHANGE_CORPORATE" => 14,
        "DEALER_MEMBER_NON_BANK" => 15,
    ];

    // protected $with = ['positions'];
    protected $appends = ['active'];

    public function institutions()
    {
        return $this->belongsToMany(Institution::class, 'institution_memberships', 'membership_category_id', 'institution_id');
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'membership_category_postitions', 'category_id', 'position_id');
    }

    public function getActiveAttribute()
    {
        return !$this->is_del ? true : false;
    }

    public function fields()
    {
        return $this->hasMany(ApplicationField::class, 'category');
    }
}
