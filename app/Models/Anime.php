<?php

namespace App\Models;

use App\Observers\Anime\AnimeObserver;
use App\Traits\AnimeAndDoramaTrait;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([AnimeObserver::class])]
class Anime extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AnimeAndDoramaTrait;

    protected $fillable = [
        'slug',
        'poster',
        'cover',
        'title_org',
        'title_ru',
        'title_en',
        'type_id',
        'genre_id',
        'studio_id',
        'country_id',
        'age_rating',
        'episodes_released',
        'episodes_total',
        'duration',
        'release',
        'description',
        'status',
        'rating',
        'count_assessments',
        'is_comment',
        'is_rating',
    ];

    public $timestamps = true;

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'anime_country');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(AnimeRating::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(FavoriteAnime::class);
    }

    public function episodes(): HasMany
    {
        return $this->hasMany(AnimeEpisode::class);
    }

}
