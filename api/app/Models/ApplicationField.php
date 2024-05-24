<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationField extends Model
{
    use HasFactory;
    protected $guarded = [];

    // protected $with = ['child_fields'];
    protected $appends = ['field_options', 'field_value', 'child_fields'];

    // public function child_fields()
    // {
    //     $childFields = ApplicationField::where('parent_id', $this->id)->get();
    //     return $childFields;
    //     // return $this->hasMany(ApplicationField::class, 'parent_id', 'id');
    // }

    public function getChildFieldsAttribute()
    {
        // $request = request()->all();
        // logger($request);
        $childFields = ApplicationField::where('parent_id', $this->id);
        return $childFields->get();
        // return $childFields->leftJoin('application_field_application_field_uploads', function ($join) use ($request) {
        //     $join->on('application_field_application_field_uploads.application_field_id', '=', 'application_fields.id')
        //         ->where('application_field_application_field_uploads.application_id', $request['application_id']);
        // })->leftJoin('application_field_uploads', 'application_field_application_field_uploads.application_field_upload_id', '=', 'application_field_uploads.id')
        //     ->select('application_fields.*', 'application_field_uploads.uploaded_field', DB::raw('application_field_uploads.id as application_field_upload_id'));

    }
    
    public function getChildUploadFieldsAttribute()
    {
        // $request = request()->all();
        // logger($request);
        $childFields = ApplicationField::where('id', $this->id)->first();

        

        return $childFields->get();
        // return $childFields->leftJoin('application_field_application_field_uploads', function ($join) use ($request) {
        //     $join->on('application_field_application_field_uploads.application_field_id', '=', 'application_fields.id')
        //         ->where('application_field_application_field_uploads.application_id', $request['application_id']);
        // })->leftJoin('application_field_uploads', 'application_field_application_field_uploads.application_field_upload_id', '=', 'application_field_uploads.id')
        //     ->select('application_fields.*', 'application_field_uploads.uploaded_field', DB::raw('application_field_uploads.id as application_field_upload_id'));

    }

    public function getFieldOptionsAttribute()
    {
        return ApplicationFieldOption::where('field_name', $this->name)->where('category', $this->category)->get();
    }

    public function getFieldValueAttribute()
    {

        return null;
        // return ApplicationFieldUpload::where('application_id', auth()->user()->institution->application->id)->where('application_field_id', $this->id)->first();

        // return auth()->user()->institution ?
        // ApplicationFieldUpload::where('application_id', auth()->user()->institution->application->id)->where('application_field_id', $this->id)->first() :
        // ApplicationFieldUpload::where('application_field_id', $this->id)->first();
    }

}
