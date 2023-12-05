<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function toArray()
    {
        return [
            "id" => $this->id,
            "body" => $this->body,
            "status" => $this->status,
            "documment" => $this->document ? config('app.url') .'/storage/'.$this->document : null,
            "comment" => $this->comments,
            'createdAt' => $this->created_at
        ];
    }

    public function comments(){
        return $this->hasMany(ComplaintComment::class, 'complaint_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
