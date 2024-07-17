<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Player extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 640, 260)
            ->performOnCollections('player_image');
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('player_image')
            ->singleFile();
    }

    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function playerContract()
    {
        return $this->hasOne(PlayerContract::class);
    }

    public function playerContracts()
    {
        return $this->hasMany(PlayerContract::class);
    }

    public function teamPlayerPoint()
    {
        return $this->hasOne(TeamPlayerPoint::class, 'player_id', 'id');
    }

    public function teamPlayerPoints()
    {
        return $this->hasMany(TeamPlayerPoint::class, 'player_id', 'id');
    }

    public function fixtureLineupPlayer()
    {
        return $this->hasOne(FixtureLineupPlayer::class, 'player_id', 'id');
    }

    public function playerStatus()
    {
        return $this->hasOne(PlayerStatus::class, 'player_id', 'id')
                    ->whereDate('start_date', '<=', Carbon::today()->toDateString())
                    ->where(function ($query) {
                        $query->whereDate('end_date', '>=', Carbon::today()->toDateString())
                            ->orWhereNull('end_date');
                    });
        // ->whereDate('end_date', '>=', Carbon::today()->toDateString());
    }

    public function currentPlayerPosition()
    {
        return $this->hasOne(PlayerContract::class)
                    ->whereDate('start_date', '<=', Carbon::today()->toDateString())
                    ->where(function ($query) {
                        $query->whereDate('end_date', '>=', Carbon::today()->toDateString())
                            ->orWhereNull('end_date');
                    });
    }

    public function getPlayerCrest()
    {
        if(config('filesystems.disks.s3.bucket') === 'fantasyleague-qa') {

            return asset('/img/player-image.png');
        }

        $player = $this->getMedia('player_image')->last();

        if ($player) {

            return $player->getUrl('thumb');
        }

        return asset('/img/player-image.png');
    }
}
