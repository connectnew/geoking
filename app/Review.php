<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Review
 * @package App
 *
 * @property int id
 * @property int location_id
 * @property string source_name
 * @property string source_key
 * @property string reviewer_is_anonymous
 * @property string reviewer_name
 * @property string reviewer_photo_url
 * @property string rating
 * @property string comment
 * @property string responded
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property mixed deleted_at
 *
 * @property ReviewReply reviewReply
 *
 * @method static Review firstOrNew(array $attributes, array $values = [])
 * @see Builder::firstOrNew()
 * @method static Review updateOrCreate(array $attributes, array $values = [])
 * @see Builder::updateOrCreate()
 */
class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'location_id', 'source_name', 'source_key', 'reviewer_is_anonymous', 'reviewer_name', 'reviewer_photo_url',
        'rating', 'comment', 'responded', 'created_at', 'updated_at',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    protected $appends = [
        'created_at_for_humans', 'updated_at_for_humans'
    ];

    public function getCreatedAtForHumansAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getUpdatedAtForHumansAttribute(): string
    {
        return $this->updated_at->diffForHumans();
    }

    public function reviewReply(): Relation
    {
        return $this->hasOne(ReviewReply::class)->with('updatedBy');
    }

    public function location(): Relation
    {
        return $this->belongsTo(Location::class);
    }
}