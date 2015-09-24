<?php

require_once "DatabaseConfig.php";

/**
 * A class representing the configuration of the application.
 */
class Config {
    /** @var array - An array of configuration settings for the databases. */
    private $database_config;

    /**
     * Default constructor
     */
    function __construct() {
        $this->database_config = $this->_getDatabaseConfigs();
    }

    /**
     * Set the database config field to the value of the provided config array for databases.
     */
    private function _getDatabaseConfigs() {
        require 'app/db_config.php';

        $configs = array();

        foreach($databases as $key => $value) {
            $settings = array(
                    $value["db_name"],
                    $value["db_user"],
                    $value["db_password"],
                    $value["db_host"]
            );
            $configs[$key] = new DatabaseConfig($settings);
        }

        return $configs;
    }

    /**
     * Get the database configuration array.
     * @return array - The database configuration array.
     */
    public function getDatabaseConfig() {
        return $this->database_config;
    }
}