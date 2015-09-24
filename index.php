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

// php settings
error_reporting(E_STRICT);

require_once("lib/Application.php");

/** @var Application $app - The master application object. */
$app = new Application();

/** @var IncludeBatch $include_batch -- The includes for the application. */
$include_batch = $app->getIncludeBatch()->getFiles();

foreach($include_batch as $file) {
    require_once($file);
}

// Run the application
$app->main();
