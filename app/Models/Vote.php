<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['election_id', 'practitioner_id', 'profession_category_id', 'candidate_id', 'registration_number'];

    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class);
    }

    public function category()
    {
        return $this->belongsTo(ProfessionCategory::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }


    public function professionCategory()
    {
        return $this->belongsTo(ProfessionCategory::class);
    }
}
