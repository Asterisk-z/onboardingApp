<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    // protected $guarded = ['id'];
    protected $table = 'audit';
    public $timestamps = false;
    protected $guarded = [];
}
