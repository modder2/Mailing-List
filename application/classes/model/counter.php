<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Description of Model_Counter
 *
 * @author modder
 */
class Model_Counter extends ORM {

    public function get_counters()
    {
        $counters = DB::select()
            ->from('counters')
            ->execute()
            ->as_array();

        $array = array();
        $format = Kohana::$config->load('config.date_format');
        foreach ($counters as $counter)
        {
            if ($counter['name'] === 'last_send' AND $counter['value'] > 0)
            {
                // Format dates
                $counter['value'] = date($format, $counter['value']);
            }
            $array[$counter['name']] = $counter['value'];
        }

        return $array;
    }

    public function get_last_send()
    {
        $last_send = ORM::factory('counter', array('name' => 'last_send'));

        return $last_send->loaded() ? (int) $last_send->value : FALSE;
    }

    public function update_last_send()
    {
        ORM::factory('counter', array('name' => 'last_send'))
            ->set('value', time())
            ->update();

        return TRUE;
    }

    public function increment($name)
    {
        $property = ORM::factory('counter', array('name' => $name));
        if ($property->loaded())
        {
            $property->value++;
            $property->update();
            return TRUE;
        }
        return FALSE;
    }

} // End Model_Counter
