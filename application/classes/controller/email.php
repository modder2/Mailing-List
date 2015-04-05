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

    protected $template_params = array();

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
        $this->template_params['emails'] = Model::factory('email')->get_emails();
        // Get counters
        $this->template_params['counters'] = Model::factory('counter')->get_counters();

        $this->template->content = View::factory('emails')->set($this->template_params);
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
            $this->template_params['errors'] = $validation->errors('validation');
            $this->template_params['post_data'] = $data;
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
            $this->template_params['errors'] = $validation->errors('validation');
            return FALSE;
        }

        if (Model::factory('email')->update_email_time($data['email'], $data['sending_time']))
        {
            $this->request->redirect($this->request->uri());
        }
    }

    /**
     * Delete email from mailing list
     */
    public function action_unsubscribe()
    {
        $email = $this->request->param('email');
        $this->template_params = $this->request->param();
        $validation = Validation::factory($this->template_params)
            ->rule('email', 'not_empty')
            ->rule('email', 'email')
            ->rule('email', 'Model_Email::exist_email')
            ->rule('hash', 'not_empty')
            ->rule('hash', 'alpha_numeric');
        if ( ! $validation->check())
        {
            $this->template_params['errors'] = $validation->errors('validation');
        }
        else
        {
            $validation = Validation::factory($this->template_params)
                ->rule('hash', 'Model_Email::check_email_hash', array($email, ':value'));
            if ( ! $validation->check())
            {
                $this->template_params['errors'] = $validation->errors('validation');
            }
            else
            {
                Model::factory('email')->delete_email($email);
            }
        }

        $this->template->content = View::factory('unsubscribe')->set($this->template_params);
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
