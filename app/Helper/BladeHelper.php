<?php

namespace App\Helper;

class BladeHelper {

    /**
     * Create url gravatar api.
     *
     * @param string $email
     * @return string
     */
    public static function url_gravatar(string $email)
    {
        $email = md5($email);

        return "https://gravatar.com/avatar/{$email}?" . http_build_query([
                's' => 36,
                'd' => 'identicon'
            ]);
    }
}
