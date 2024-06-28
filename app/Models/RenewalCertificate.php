<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenewalCertificate extends Model
{
    use HasFactory;

    protected $guarded = [];

    //belongs to certificate type
    public function certificateType()
    {
        return $this->belongsTo(CertificateType::class);
    }

    //belong to condition
    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

}
