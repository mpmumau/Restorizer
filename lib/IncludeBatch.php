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
require_once Utils::getPath("/vendor/Inflect/Inflect.php");

/**
 * A class that defines which files should be included for a given request.
 */
class IncludeBatch {
    const CONTROLLER = 0;
    const MODEL = 1;
    const VIEW = 2;

    /** @var array - An array of filenames to be included. */
    private $files;
    /** @var  Request - A Request object for the request. */
    private $request;

    /**
     * Default constructor.
     * @param Request $request
     */
    function __construct($request) {
        $model_files = $this->_getFilesFor($this::MODEL);
        foreach($model_files as $file)
            $this->files[] = 'app/models/' . $file;

        $controller_files = $this->_getFilesFor($this::CONTROLLER);
        foreach($controller_files as $file)
            $this->files[] = 'app/controllers/' . $file;

        $view_files = $this->_getFilesFor($this::VIEW);
        foreach($view_files as $file)
            $this->files[] = 'app/views/' . $file;
    }

    /**
     * Get the files to be included.
     * @return array - The files to be included.
     */
    public function getFiles() {
        return $this->files;
    }

    /**
     * Get all the files of models, controllers or views.
     * @param int $file_type - The constant int value defined in this class that specifies either models or controllers.
     * @return array - The array of files for either models or controllers.
     */
    private function _getFilesFor($file_type) {
        $path_addon = '';
        if($file_type == $this::CONTROLLER)
            $path_addon = 'controllers';
        if($file_type == $this::MODEL)
            $path_addon = 'models';
        if($file_type == $this::VIEW)
            $path_addon = 'views';

        $path = Utils::getPath('/app/' . $path_addon);
        $files = scandir($path);

        for($i = 0; $i <= count($files); $i++) {
            if($files[$i] === '.' || $files[$i] === '..')
                unset($files[$i]);
        }

        $fixed_files = array();
        foreach($files as $file)
            $fixed_files[] = $file;

        return $fixed_files;
    }
}