<?php

namespace pxgamer\Common\Security;

use pxgamer\Common\Errors\Error;

class Random
{
    public static function generate($bytes = 32)
    {
        $data = new \stdClass();
        $data->error = null;

        if (function_exists('random_bytes')) {
            $data->results = random_bytes($bytes);
        } elseif (extension_loaded('openssl')) {
            $data->results = openssl_random_pseudo_bytes($bytes);
        } else {
            $data->results = null;
            $data->error = new Error(0, 'Unable to generate cryptographically secure values.');
        }

        return $data;
    }
}