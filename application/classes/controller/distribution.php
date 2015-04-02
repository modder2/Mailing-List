<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Controller for Distribution actions
 *
 * @author modder
 */
class Controller_Distribution extends Controller {

    public function before()
    {
        parent::before();

        if ( ! Kohana::$is_cli)
        {
            throw new HTTP_Exception_404('Page not found');
        }
    }

    public function action_run()
    {
        /** var Model_Counter $model_counter */
        $model_counter = Model::factory('counter');
        /** var Model_Email $model_email */
        $model_email = Model::factory('email');

        // Get last run time
        $last_send = $model_counter->get_last_send();
        // Get current mailing list
        $mailing_list = $model_email->get_mailing_list($last_send);
        // Set last run time to the current
        $model_counter->update_last_send();

        foreach ($mailing_list as $email)
        {
            // Send email
            if ($model_email->send_email($email['email']))
            {
                // Change email sending status
                $model_email->update_status($email['id'], Model_Email::STATUS_SENT);
                // Increment success counter
                $model_counter->increment('success');
            }
            else
            {
                // Change email sending status
                $model_email->update_status($email['id'], Model_Email::STATUS_ERROR);
                // Increment failed counter
                $model_counter->increment('error');
            }
        }
    }

} // End Controller_Distribution
