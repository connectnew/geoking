<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewSmartResponse extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'review_smart_response';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'langauge_id', 'sector_id', 'positive', 'text', 'created_by', 'updated_by'];


    public function domain()
    {
        return $this->hasOne(AccountDomain::class, 'id', 'sector_id');
    }

    public function category()
    {
        return $this->hasOne(ReviewCategory::class, 'id', 'category_id');
    }

    public function langauge()
    {
        return $this->hasOne(ReviewLanguage::class, 'id', 'langauge_id');
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
