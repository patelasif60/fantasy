<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackagePoint extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
