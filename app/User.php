<?php

namespace App;

use App\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'identificator', 'email', 'password', 'email_verified_at', 'account_type',
        'subscription_status', 'trial_version_status', 'created_at', 'updated_at', 'avatar'
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
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relation with Role model
     *
     */
    public function roles() {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Methods between User and Role models
     *
     */
    public function authorizeRoles($roles) {
        abort_unless($this->hasAnyRole($roles), 401);
        return true;
    }

    public function hasAnyRole($roles) {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }
    public function hasRole($role) {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }
}
