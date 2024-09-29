<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Religion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function voters(): HasMany
    {
        return $this->hasMany(Voter::class);
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
