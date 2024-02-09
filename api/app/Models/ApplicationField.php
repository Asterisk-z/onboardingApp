<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationField extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = ['child_fields'];
    protected $appends = ['field_options', 'field_value'];

    public function child_fields()
    {
        return $this->hasMany(ApplicationField::class, 'parent_id', 'id');
    }

    public function getFieldOptionsAttribute()
    {
        return ApplicationFieldOption::where('field_name', $this->name)->where('category', $this->category)->get();
    }

    public function getFieldValueAttribute()
    {

        return auth()->user()->institution ?
        ApplicationFieldUpload::where('application_id', auth()->user()->institution->application->id)->where('application_field_id', $this->id)->first() :
        ApplicationFieldUpload::where('application_field_id', $this->id)->first();
    }

}
