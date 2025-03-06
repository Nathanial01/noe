<?php

namespace App\Models;

use Spatie\Sitemap\Tags\Url;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Contracts\Sitemapable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model implements Sitemapable
{
    use HasFactory;

    public function getIntroAttribute()
    {
        $content = explode('<pre>', $this->content);
        
        return $this->content = $content[0];  
    }

    public function toSitemapTag(): Url | string | array
    {
        return route('website.knowledge.show', $this);
    }

    public function getRouteKeyName() {
        return 'slug';
    }
}
