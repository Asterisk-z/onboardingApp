<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceContent extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function toArray(){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'value' => $this->value,
            'type' => $this->type
        ];
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
