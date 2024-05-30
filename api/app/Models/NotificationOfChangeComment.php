<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationOfChangeComment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function toArray()
    {
        return [
            "id" => $this->id,
            "comment" => $this->comments,
            "commenter" => $this->user,
            'createdAt' => $this->created_at,
        ];
    }

    public function change()
    {
        return $this->belongsTo(NotificationOfChange::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
