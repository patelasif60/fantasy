<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Club extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $with = ['activePlayers'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'api_id' => 'string',
        'short_name' => 'string',
        'short_code' => 'string',
        'is_premier' => 'boolean',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 250, 250)
            ->performOnCollections('crest');
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('crest')
            ->singleFile();
    }

    /**
     * Scope a query to only include premier league clubs.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePremier($query)
    {
        return $query->where('is_premier', true);
    }

    /**
     * The players that have or have had contracts with the club.
     */
    public function players()
    {
        return $this->belongsToMany(Player::class, 'player_contracts', 'club_id', 'player_id')
            ->withPivot('id', 'position', 'is_active', 'start_date', 'end_date')
            ->as('contract')
            ->withTimestamps();
    }

    /**
     * The players that have active contracts with the club.
     */
    public function activePlayers()
    {
        return $this->players()
            ->wherePivot('end_date', null);
    }

    /**
     * Determine if the club can be deleted.
     *
     * @return bool
     */
    public function canBeDeleted()
    {
        return $this->activePlayers->count() === 0;
    }

    public function nextFixture($competition = '')
    {
        $club = $this;
        $nextFixture = Fixture::where(function ($query) use ($club) {
            $query->where('home_club_id', $club->id)
                                    ->orWhere('away_club_id', $club->id);
        })
                        ->where('date_time', '>', date('Y-m-d H:i:s'));
        if ($competition == 'Premier League' || $competition == 'FA Cup') {
            $nextFixture = $nextFixture->where('competition', $competition);
        }
        $nextFixture = $nextFixture->orderBy('date_time')
                        ->first();

        return $nextFixture;
    }

    public function nextFixtureAfterDate($competition = '', $date = '')
    {
        $club = $this;
        $nextFixture = Fixture::where(function ($query) use ($club) {
            $query->where('home_club_id', $club->id)
                                    ->orWhere('away_club_id', $club->id);
        })
                        ->where('date_time', '>=', $date ? $date : date('Y-m-d H:i:s'));
        if ($competition == 'Premier League' || $competition == 'FA Cup') {
            $nextFixture = $nextFixture->where('competition', $competition);
        }
        $nextFixture = $nextFixture->orderBy('date_time')
                        ->first();

        return $nextFixture;
    }
}
