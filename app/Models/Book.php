<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'author', 'year', 'stock', 'image', 'description'];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}