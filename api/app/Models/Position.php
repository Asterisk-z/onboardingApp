<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const DEACTIVATE = "1";
    const ACTIVATE = "0";

    public function toArray()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "active" => !$this->is_del ? true : false,
        ];
    }
}
