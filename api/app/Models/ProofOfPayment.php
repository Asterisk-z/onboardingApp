<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProofOfPayment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function toArray(){
        return [
            'id' => $this->id,
            'proof' => $this->proof ? config('app.url') .'/storage/app/public/'.$this->proof : null,
            'dateUpload' => Carbon::parse($this->created_at)->format('M. j, Y')
        ];
    }
    public function proofable()
    {
        return $this->morphTo();
    }
}
