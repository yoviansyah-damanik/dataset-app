<?php

namespace App\Models;

use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        $agent = new Agent();
        static::creating(function ($query) use ($agent) {
            $query->code = Str::uuid();
            $query->ip_address = Request::ip();
            $query->user_id = Auth::id();
            $query->device = $agent->device();
            $query->platform = $agent->platform();
            $query->browser = $agent->browser();
        });
    }

    public static function makeHistory($description, $payload = null, $action = 'default', $ref_id = null)
    {
        $ref = $ref_id != null ? $ref_id : null;
        static::create(
            [
                'description' => $description,
                'payload' => $payload,
                'action' => $action,
                'ref_id' => $ref,
            ]
        );
    }

    public function getFullDescriptionAttribute()
    {
        $code = "<div class='small fst-italic'>($this->code)</div>";
        return $code . $this->description;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
