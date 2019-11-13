<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int user_id
 * @property string provider
 * @property string token
 */
class OAuth extends Model
{
    use SoftDeletes;

    protected $table = 'oauth';

    const GOOGLE = 'google';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'provider' => self::GOOGLE
    ];

    protected $casts = [
        'id' => 'int',
        'token' => 'array'
    ];

    public function configureGoogle(\Google_Client $client)
    {
        $client->setAccessToken($this->token ?? null);

        /* Refresh token when expired */
        if ($client->isAccessTokenExpired()) {
            // the new access token comes with a refresh token as well
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $this->token = $client->getAccessToken();
            $this->saveOrFail();
        }
    }
}
