<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tps extends Model
{
    use HasFactory;

    protected $table = 'tps';
    protected $guarded = ['id'];

    public function district()
    {
        return $this->hasOneThrough(District::class, Village::class, 'id', 'id', 'village_id', 'district_id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function voters()
    {
        return $this->hasMany(Voter::class);
    }

    public function coordinators(): HasMany
    {
        return $this->hasMany(User::class)
            ->role('Koordinator TPS');
    }

    public function dpts(): HasMany
    {
        return $this->hasMany(Dpt::class);
    }
}
