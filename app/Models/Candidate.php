<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = ['practitioner_id', 'profession_category_id', 'election_id', 'status'];

    public function category()
    {
        return $this->belongsTo(ProfessionCategory::class, 'profession_category_id');
    }


    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class);
    }

    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    // Define the votes relationship
    public function votes()
    {
        return $this->hasMany(Vote::class, 'candidate_id'); // Link to Vote model by candidate_id
    }
}
