<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;

class Media extends Model
{
    const AVAILABLE_MIMES = ['image', 'document', 'video', 'audio'];
    use EncryptedAttribute;

    protected $guarded = ['id'];
    protected $encryptable = [
        'path',
        'type',
    ];

    public function mediable()
    {
        return $this->morphTo();
    }
}
