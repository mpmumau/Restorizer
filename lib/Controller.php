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
 * A class representing a controller object.
 */
class Controller {
    /** @var Model - The model for the controller to act upon. */
    private $model;

    /**
     * Default constructor.
     * @param Model $model - The model to use for the controller.
     */
    function __construct($model) {
        $this->model = $model;
    }

    /**
     * Default "get" controller action. Override in derived controller to alter data.
     * @param int $identifier - An integer representing the identifier of the model data.
     * @return array - An array of data from the model.
     */
    public function get($identifier = null, $data = null) {
        $r = array();
        if($identifier == null)
            $r = $this->model->all();
        else
            $r = $this->model->get($identifier);

        return $r;
    }

    public function put($identifier = null, $data = null) {
        $r = array();

        $r = $this->model->put($identifier, $data);

        return $r;
    }

    public function delete($identifier = null) {
        $this->model->delete($identifier);
    }

    public function post() {}
}