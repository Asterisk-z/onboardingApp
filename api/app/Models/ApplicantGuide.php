<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantGuide extends Model
{
    use HasFactory;
    protected $table = 'applicant_guides';
    protected $guarded = [];
    protected $appends = ['active', 'file_path'];

    public function getFilePathAttribute()
    {
        return $this->file ? config('app.url') . '/storage/app/public/' . $this->file : null;
    }
    public function getActiveAttribute()
    {
        return !$this->is_del ? true : false;
    }
}
