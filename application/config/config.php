<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
    'date_format' => 'j F Y H:i',
    'mail' => array(
        'subject' => 'Mail from "Mailing list"',
        'message' => '<h1>Send time: {current_date}</h1>',
        'config_name' => 'default', // Config name from config/email.php (default, smtp)
    )
);
