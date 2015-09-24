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