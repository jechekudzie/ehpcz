<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectionGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'election_id'];


    public function election()
    {
        return $this->belongsTo(Election::class);
    }


    public function professions()
    {
        // Define the belongsToMany relationship for professions through the pivot table
        return $this->belongsToMany(Profession::class, 'election_group_professions', 'group_id', 'profession_id');
    }


    public function categories()
    {
        return $this->hasMany(ProfessionCategory::class, 'group_id');
    }



}
