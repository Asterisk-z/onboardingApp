<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationExtra extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['file_path'];

    public function getFilePathAttribute()
    {
        return $this->file ? config('app.url') . '' . $this->file : null;
    }
}
