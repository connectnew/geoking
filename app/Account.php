<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\CreatedByUpdatedByRelationships;

/**
 * Class Account
 * @package App
 *
 * @property
 * @property int id
 * @property int type_id
 * @property int domain_id
 * @property string name
 * @property string website
 * @property string phone
 * @property string country
 * @property string province
 * @property string city
 * @property string address
 * @property string postal_code
 * @property int created_by
 * @property int updated_by
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed deleted_at
 */
class Account extends Model
{
    use SoftDeletes, CreatedByUpdatedByRelationships;

    protected $fillable = ['name', 'website', 'phone', 'country', 'province', 'city', 'address', 'postal_code',
        'type_id', 'domain_id', 'created_by', 'updated_by', 'raw_data'];

    protected $casts = [
        'raw_data' => 'array',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'account_users');
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'account_id', 'id');
    }

    public function sources()
    {
        return $this->hasMany(Source::class, 'account_id', 'id');
    }

    public function domain()
    {
        return $this->hasOne(AccountDomain::class, 'id', 'domain_id');
    }
}
