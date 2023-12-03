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
}
