<?php

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