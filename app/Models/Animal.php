<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Arrayable;

class Animal extends Model implements Arrayable
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'cat_animal';

    protected $fillable = [
        'name',
        'sound'
    ];
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sound' => $this->sound
        ];
    }
}
