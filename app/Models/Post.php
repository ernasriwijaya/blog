<?php
  
namespace App\Models;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
  
class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    use HasSlug;
    
  
    protected $fillable = [
        'title',
        'body',
        'slug',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->usingSeparator('_');      
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

    
