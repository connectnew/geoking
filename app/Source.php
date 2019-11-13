<?php

namespace App;

use App\Traits\Models\CreatedByUpdatedByRelationships;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

/**
 * Class Source
 * @package App
 *
 * @property int id
 * @property int account_id
 * @property string name
 * @property string website
 * @property string phone
 * @property string country
 * @property string province
 * @property string city
 * @property string address
 * @property string postal_code
 * @property string gmb_place_id
 * @property int external_id
 * @property int created_by
 * @property int updated_by
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed deleted_at
 *
 * @method Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @see Builder::where()
 * @method Builder find($id, $columns = ['*'])
 * @see Builder::find()
 */
class Source extends Model
{
    use HasJsonRelationships;
    use SoftDeletes, CreatedByUpdatedByRelationships;

    protected $fillable = [
        'name', 'phone', 'country', 'province', 'city', 'address', 'postal_code', 'website',
        'account_id', 'gmb_place_id', 'external_id'
    ];

    protected $hidden = [
        'account_id'
    ];

    protected $casts = [

    ];

    /**
     * Get the location record associated with the source.
     */
    public function location(): Relation
    {
        return $this->hasOne(Location::class, 'raw_data->name', 'gmb_place_id');
    }
}
