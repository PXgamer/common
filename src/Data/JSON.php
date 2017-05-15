<?php

namespace pxgamer\Common\Data;

/**
 * Class JSON
 * @package pxgamer\Common\Data
 */
class JSON
{
    /**
     * Allows you to do object additions such as below:
     * ```
     * $json = new JSON();
     * $json->message = 'This is JSON.';
     * $json->code = 123;
     * echo $json;
     * ```
     *
     * Which would output:
     * ```
     *  {
     *    'message' => 'This is JSON.',
     *    'code' => 123
     *  }
     * ```
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }
}