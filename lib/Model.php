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

require_once("Utils.php");

/**
 * A class representing a data model.
 */
class Model {
    /** @var string The name of the table associated with the model. */
    private $table_name;
    /** @var Database - The database object for this model. */
    private $database;

    function __construct($database, $table_name) {
        $this->database = $database;
        $this->table_name = $table_name;
    }

    /**
     * Get all data for the model.
     * @return array - An array of all data for the model.
     */
    public function all() {
        $r = $this->database->select($this->table_name);
        return $r;
    }

    /**
     * Get a specific data item for the model by ID.
     * @param int $identifier - The identifier of the item to retrieve for the model.
     * @return array - The item retrieved for the model.
     */
    public function get($identifier = null) {
        $r = $this->database->select($this->table_name, $identifier);
        return $r;
    }

    public function put($identifier = null, $data) {
        if($identifier != null) {
            $r = $this->get($identifier);
            if($r)
                return $this->update($identifier, $data);
        }

        return $this->database->insert($this->table_name, $data);
    }

    public function update($identifier, $data) {
       return $this->database->update($this->table_name, $identifier, $data);
    }

    public function delete($identifier) {
        return $this->database->delete($this->table_name, $identifier);
    }
}