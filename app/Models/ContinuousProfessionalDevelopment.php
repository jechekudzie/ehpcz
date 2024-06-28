<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContinuousProfessionalDevelopment extends Model
{
    use HasFactory;

    protected $guarded = [];

    //renewal
    public function renewal()
    {
        return $this->belongsTo(Renewal::class);
    }

    //practitioner
    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class);
    }
}
