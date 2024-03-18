<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ApplicationFieldApplicationFieldUpload extends Pivot
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'application_field_application_field_uploads';
}
