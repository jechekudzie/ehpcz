<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionCategory extends Model
{
    use HasFactory;

    protected $fillable = ['group_id', 'name'];


    public function group()
    {
        return $this->belongsTo(ElectionGroup::class);
    }

   /* public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }*/

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'profession_category_id');
    }

}
