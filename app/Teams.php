<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
class Teams extends Model
{
    use Notifiable;


	
    public function __construct() {
        
    }

 protected $fillable = [
        'user_id',
        'role', 
		'data',

        
        // add all other fields
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'user_teams';
}
?>
