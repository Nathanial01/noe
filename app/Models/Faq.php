<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable; // Using Mango's auth base
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\Contracts\Sitemapable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Authenticatable implements Sitemapable
{
    use HasFactory;

    // Use the MongoDB connection
    protected $connection = 'mongodb';

    // Specify the MongoDB collection name
    protected string $collection = 'faqs';

    public function getIntroAttribute()
    {
        $content = explode('<pre>', $this->content);
        return $content[0];
    }

    public function toSitemapTag(): Url|string|array
    {
        return route('website.knowledge.show', $this);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
