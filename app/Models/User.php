<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use ESolution\DBEncryption\Traits\EncryptedAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Notifiable, EncryptedAttribute;

    public $incrementing = false;
    protected $encryptable = [
        'username',
        'email',
        'fullname'
    ];

    /**
     * The "booting" function of model
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4();
        });
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'fullname',
        'email',
        'last_login',
        'password',
        'district_id',
        'village_id',
        'tps_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_login' => 'datetime',
    ];

    // protected $dates = ['deleted_at'];

    public function getRoleNameAttribute(): string
    {
        return $this->roles[0]->name;
    }

    public function getPermissionsAttribute(): Collection
    {
        return $this->roles[0]->permissions->pluck('name');
    }

    public function getVotersCountAttribute(): int
    {
        switch ($this->role_name) {
            case "Administrator":
                return Voter::where('district_id', $this->district_id)
                    ->count();
            case "Administrator Keluarga":
                return Voter::where('family_coor_id', auth()->user()->id)
                    ->count();
            case "Koordinator Kecamatan":
                return Voter::where('district_id', $this->district_id)
                    ->orWhere('district_coor_id', auth()->user()->id)
                    ->count();
            case "Koordinator Kelurahan/Desa":
                return Voter::where(fn($q) => $q->where('district_id', $this->district_id)
                    ->where('village_id', $this->village_id))
                    ->orWhere('village_coor_id', auth()->user()->id)
                    ->count();
            case "Koordinator TPS":
                return Voter::where(fn($q) => $q->where('district_id', $this->district_id)
                    ->where('village_id', $this->village_id)
                    ->where('tps_id', $this->tps_id))
                    ->orWhere('tps_coor_id', auth()->user()->id)
                    ->count();
            case "Tim Bersinar":
                return Voter::where('team_id', $this->id)
                    ->count();
            default:
                return Voter::count();
        }
    }

    public function voters(): HasMany
    {
        // switch ($this->role_name) {
        //     case "Administrator":
        //         return $this->hasMany(Voter::class, 'district_id', 'district_id');
        //     case "Koordinator Kecamatan":
        //         return $this->hasMany(Voter::class, 'district_id', 'district_id');
        //     case "Koordinator Kelurahan/Desa":
        //         return $this->hasMany(Voter::class, 'village_id', 'village_id');
        //     case "Koordinator TPS":
        //         return $this->hasMany(Voter::class, 'tps_id', 'tps_id');
        //     default:
        return $this->hasMany(Voter::class);
        // }
    }

    public function voters_by_team(): HasMany
    {
        return $this->hasMany(Voter::class, 'team_id', 'id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function tps(): BelongsTo
    {
        return $this->belongsTo(Tps::class);
    }
}
