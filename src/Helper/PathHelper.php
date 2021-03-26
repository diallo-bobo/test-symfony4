<?php

namespace App\Helper;

/**
 * Class PathHelper
 * @package App\Helper
 */
class PathHelper
{
    /**
     * @param string ...$parts
     * @return string
     */
    public static function join(...$parts): string
    {
        return preg_replace('~[/\\\\]+~', DIRECTORY_SEPARATOR, implode(DIRECTORY_SEPARATOR, $parts)) ?: '';
    }
}
