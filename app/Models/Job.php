<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'job_id',
        'price_range_min',
        'price_range_max',
        'status'
    ];

    protected $casts = [
        'images' => 'array',
    ];

}
