<?php

namespace pxgamer\Common\Errors;

class Error
{
    protected $code;
    protected $text;
    protected $data;

    public function __construct($code = 0, $text = 'An unknown error occurred.', $data = null)
    {
        $this->code = $code;
        $this->text = $text;
        $this->data = $data;
    }

    public function __get($name)
    {
        if (isset($this->$name) && $this->$name) {
            return $this->$name;
        }

        return null;
    }

    public function __set($name, $value)
    {
        return $this->$name = $value;
    }
}