<?php

function gravatar_url($email)
{
    /*
    $email = md5($email);

    return "https://gravatar.com/avatar/{$email}?" . http_build_query([
            's' => 60,
            'd' => asset('/images/green.png')
        ]);
    */

    return asset('/images/green.png');
}