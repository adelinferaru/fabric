<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $table = 'movies';
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'year',
        'type',
    ];

    public function posters (): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Poster::class);
    }
}
