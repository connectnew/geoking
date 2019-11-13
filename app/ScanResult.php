<?php

namespace App;

use App\Traits\Models\CreatedByUpdatedByRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ScanResult
 * @package App
 *
 * @property int id
 * @property int location_id
 * @property float score
 * @property array report_details json
 * @property int created_by
 * @property int updated_by
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed deleted_at
 */
class ScanResult extends Model
{
    use SoftDeletes, CreatedByUpdatedByRelationships;

    protected $fillable = [
        'location_id', 'score', 'report_details', 'created_by', 'updated_by',
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'score' => 'float',
        'report_details' => 'array',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];
}