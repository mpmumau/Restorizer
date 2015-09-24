<?php

include_once("DatabaseConfig.php");

/**
 * A class representing a database.
 */
class Database {
    /** @var  DatabaseConfig - The configuration for the database. */
    private $db_config;
    /** @var array - An array of all tables in the database. */
    private $tables;
    /** @var PDO - A PHP data object for connecting to the database. */
    private $pdo;

    /**
     * Default constructor
     * @param DatabaseSettings $db_config - A DatabaseSettings objects with database connection data.
     * @throws Exception - A generic exception.
     */
    function __construct($db_config) {
        $this->db_config = $db_config;
        $this->_init();
	}

    /**
     * Initialize the database PDO.
     */
    private function _init() {
        $this->tables = $this->_getTableNames();
    }

    /**
     * Get the PHP Data Object for this database.
     * @return null|PDO - The PDO Data Object for this database.
     */
    private function _getPDO() {
        if($this->pdo != null)
            return $this->pdo;

        $format = "mysql:host=%s;dbname=%s";
        $dsn = sprintf($format, $this->db_config->getHost(), $this->db_config->getName());

        $pdo = null;
        try {
            $pdo = new PDO($dsn, $this->db_config->getUser(), $this->db_config->getPassword(), array(PDO::ATTR_PERSISTENT => true));
        } catch(PDOException $e) {
            echo $e;
        }

        $this->pdo = $pdo;
        return $this->pdo;
    }

    /**
     * Get the names of the tables included in this database.
     * @return array - An array of the names of the tables in this database.
     */
    private function _getTableNames() {
        $pdo = $this->_getPDO();

        $format = 'SELECT table_name FROM information_schema.tables WHERE table_schema="%s"';
        $query = sprintf($format, $this->db_config->getName());
        $statement = $pdo->prepare($query);
        $statement->execute();
        $tables = $statement->fetchAll(PDO::FETCH_ASSOC);

        $tables_array = array();
        foreach($tables as $table) {
            $tables_array[] = $table["table_name"];
        }
        return $tables_array;
    }

    /**
     * Get a string for a database query which indicates which fields to return in a result.
     * @param array $field_names - An array of field names, or a string of a single field name.
     * @param boolean $wildcard_if_null - Whether or not to return a wildcard (asterix) if null.
     * @return null|string - The string representing the query fields.
     */
    private function _getFieldsString($field_names = null, $wildcard_if_null = false) {
        // if null, return wildcard
        if($field_names == null && $wildcard_if_null)
            return "*";

        // if an array, format a string with the values
        if(is_array($field_names)) {
            $fields = implode(', ', $field_names);
            return $fields;
        }

        // if a string, return the string
        return $field_names;
    }

    /**
     * Get a string that represents the conditions of a database query.
     * @param array $conditions - An array of conditions; the first element is the name of the field, while the second
     * element is an array containing the comparison operand and the value to compare.
     * @return string - A string to be used in a query which will represent conditions.
     */
    private function _getConditionsString($conditions) {
        $conditions_string = '';

        if($conditions == null || !is_array($conditions))
            return $conditions_string;

        $conditions_string_array = array();
        foreach($conditions as $condition => $comparator) {
            $conditions_string_array[] = $condition.$comparator[0]."'$comparator[1]'";
        }

        $conditions_string = implode('AND ', $conditions_string_array);
        return $conditions_string;
    }

    /**
     * Get an associate array of values from the given database table given certain optional conditions. If no
     * conditions are supplied, all results will be returned.
     * @param string $table_name - The name of the table from which to retrieve data.
     * @param int $identifier - The ID number of the item to retrieve from the table.
     * @param mixed $field_names - An array of field names to retrieve, or a string for a single field.
     * @param array $conditions - An array of conditions to be applied to the query. The first field is the name of a
     * field, while the second field is an array containing the comparison operand and the value to compare.
     * @return array - An array of all data returned from the database query.
     */
    public function select($table_name, $identifier = null, $field_names = null, $conditions = null) {
        $pdo = $this->_getPDO();

        $fields_string = $this->_getFieldsString($field_names, true);
        $identifier_string = $identifier == null ? null : "id='$identifier'";
        $conditions_string = $this->_getConditionsString($conditions);

        if($conditions_string && $identifier_string) {
            $conditions_string = $identifier_string . 'AND ' . $conditions_string;
        } else if($identifier_string) {
            $conditions_string = $identifier_string;
        }

        $conditions_string = $conditions_string ? "WHERE $conditions_string" : '';

        $format = "SELECT %s FROM $table_name %s";
        $query = sprintf($format, $fields_string, $conditions_string);

        try {
            $statement = $pdo->prepare($query);
            $statement->execute();
            $r = $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo $e;
        }

        return $r;
    }

    /**
     * Insert the data for the given fields into the given table.
     * @param string $table_name - The name of the table to insert the data into.
     * @param mixed $fields - The name of the fields to insert data into.
     * @param mixed $values - The values of the fields to insert data into.
     */
    public function insert($table_name, $data) {
        $fields = array();
        $values = array();

        foreach($data as $key => $value) {
            $fields[] = $key;
            $values[] = '"'.$value.'"';
        }

        $pdo = $this->_getPDO();

        $fields_string = '(' . $this->_getFieldsString($fields) . ')';
        $values_string = '(' . $this->_getFieldsString($values) . ')';

        $format = "INSERT INTO $table_name $fields_string VALUES $values_string";
        $query = sprintf($format, $fields_string, $values_string);

        try {
            $statement = $pdo->prepare($query);
            $statement->execute();
            $last_id = $pdo->lastInsertId();
            $last_object = $this->select($table_name, $last_id);
        } catch(PDOException $e) {
            echo $e;
        }

        return $last_object;
    }

    public function update($table_name, $identifier, $data) {
        $pdo = $this->_getPDO();

        $fields_formatted = array();
        foreach($data as $key => $value) {
            $fields_formatted[] = $key . "='$value'";
        }

        $fields_string = $this->_getFieldsString($fields_formatted);

        $format = "UPDATE %s SET %s WHERE id='%s'";
        $query = sprintf($format, $table_name, $fields_string, $identifier);

        try {
            $statement = $pdo->prepare($query);
            $statement->execute();
            $last_object = $this->select($table_name, $identifier);
        } catch(PDOException $e) {
            echo $e;
        }

        return $last_object;
    }

    public function delete($table_name, $identifier) {
        $pdo = $this->_getPDO();

        $format = "DELETE FROM %s WHERE id='%s'";
        $query = sprintf($format, $table_name, $identifier);

        try {
            $statement = $pdo->prepare($query);
            $statement->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        return true;
    }
}