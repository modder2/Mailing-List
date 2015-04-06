<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Extend Kohana abstract controller class for automatic templating.
 */
abstract class Controller_Template extends Kohana_Controller_Template {

    /**
     * Before function. Initializes class variables, passes parameters to the view
     */
    public function before()
    {
        parent::before();

        if ($this->auto_render === TRUE)
        {
            $this->template->styles = array();
            $this->template->scripts = array();
            $this->template->content = NULL;
        }
    }

    /**
     * After function. Passes parameters to the view
     */
    public function after()
    {
        if ($this->auto_render === TRUE)
        {
            $styles  = array(
                'bootstrap.min.css',
                'bootstrap-theme.min.css',
                'main.css',
            );
            $this->template->styles  = array_merge($styles, $this->template->styles);
        }

        parent::after();
    }

} // End Controller_Template
