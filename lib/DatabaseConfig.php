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
 * A data class for storing database settings data.
 */
class DatabaseConfig {
    /** @var  string - The name of the database. */
	private $db_name;
    /** @var  string - The username for the database. */
	private $db_user;
    /** @var  string - The password for the database. */
	private $db_password;
    /** @var  string - The host for connecting to the database. */
	private $db_host;

    /**
     * Default constructor.
     * @param array $args - An array of arguments; must be four to create database.
     */
    function __construct($args) {
        list($db_name, $db_user, $db_password, $db_host) = $args;

		$this->db_name = $db_name;
		$this->db_user = $db_user;
		$this->db_password = $db_password;
		$this->db_host = $db_host;
	}

    /**
     * Get the name of the database.
     * @return String - The name of the database.
     */
    function getName() {
        return $this->db_name;
    }

    /**
     * Get the username for the database.
     * @return String - The username for the database.
     */
    function getUser() {
        return $this->db_user;
    }

    /**
     * Get the password for the database.
     * @return String - The password for the database.
     */
    function getPassword() {
        return $this->db_password;
    }

    /**
     * Get the host of the database.
     * @return String - The host of the database.
     */
    function getHost() {
        return $this->db_host;
    }
}