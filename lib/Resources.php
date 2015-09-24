<?php

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