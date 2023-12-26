<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationField extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = ['field_value'];

    public function field_value()
    {
        return $this->hasOne(ApplicationFieldUpload::class, 'id', 'application_field_id');
    }
}
