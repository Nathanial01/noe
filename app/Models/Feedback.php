<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    // Force usage of the MongoDB connection
    protected $connection = 'mongodb';

    // Specify the collection name
    protected string $collection = 'feedbacks';

    protected $fillable = [
        'user_id',
        'type',
        'phone_number',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
