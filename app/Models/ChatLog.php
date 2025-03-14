<?php

namespace App\Models;

//use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;
class ChatLog extends Model
{
    protected $connection = 'mongodb';

    // Specify a collection explicitly if needed
    protected string $collection = 'chat_logs';

    // Define mass-assignable fields
    protected $fillable = [
        'Name',              // user name
        'message',           // user message
        'response',          // Bot's response
        'subscription_tier', // user's subscription tier
        'created_at',        // Timestamp
        'updated_at',        // Timestamp
    ];
}
