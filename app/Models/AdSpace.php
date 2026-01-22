<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdSpace extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'position',
        'type',
        'status',
        'description'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }
}