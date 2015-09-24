<?php

/**
 * A class representing an HTTP request.
 */
class Request {
    /** @var  string - The method for this request (GET, PUT, DELETE, POST */
    private $method;
    /** @var string - The controller for this request. */
    private $resource;
    /** @var string - The action of this request. */
    private $identifier;
    /** @var array - An array containing all data in the original $_REQUEST variable. */
    private $data;
    /** @var string - The UNIX timestamp of the request. */
    private $time;

    /**
     * Default constructor.
     * @param array $server - The $_SERVER variable of the request.
     * @param array $request - The $_REQUEST variable of the request.
     * @throws Exception
     */
    function __construct($server, $request) {
        $this->method = $server["REQUEST_METHOD"];

        if($this->method === 'PUT')
            parse_str(file_get_contents("php://input"),$this->data);
        else
            $this->data = $request;

        $this->time = $server["REQUEST_TIME"];

        $args = $this->_getUriAsArray($server);

        $this->resource = $args[0];
        $this->identifier = $args[1];
    }

    public function getMethod() {
        return $this->method;
    }

    /**
     * Get the model name of the request.
     * @return string - The model name of the request.
     */
    public function getResource() {
        return $this->resource;
    }

    /**
     * Get the action name of the request.
     * @return string - The action name of the request.
     */
    public function getIdentifier() {
        return $this->identifier;
    }

    /**
     * Get the data of the request.
     * @return array - The data of the request.
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Get the time of the request.
     * @return string - The UNIX timestamp of the request.
     */
    public function getTime() {
        return $this->time;
    }

    /**
     * Get all elements of the URI as an exploded array.
     * @param array $server - The $_SERVER variable of the request.
     * @return array - An array of strings from the URI.
     */
    private function _getUriAsArray($server) {
        $query_string = $server["QUERY_STRING"];
        $request_uri = $server["REQUEST_URI"];
        $request_uri = str_replace('?' .$query_string, '', $request_uri);
        $args = explode("/", $request_uri);
        $args = array_filter($args);
        $args_fixed = array();
        foreach($args as $arg)
            $args_fixed[] = $arg;

        return $args_fixed;
    }
}