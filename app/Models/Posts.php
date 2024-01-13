<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'body', 'users_id'];

    public function users()
    {
        return $this->belongsTo(Users::class);
    }
}
