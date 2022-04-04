<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\update;

class feature extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'features';

    public function updates(){
        return $this->belongsTo(update::class, 'id');

    }
}
