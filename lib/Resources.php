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

include_once "Config.php";
include_once "Database.php";
include_once "DatabaseConfig.php";

class Resources {
    /** @var Database[] - An array of available database objects. */
    private $databases;

    /**
     * Default constructor
     * @param Config $config - The master configuration for the application.
     */
    function __construct($config) {
        $this->databases = $this->_getDatabases($config->getDatabaseConfig());
    }

    /**
     * Return an array of Database objects based on the provided db configs.
     * @param $db_configs
     * @return array
     */
    private function _getDatabases($db_configs) {
        $dbs = array();

        foreach($db_configs as $key => $value) {
            $dbs[$key] = new Database($value);
        }

        return $dbs;
    }

    /**
     * Get a database by the database name.
     * @param String $db_name - The name of the database to get. Default is 'default'.
     * @return Database|null - The database requested; null if no database exists with that identifier.
     */
    public function getDatabase($db_name = 'default') {
        if(array_key_exists($db_name, $this->databases))
           return $this->databases[$db_name];

        return null;
    }
}