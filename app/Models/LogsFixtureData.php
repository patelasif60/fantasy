<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogsFixtureData extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logs_fixture_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public static function begin()
    {
        return static::create([
            'start_time' => now(),
            'status' => 'started',
            'end_time' => null,
            'created_by' => auth()->check() ? auth()->id() : 1,
        ]);
    }

    public function end()
    {
        return $this->update([
            'status' => 'completed',
            'end_time' => now(),
        ]);
    }

    public static function lastRun()
    {
        return static::where('status', 'completed')->orderBy('start_time', 'DESC')->limit(1)->first();
    }

    public static function lastRunStartTime($formatted = false)
    {
        if (! $lastRun = static::lastRun()) {
            return;
        }

        if ($formatted) {
            return str_replace('+00:00', 'Z', gmdate('c', strtotime($lastRun->start_time)));
        }

        return $lastRun->start_time;
    }

    public static function deltaLastRunStartTime()
    {
        return static::lastRunStartTime(true);
    }

    public static function getLatestFixtureLog()
    {
        return $this->orderBy('start_time', 'DESC')->limit(1)->first();
    }
}
