<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invite extends Authenticatable
{
    use HasFactory;

    // Use the MongoDB connection
    protected $connection = 'mongodb';

    // Define the collection name (defaults to "invites" if not set)
    protected string $collection = 'invites';

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
