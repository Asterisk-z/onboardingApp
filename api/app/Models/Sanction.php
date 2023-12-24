<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanction extends Model
{
    use HasFactory;
    protected $table = 'sanctions';
    protected $guarded = [];

    protected $with = ['institution_obj', 'sanctioner', 'sanctionee'];
    protected $appends = ['evidence_file'];

    public function institution_obj()
    {
        return $this->hasOne(Institution::class, 'id', 'institution');
    }

    public function sanctioner()
    {
        return $this->hasOne(User::class, 'email', 'created_by');
    }

    public function sanctionee()
    {
        return $this->hasOne(User::class, 'id', 'ar');
    }
    public function getEvidenceFileAttribute()
    {
        return $this->evidence ? config('app.url') . '/storage/app/public/' . $this->evidence : null;
    }
}
