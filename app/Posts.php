<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
class Posts extends Model
{
    use Notifiable;


	
    public function __construct() {
        
    }

 protected $fillable = [
        'title',
        'description',
        'img_url',
        'location',
        'button',
        'button_url',
        'video',
        'schedule_option',
        'start_date',
        'end_date',
        'timezone',
        'repeat_post',
        'repeat_option',
        'event_expire',
        'status',

        
        // add all other fields
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'gmb_events';
}
?>
