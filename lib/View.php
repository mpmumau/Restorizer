<?php

class View {
    /** @var array $data - The data to display for the view. */
    private $data;

    /**
     * Default constructor.
     * @param array $data - The data to display in the view.
     */
    function __construct($data) {
        $this->data = $data;
    }

    public function output() {
        return json_encode($this->data);
    }
}