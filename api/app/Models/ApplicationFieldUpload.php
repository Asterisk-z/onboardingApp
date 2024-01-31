<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationFieldUpload extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['file_path'];

    public function getFilePathAttribute()
    {
        return $this->uploaded_file ? config('app.url') . 'storage/' . $this->uploaded_file : null;
    }
    public function field()
    {
        return $this->hasOne(ApplicationField::class, 'id', 'application_field_id');
    }
}
