<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;

    protected $guarded = [];

    //has many renewal certificates
    public function renewalCertificates()
    {
        return $this->hasMany(RenewalCertificate::class);
    }
}
