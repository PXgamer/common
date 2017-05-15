<?php

namespace pxgamer\Common\Security;

use pxgamer\Common\Sessions;

/**
 * Class CSRF
 * @package pxgamer\Common\Security
 */
class CSRF
{
    /**
     * @var string
     */
    private static $hash_method = 'sha512';
    /**
     * @var string
     */
    private static $token;
    /**
     * @var Sessions\Session
     */
    private static $session;

    /**
     * CSRF constructor.
     */
    public function __construct()
    {
        self::$session = new Sessions\Session();
    }

    /**
     * Set the hashing algorithm for the CSRF tokens (must be in hash_algos() array)
     * @param string $value
     * @return bool
     */
    public function hash_method($value)
    {
        if (is_string($value) && in_array($value, hash_algos())) {
            self::$hash_method = $value;
            return true;
        }

        return false;
    }

    /**
     * Checks whether an incoming CSRF token value is valid.
     * @param string $value
     * @return bool
     */
    public function valid($value)
    {
        if (function_exists('hash_equals')) {
            return hash_equals($value, $this->get());
        }

        return $value === $this->get();
    }

    /**
     * Gets the value of the outgoing CSRF token.
     * @return string
     */
    public function get()
    {
        return self::$session::get('__csrf_token');
    }

    /**
     * Regenerates the value of the outgoing CSRF token.
     * @return bool
     */
    public function regenerate()
    {
        self::$token = hash(self::$hash_method, Random::generate());
        self::$session::set('__csrf_token', self::$token);

        return $this->get();
    }
}
