<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Description of Model_Email
 *
 * @author modder
 */
class Model_Email extends ORM {

    // Sending statuses
    const STATUS_SENT  = 'sent';
    const STATUS_WAIT  = 'wait';
    const STATUS_ERROR = 'error';

    public static function exist_email($email)
    {
        return (bool) ORM::factory('email', array('email' => $email))->loaded();
    }

    public static function unique_email($email)
    {
        return ! self::exist_email($email);
    }

    public static function check_email_hash($email, $hash)
    {
        return (bool) ORM::factory('email', array('email' => $email, 'unsubscribe_hash' => $hash))->loaded();
    }

    public function get_emails()
    {
        $emails = DB::select()
            ->from('emails')
            ->order_by('id')
            ->execute()
            ->as_array();

        $format = Kohana::$config->load('config.date_format');
        foreach($emails as $key => $email)
        {
            // Format dates
            $emails[$key]['sending_time'] = date($format, $email['sending_time']);
        }

        return $emails;
    }

    public function add_email(array $data)
    {
        $data['sending_time'] = strtotime($data['sending_time']);

        $expected = array('email', 'sending_time');

        ORM::factory('email')
            ->values($data, $expected)
            ->create();

        return TRUE;
    }

    public function update_email_time($email, $sending_time)
    {
        $sending_time = strtotime($sending_time);

        ORM::factory('email', array('email' => $email))
            ->set('sending_time', $sending_time)
            ->update();

        return TRUE;
    }

    public function update_status($email_id, $status)
    {
        ORM::factory('email', $email_id)
            ->set('last_status', $status)
            ->update();

        return TRUE;
    }

    /**
     * Update unsubscribe hash in DB
     *
     * @param  string  email address
     * @param  string  unsubscribe hash
     * @return bool
     */
    public function update_hash($email, $hash)
    {
        ORM::factory('email', array('email' => $email))
            ->set('unsubscribe_hash', $hash)
            ->update();

        return TRUE;
    }

    public function get_mailing_list($last_send)
    {
        return DB::select()
            ->from('emails')
            ->where('sending_time', 'BETWEEN', array($last_send, time()))
            ->execute()
            ->as_array();
    }

    public function send_email($email)
    {
        $config = Kohana::$config->load('config');
        $message = str_replace('{current_date}', date($config['date_format']), $config['mail']['message']);
        $hash = strtolower(Text::random('alnum', 10));
        $this->update_hash($email, $hash);
        $unsubscribe_url = Route::url('unsubscribe', array(
            'email' => rawurlencode($email),
            'hash' => $hash,
        ));
        $message = str_replace('{unsubscribe_url}', $unsubscribe_url, $message);
        $sent_cnt = Email::factory($config['mail']['subject'], $message, 'text/html', $config['mail']['config_name']) //($subject, $body, 'text/html', $config_name)
            ->to($email)
            ->send();

        return (bool) $sent_cnt;
    }

    public function delete_email($email)
    {
        ORM::factory('email', array('email' => $email))->delete();
        return TRUE;
    }

} // End Model_Email
