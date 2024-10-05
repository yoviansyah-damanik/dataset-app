<?php

namespace App\Models;

use App\Helpers\GeneralHelper;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

class Voter extends Model
{
    use HasFactory, EncryptedAttribute;

    protected $guarded = ['id'];
    protected $keyTape = 'string';
    protected $casts = [
        'id' => 'string',
        'date_of_birth' => 'date'
    ];

    protected $encryptable = [
        'nik',
        'name',
        'address',
        'phone_number',
        'image'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            $item->id = Uuid::uuid4()->toString();
            // $item->nik = Crypt::encryptString($this->nik);
            // $item->name = Crypt::encryptString($this->name);
        });
    }

    // public function nik(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => Crypt::decryptString($value)
    //     );
    // }

    public function getUmurAttribute()
    {
        return GeneralHelper::get_age($this->date_of_birth);
    }

    public function getKtpPathAttribute()
    {
        if ($this->ktp) {
            if (!filter_var($this->ktp, FILTER_VALIDATE_URL)) {
                return url($this->ktp);
            }

            return $this->ktp;
        }
    }

    public function getKkPathAttribute()
    {
        if ($this->kk) {
            if (!filter_var($this->kk, FILTER_VALIDATE_URL)) {
                return url($this->kk);
            }

            return $this->kk;
        }
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

    // public function villages()
    // {
    //     return $this->hasManyThrough(Village::class, District::class);
    // }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function district_coor()
    {
        return $this->belongsTo(User::class, 'district_coor_id', 'id');
    }
    public function village_coor()
    {
        return $this->belongsTo(User::class, 'village_coor_id', 'id');
    }
    public function tps_coor()
    {
        return $this->belongsTo(User::class, 'tps_coor_id', 'id');
    }

    public function team_by()
    {
        return $this->belongsTo(User::class, 'team_id', 'id');
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class);
    }

    public function profession(): BelongsTo
    {
        return $this->belongsTo(Profession::class);
    }

    public function marital_status(): BelongsTo
    {
        return $this->belongsTo(MaritalStatus::class);
    }

    public function nasionality(): BelongsTo
    {
        return $this->belongsTo(Nasionality::class);
    }

    public function mediables(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function dpt(): BelongsTo
    {
        return $this->belongsTo(Dpt::class);
    }
}
