<?php

namespace China\Common;

final class Utils
{
    /**
     * 去除空白字符.
     *
     * @param string $string
     * @return string
     */
    public static function clearBlankCharacters(string $string): string
    {
        $handledString = preg_replace('/\s/', '', str_replace('&nbsp;', '', $string));
        $handledString = str_replace('　', '', $handledString);

        return trim($handledString);
    }
}