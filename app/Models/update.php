<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\feature;

class update extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'updates';
      //Relasi antar table
    public function features(){
        return $this->hasMany(feature::class, 'note_id', 'id');
    }
}
