<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'type', 'user_id', 'message', 'read'];

    protected $casts = [
        'read' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($notification) {
            if (empty($notification->uuid)) {
                $notification->uuid = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
