<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use function PHPSTORM_META\map;

class Invite extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'company_id',
        'user_id',
        'invited_by',
        'resent_at',
        'model',
        'model_id',
        'role',
        'reference',
        'permission',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
