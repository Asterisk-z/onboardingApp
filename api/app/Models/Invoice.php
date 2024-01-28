<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function toArray(){
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'reference' => $this->reference,
            'date_paid' => $this->date_paid,
            'is_paid' => $this->is_paid,
            'contents' => $this->contents
        ];
    }

    public function invoiceable()
    {
        return $this->morphTo();
    }

    public function contents(){
        return $this->hasMany(InvoiceContent::class);
    }
}
