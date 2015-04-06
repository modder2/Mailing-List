<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Error_Handler extends Controller_Template {

    protected $template_params = array();

    public function before()
    {
        parent::before();

        $this->template_params['page'] = URL::site(rawurldecode(Request::$initial->uri()));

        // Internal request only!
        if ( ! Request::current()->is_initial())
        {
            if ($message = rawurldecode($this->request->param('message')))
            {
                $this->template_params['message'] = $message;
            }
        }
        else
        {
            $this->request->action(404);
            $this->template_params['message'] = str_replace(':uri', $this->request->uri(),
                'The requested URL :uri was not found on this server.');
        }

        // Set HTTP status
        $this->response->status( (int) $this->request->action());
    }

    public function action_404()
    {
        $this->template_params['title'] = '404 Not Found';
 
        // Here we check to see if a 404 came from our website. This allows the
        // webmaster to find broken links and update them in a shorter amount of time.
        if (isset ($_SERVER['HTTP_REFERER']) AND strstr($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME']) !== FALSE)
        {
            // Set a local flag so we can display different messages in our template.
            $this->template_params['local'] = TRUE;
        }
 
        // HTTP Status code.
        $this->response->status(404);
    }
 
    public function action_503()
    {
        $this->template_params['title'] = 'Maintenance Mode';
    }
 
    public function action_500()
    {
        $this->template_params['title'] = 'Internal Server Error';
    }

    /**
     * After function. Passes parameters to the view
     */
    public function after()
    {
        $this->template->content = View::factory('error')->set($this->template_params);

        parent::after();
    }

} // End Error_Handler
