<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Staff extends Model
{
    use HasFactory, HasApiTokens;

    protected $guarded = [];

    public function department(){

        return $this->belongsTo(Department::class);
    }
}
