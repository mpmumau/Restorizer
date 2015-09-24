<?php

/**
 * A class containing a variety of utility functions.
 */
class Utils {
    /**
     * Checks whether the provided string is a valid, non-empty string.
     * @param string $string - The string to validate.
     * @return bool - True if the string is valid, false otherwise.
     */
    public static function isValidString($string) {
        if(!isset($string) || !is_empty($string))
            return false;
        return true;
    }

    public static function getPath($path) {
        return $_SERVER["DOCUMENT_ROOT"] . $path;
    }
}