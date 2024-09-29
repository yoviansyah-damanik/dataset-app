<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function getVotersTotalAttribute()
    {
        return $this->tpses->sum('voters_total');
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }

    public function village_voters()
    {
        return $this->hasManyThrough(Voter::class, Village::class);
    }

    public function tpses()
    {
        return $this->hasManyThrough(Tps::class, Village::class);
    }

    public function voters()
    {
        return $this->hasMany(Voter::class);
    }

    public function coordinators(): HasMany
    {
        return $this->hasMany(User::class)
            ->role('Koordinator Kecamatan');
    }
}
