<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    use HasFactory;

    protected $casts = [
        'images' => 'array',
    ];

    protected $guarded = ['id'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    /**
     * @var mixed
     */
    public function scopeIsActive($query, int $arg)
    {
        return $query->where('is_active', $arg);
    }

}
