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

require_once "Request.php";
require_once "Utils.php";
require_once "Model.php";
require_once "Controller.php";
require_once "View.php";

require_once Utils::getPath("/vendor/Inflect/Inflect.php");

/**
 * A class that handles Request objects
 */
class RequestHandler {
    /** @var Resources - A resources object. */
    private $resources;

    function __construct($resources) {
        $this->resources = $resources;
    }

    /**
     * Handles a given request.
     * @param Request $request - A Request object to handle.
     * @return string - The output of the request.
     */
    public function handle($request) {
        $resource = $request->getResource();
        $model_name = ucfirst(strtolower($resource));
        $identifier = $request->getIdentifier();
        $data = $request->getData();

        $output = '';

        switch($request->getMethod()) {
            case 'GET':
                $output = $this->_act($model_name, "get", $identifier);
                break;
            case 'PUT':
                $output = $this->_act($model_name, "put", $identifier, $data);
                break;
            case 'DELETE':
                $output = $this->_act($model_name, "delete", $identifier);
                break;
            case 'POST':
                $this->_post($request);
                break;
        }

        return $output;
    }

    /**
     * Process a GET request.
     * @param string $resource_name - The name of the table to get a resource from.
     * @param string $action - The action to perform on the controller.
     * @param string $identifier - An identifier for the resource.
     * @param array $data - The data for the action.
     * @return string - A string representing the output of the operation.
     */
    private function _act($resource_name, $action, $identifier = null, $data = null) {
        $resource_name_capitalized = $resource_name;
        $resource_name_plural_capitalized = Inflect::pluralize($resource_name_capitalized);
        $resource_name_plural_lowercase = strtolower($resource_name_plural_capitalized);

        /** ----- Model ----- */
        // If no overriding Model class is defined, use the default model class.
        $model_name = $resource_name_capitalized;

        if(!class_exists($model_name))
            $model_name = "Model";

        /** @var Model $model -- The model of the resource. */
        $model = new $resource_name($this->resources->getDatabase('default'), $resource_name_plural_lowercase);


        /** ----- Controller ----- */
        // If no overriding Controller class is defined, use the default controller class.
        $controller_name = $resource_name_plural_capitalized . 'Controller';

        if(!class_exists($controller_name))
            $controller_name = "Controller";

        /** @var Controller $controller -- The controller for the model. */
        $controller = new $controller_name($model);
        $data = $controller->$action($identifier, $data);

        /** ----- View ----- */
        // If no overriding View class is defined, use the default View class.
        $view_name = $resource_name_plural_capitalized . "View";

        if(!class_exists($view_name))
            $view_name = "View";

        /** @var View $view -- The view for this request. */
        $view = new $view_name($data);

        return $view->output();
    }
}