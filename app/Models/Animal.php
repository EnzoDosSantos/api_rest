<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'cat_animal';

    protected $fillable = [
        'name',
        'sound'
    ];
}
