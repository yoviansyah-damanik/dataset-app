<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Village extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function getVotersTotalAttribute()
    {
        return $this->tpses->sum('voters_total');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function tps_voters(): HasManyThrough
    {
        return $this->hasManyThrough(Voter::class, Tps::class);
    }

    public function tpses(): HasMany
    {
        return $this->hasMany(Tps::class);
    }

    public function voters(): HasMany
    {
        return $this->hasMany(Voter::class);
    }

    public function coordinators(): HasMany
    {
        return $this->hasMany(User::class)
            ->role('Koordinator Kelurahan/Desa');
    }
}
