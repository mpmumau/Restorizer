<?php
/**
 * Restorizer: A PHP-based RESTful web service with psuedo-MVC properties.
 * Copyright (c) Matt Mumau
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Matt Mumau
 * @since         0.1.0
 * @license       https://opensource.org/licenses/MIT MIT License
 */

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