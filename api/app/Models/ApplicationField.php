<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationField extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = ['field_value', 'child_fields'];
    protected $appends = ['field_options'];

    public function field_value()
    {
        return $this->hasOne(ApplicationFieldUpload::class, 'application_field_id', 'id');
    }

    public function child_fields()
    {
        return $this->hasMany(ApplicationField::class, 'parent_id', 'id');
    }

    public function getFieldOptionsAttribute()
    {
        return ApplicationFieldOption::where('field_name', $this->name)->where('category', $this->category)->get();
    }
}
