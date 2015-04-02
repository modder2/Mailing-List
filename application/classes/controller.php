<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Abstract controller class extends system Kohana_Controller
 */
abstract class Controller extends Kohana_Controller {

    public function before()
    {
        parent::before();

        // Extends Kohana detect request method
        if ($this->request->method() === HTTP_Request::POST)
        {
            $method = strtoupper($this->request->post('_method'));
            if (in_array($method, array(
                HTTP_Request::PUT,
                HTTP_Request::PATCH,
                HTTP_Request::DELETE,
            ), TRUE))
            {
                $this->request->method($method);
            }
        }
    }

} // End Controller
