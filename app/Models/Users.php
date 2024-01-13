<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'username', 'email', 'city', 'zipcode', 'phone', 'website'];

    public function posts()
    {
        return $this->hasMany(Posts::class);
    }

}
