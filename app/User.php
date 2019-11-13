<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Account;

/**
 * @property mixed id
 * @property mixed first_name
 * @property mixed last_name
 * @property mixed email
 * @property mixed password
 * @property mixed image_url
 * @property mixed created_by
 * @property mixed updated_by
 * @property mixed remember_token
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'image_url', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The model's default values for attributes.
     */
    protected $attributes = [
        'image_url' => ''
    ];

    protected $table = 'users';

    public function oauth() {
        return $this->hasMany(OAuth::class, 'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function hasCreated()
    {
        return $this->hasMany(User::class, 'created_by', 'id');
    }

    public function hasUpdated()
    {
        return $this->hasMany(User::class, 'updated_by', 'id');
    }

    public function ownsAccounts()
    {
        return $this->hasMany(Account::class,'updated_by','id');
    }

    public function accounts()
    {
        return $this->belongsToMany('App\Account', 'account_users');
    }

    public function sources()
    {
        return $this->hasManyThrough(Source::class, AccountUser::class, 'user_id', 'account_id', 'id', 'account_id');
    }

    public function locations()
    {
        return $this->hasManyThrough(Location::class, AccountUser::class, 'user_id', 'account_id', 'id', 'account_id');
    }

    public function ownsLocations()
    {
        return $this->hasMany(Location::class, 'updated_by', 'id');
    }
}
