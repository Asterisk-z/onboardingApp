<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DohSignature extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'grade' => $this->grade,
            'division' => $this->division,
            'signature' => $this->signature ? config('app.url') . '/storage/app/public/' . $this->signature : null,
        ];
    }
}
