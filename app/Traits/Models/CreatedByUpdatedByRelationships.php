<?php

namespace App\Traits\Models;

use App\User;

trait CreatedByUpdatedByRelationships
{
	public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public static function bootCreatedByUpdatedByRelationships()
    {
        static::updating(function($model)
        {
            $model->updated_by = auth()->id();
        });

        static::creating(function($model)
        {
        	$model->created_by = auth()->id();
            $model->updated_by = auth()->id();
        });
    }
}