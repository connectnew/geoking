<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\CreatedByUpdatedByRelationships;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;



/**
 * Class Location
 * @package App
 *
 * @property int id
 * @property int account_id
 * @property string title
 * @property string phone
 * @property string website
 * @property string country
 * @property string address
 * @property string street
 * @property string city
 * @property string state
 * @property string zip
 * @property float latitude
 * @property float longitude
 * @property int created_by
 * @property int updated_by
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed deleted_at
 * @property string google_account_id
 * @property array raw_data json
 * @property array stats_data json
 * @property int is_confirmed
 *
 * @property Source|null source
 * @property Review[]|null reviews
 *
 * @method where($column, $operator = null, $value = null, $boolean = 'and')
 * @see Builder::where()
 * @method findMany($ids, $columns = ['*'])
 * @see Builder::findMany()
 * @method static Location firstOrNew(array $attributes, array $values = [])
 * @see Builder::firstOrNew()
 */
class Location extends Model
{
    use HasJsonRelationships;
    use SoftDeletes, CreatedByUpdatedByRelationships;

    protected $fillable = [
        'title','account_id','phone','website','country','address','street','city','state',
        'zip','latitude','longitude','raw_data','is_confirmed'
    ];

    protected $hidden = [
    	'account_id'
    ];

    protected $casts = [
        'raw_data' => 'array',

    ];

    protected $appends=[
        'rating',
    
    ];

   
    public function scanResults()
    {
        return $this->hasMany(ScanResult::class, 'location_id', 'id');
    }

    public function latestScanResult()
    {
        return $this->hasOne(ScanResult::class, 'location_id', 'id')->latest();
    }

    /**
     * Get the source record associated with the location.
     */
    public function source(): Relation
    {
        return $this->hasOne(Source::class, 'gmb_place_id', 'raw_data->name');
    }

    public function reviews(): Relation
    {
        return $this->hasMany(Review::class);
    }

    public function getRatingAttribute()
    {
        return round($this->reviews()->get()->average('rating'), 2);
    }

   
}
