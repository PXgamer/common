<?php

namespace pxgamer\Common\FS;

use pxgamer\Common;

/**
 * Class File
 * @package pxgamer\Common\FS
 */
class File
{
    /**
     * @var bool|string
     */
    public $error = false;

    /**
     * @var null|string
     */
    private $directory = null;
    /**
     * @var null|string
     */
    private $file = null;
    /**
     * @var null|string
     */
    private $mime_type = null;

    /**
     * File constructor.
     * @param $absolute_path
     */
    public function __construct($absolute_path)
    {
        $this->directory = dirname($absolute_path) . DIRECTORY_SEPARATOR;
        $this->file = basename($absolute_path);
    }

    /**
     * @return bool
     */
    public function exists()
    {
        if (file_exists($this->path())) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $bResult = false;
        $file = $this->path();
        if ($this->exists() && is_file($file)) {
            chmod($file, 0666);
            $bResult = unlink($file);
        }

        return $bResult;
    }

    /**
     * @param null|string $new_name
     * @return bool
     */
    public function rename($new_name = null)
    {
        if (!$new_name) {
            return false;
        }

        $current_file = $this->path();
        $new_file = $this->directory() . $new_name;

        if ($this->exists() && is_file($current_file) && !file_exists($new_file)) {
            return rename($current_file, $new_file);
        }

        return false;
    }

    /**
     * @return null|string
     */
    public function directory()
    {
        return $this->directory;
    }

    /**
     * @return null|string
     */
    public function name()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->directory() . $this->name();
    }

    /**
     * @param bool $pretty
     * @param int $length
     * @return int|string
     */
    public function size($pretty = false, $length = 4)
    {
        $size = filesize($this->path());

        if ($pretty) {
            if ($size < 1024) {
                return $size . 'B';
            }
            if ($size < 1048576) {
                return Common\Scalars\Numbers::trim_num($size / 1024, $length) . ' <span>KB</span>';
            }
            if ($size < 1073741824) {
                return Common\Scalars\Numbers::trim_num($size / 1048576, $length) . ' <span>MB</span>';
            }

            return Common\Scalars\Numbers::trim_num($size / 1073741824, $length) . ' <span>GB</span>';
        }
        return $size;
    }

    /**
     * @return null|string
     */
    public function mime_type()
    {
        if (!$this->mime_type) {
            $this->mime_type = mime_content_type($this->path());
        }

        return $this->mime_type;
    }

    /**
     * @return bool
     */
    public function create()
    {
        if ($this->prepare()) {
            return (bool)file_put_contents($this->path(), null);
        }

        return false;
    }

    /**
     * @param int $user
     * @return bool
     */
    public function chown($user = 0)
    {
        if ($this->exists()) {
            return chown($this->path(), $user);
        }

        return false;
    }

    /**
     * @param int $mode
     * @return bool
     */
    public function chmod($mode = 0755)
    {
        if ($this->exists()) {
            return chmod($this->path(), $mode);
        }

        return false;
    }

    /**
     * @param int $group
     * @return bool
     */
    public function chgrp($group = 0)
    {
        if ($this->exists()) {
            return chgrp($this->path(), $group);
        }

        return false;
    }

    /**
     * @param * $name
     * @return *
     */
    public function __get($name)
    {
        if (isset($this->$name) && $this->$name) {
            return $this->$name;
        }

        return null;
    }

    /**
     * @return bool
     */
    private function prepare()
    {
        if (!file_exists($this->directory())) {
            if (!mkdir($this->directory(), 0777, true)) {
                return false;
            }
        }

        return true;
    }
}