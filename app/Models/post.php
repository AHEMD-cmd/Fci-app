<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function reply(){

        return $this->hasMany(reply::class);
    }
}
