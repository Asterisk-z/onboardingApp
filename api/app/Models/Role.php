<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    const MSG = 1;
    const MEG = 2;
    const FSD = 3;
    const MBG = 4;
    const ARINPUTTER = 5;
    const ARAUTHORISER = 6;
    const BLG = 7;
    const MEG2 = 8;
    const BIG = 9;
    const HELPDESK = 10;

    public function toArray()
    {
        return [
            "id" => $this->id,
            "name" => $this->name
        ];
    }
}
