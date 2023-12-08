<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintComment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function toArray()
    {
        return [
            "id" => $this->id,
            "comment" => $this->comment,
            "commenter" => $this->user,
            'createdAt' => $this->created_at
        ];
    }

    public function complaint(){
        return $this->belongsTo(Complaint::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
