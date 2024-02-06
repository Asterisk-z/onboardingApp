<?php

namespace App\Models\Education;

use App\Http\Resources\Education\EventResource;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventInvitePosition extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $with = ['position'];

    public function event()
    {
        return $this->belongsTo(Event::class)->where('is_del', 0);
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

}
