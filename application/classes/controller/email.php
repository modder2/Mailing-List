<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Controller for main email page
 *
 * @author modder
 */
class Controller_Email extends Controller_Template {

    /**
     * View template name
     * @var string
     */
    public $template = 'index';

    public function before()
    {
        parent::before();

        // Routes in Kohana doesn't differ request methods
        $action_name = strtolower($this->request->method().'_'.$this->request->action());
        if (method_exists($this, $action_name))
        {
            $this->{$action_name}();
        }
    }

    /**
     * Basic action
     */
    public function action_index()
    {
        // Get all emails
        $this->template->emails = Model::factory('email')->get_emails();
        // Get counters
        $this->template->counters = Model::factory('counter')->get_counters();
    }

    /**
     * Add email to list
     */
    public function post_index()
    {
        $data = Arr::map('trim', $this->request->post());

        $validation = Validation::factory($data)
            ->rule('email', 'not_empty')
            ->rule('email', 'email')
            ->rule('email', 'Model_Email::unique_email')
            ->rule('sending_time', 'not_empty')
            ->rule('sending_time', 'date');
        if ( ! $validation->check())
        {
            $this->template->errors = $validation->errors('validation');
            $this->template->post_data = $data;
            return FALSE;
        }

        if (Model::factory('email')->add_email($data))
        {
            $this->request->redirect($this->request->uri());
        }
    }

    /**
     * Edit email sending time
     */
    public function patch_index()
    {
        $data = Arr::map('trim', $this->request->post());

        $validation = Validation::factory($data)
            ->rule('email', 'not_empty')
            ->rule('email', 'email')
            ->rule('email', 'Model_Email::exist_email')
            ->rule('sending_time', 'not_empty')
            ->rule('sending_time', 'date');
        if ( ! $validation->check())
        {
            $this->template->errors = $validation->errors('validation');
            return FALSE;
        }

        if (Model::factory('email')->update_email_time($data))
        {
            $this->request->redirect($this->request->uri());
        }
    }

    /**
     * After function. Passes parameters to the view
     */
    public function after()
    {
        if ($this->auto_render)
        {
            $this->template->styles  = array(
                'bootstrap.min.css',
                'bootstrap-theme.min.css',
                'bootstrap-datetimepicker.min.css',
                'main.css',
            );
            $this->template->scripts = array(
                'jquery-1.11.2.min.js',
                'moment.min.js',
                'bootstrap.min.js',
                'bootstrap-datetimepicker.min.js',
                'main.js',
            );
        }

        parent::after();
    }

} // End Controller_Email
