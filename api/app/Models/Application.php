<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];

    const AWAITINGAPPROVAL = 'Awaiting Approval';

    public function institution(){
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function uploads() {
        return $this->hasMany(ApplicationFieldUpload::class, 'application_id');
    }
}
