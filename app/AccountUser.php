<?php


namespace App;

use App\Traits\Models\CreatedByUpdatedByRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AccountUser
 * @package App
 *
 * @property int id
 * @property int user_id
 * @property int account_is
 * @property string created_by
 * @property string updated_by
 */
class AccountUser extends Model
{
    use SoftDeletes, CreatedByUpdatedByRelationships;

    protected $fillable = [
        'account_id', 'user_id', 'created_by', 'updated_by',
    ];
}