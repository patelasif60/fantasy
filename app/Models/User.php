<?php

namespace App\Models;

use Aecor\MasterPassword\Traits\HasMasterPassword;
use App\Enums\Role\RoleEnum;
use App\Enums\UserStatusEnum;
use App\Notifications\MailResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\ModelCleanup\GetsCleanedUp;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements GetsCleanedUp, JWTSubject
{
    use Notifiable,
        HasRoles,
        HasMasterPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'username', 'password', 'status', 'last_login_at', 'email_verified_at', 'provider', 'provider_id', 'remember_url','signin_token','auto_signin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    /**
     * Scope a query to only include superadmin users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSuperadmins($query)
    {
        return $query->role([
            RoleEnum::SUPERADMIN,
        ]);
    }

    /**
     * Scope a query to only include admin users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmins($query)
    {
        return $query->role([
            RoleEnum::SUPERADMIN,
            RoleEnum::STAFF,
        ]);
    }

    /**
     * Scope a query to only include consumer users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeConsumers($query)
    {
        return $query->role([
            RoleEnum::USER,
        ]);
    }

    /**
     * Get the default roles that should be assigned to a user.
     *
     * @return array
     */
    public static function getDefaultRoles()
    {
        return [RoleEnum::USER];
    }

    /**
     * Assign a default role to the user.
     *
     * @return $this
     */
    public function assignDefaultRole()
    {
        return $this->assignRole(static::getDefaultRoles());
    }

    /**
     * Get the operator data associated with the user,
     * in case the user has registered as consumer.
     */
    public function consumer()
    {
        return $this->hasOne(Consumer::class)->withDefault();
    }

    /**
     * Get the user invite.
     */
    public function invite()
    {
        return $this->hasOne(AdminInviteUser::class);
    }

    /**
     * Remove user where the profile is not completed within 24 hours of creation.
     */
    public static function cleanUp(Builder $query): Builder
    {
        return $query->role(RoleEnum::USER)->doesntHave('consumer')->where('created_at', '<=', Carbon::now()->subDay());
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /*
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }

    public function getPackage()
    {
        if ($this->isNewUser()) {
            return Package::find(setting('free_package'));
        } else {
            // return Package::find(setting('default_package'));
            return Package::find(Season::find(Season::getLatestSeason())->default_package);
        }
    }

    public function isNewUser()
    {
        if ($this->last_login_at == null) {
            return true;
        } else {
            //for new Social login user
            if ($this->created_at == $this->last_login_at && $this->provider != null) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function scopeActive($query)
    {
        return $query->where('status', UserStatusEnum::ACTIVE);
    }
}
