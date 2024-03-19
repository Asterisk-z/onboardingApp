<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArCreationRequest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function toArray()
    {
        return [
            "id" => $this->id,
            "mbg_status" => $this->mbg_status, 
            "msg_status" => $this->msg_status,
            "status" => $this->status,
            "system" => $this->system 
        ];
    }

    public function system() {
        return $this->belongsTo(FmdqSystems::class, 'system_id');
    }
}
