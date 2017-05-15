<?php

namespace pxgamer\Common\Data;

class JSON
{
    public function __toString()
    {
        return json_encode($this);
    }
}