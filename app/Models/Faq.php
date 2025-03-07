<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\Contracts\Sitemapable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model implements Sitemapable
{
    use HasFactory;

    protected $connection = 'mongodb'; // Zorg dat het de MongoDB connectie gebruikt
    protected $collection = 'faqs'; // Specificeer de MongoDB collectie

    protected $fillable = ['title', 'content', 'slug'];

    public function getIntroAttribute()
    {
        $content = explode('<pre>', $this->content);
        return $content[0] ?? '';
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
