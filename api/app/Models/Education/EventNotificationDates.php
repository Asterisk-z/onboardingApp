<?php

namespace App\Models\Education;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventNotificationDates extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function event()
    {
        return $this->belongsTo(Event::class)->where('is_del', 0);
    }
}
