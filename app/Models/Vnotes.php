<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vnotes extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'note',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    } 

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }
}
