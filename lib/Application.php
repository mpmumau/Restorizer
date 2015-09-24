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

require_once "Config.php";
require_once "Resources.php";
require_once "Request.php";
require_once "IncludeBatch.php";
require_once "RequestHandler.php";

/**
 * A class representing the entire application.
 */
class Application {
    /** @var Config - A Config object, representing all application configuration. */
    private $config;
    /** @var  Resources - A Resources object, representing all resources available to the application. */
    private $resources;
    /** @var Request - A Request object, representing the request supplied to the application. */
    private $request;
    /** @var  IncludeBatch - An object representing all files which should be included for the request. */
    private $include_batch;
    /** @var  RequestHandler - A RequestHandler object, which handles Request objects. */
    private $request_handler;

    /**
     * Default constructor.
     */
    function __construct() {
        $this->config = new Config();
        $this->resources = new Resources($this->config);
        $this->request = new Request($_SERVER, $_REQUEST);
        $this->include_batch = new IncludeBatch($this->request);
        $this->request_handler = new RequestHandler($this->resources);
    }

    /**
     * The main function of the application; entry point for all requests and processing.
     */
    public function main() {
        $output = $this->request_handler->handle($this->request);
        echo $output;
    }

    public function getIncludeBatch() {
        return $this->include_batch;
    }
}