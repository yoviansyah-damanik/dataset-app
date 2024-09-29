<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dpt extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function genderFull(): Attribute
    {
        return new Attribute(get: fn() => $this->gender == 'L' ? 'Laki-laki' : 'Perempuan');
    }

    public function voter(): HasOne
    {
        return $this->hasOne(Voter::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function tps()
    {
        return $this->belongsTo(Tps::class);
    }
}
