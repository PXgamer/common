<?php

namespace pxgamer\Common\Errors;

class Error
{
    protected $code;
    protected $text;
    protected $data;

    public function __get($name)
    {
        if ($this->$name ?? false) {
            return $this->$name;
        }

        return null;
    }

    public function __set($name, $value)
    {
        return $this->$name = $value;
    }
}