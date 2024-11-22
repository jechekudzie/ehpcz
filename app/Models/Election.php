<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_date', 'end_date', 'status'];

    public function electionGroups()
    {
        return $this->hasMany(ElectionGroup::class);
    }

}