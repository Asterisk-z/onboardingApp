<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function toArray(){
        return [
            "id" => $this->id,
            "name" => $this->name
        ];
    }
}
