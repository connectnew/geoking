<?php

namespace App;

use App\Traits\Models\CreatedByUpdatedByRelationships;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ReviewReply
 * @package App
 *
 * @property int id
 * @property int review_id
 * @property string comment
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property mixed deleted_at
 *
 * @method static ReviewReply firstOrNew(array $attributes, array $values = [])
 * @see Builder::firstOrNew()
 * @method static ReviewReply updateOrCreate(array $attributes, array $values = [])
 * @see Builder::updateOrCreate()
 */
class ReviewReply extends Model
{
    use SoftDeletes, CreatedByUpdatedByRelationships;

    protected $fillable = [
        'review_id', 'comment', 'created_by', 'updated_by', 'created_at', 'updated_at',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    /**
     * @return Relation
     */
    public function review(): Relation
    {
        return $this->belongsTo(Review::class);
    }
}
