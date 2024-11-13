<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectionGroupProfession extends Model
{
    use HasFactory;

    protected $fillable = ['group_id', 'profession_id'];

    public function group()
    {
        return $this->belongsTo(ElectionGroup::class, 'group_id');
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }
}
