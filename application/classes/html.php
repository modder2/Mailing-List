<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Extend Kohana HTML helper class
 */
class HTML extends Kohana_HTML {

    /**
     * Protect an email address from spam bots via JavaScript
     *
     * @param   string   email address
     * @return  string   javascript code
     */
    public static function protect_email($email)
    {
        $character_set = '!#$%&\'*+-.0123456789:=?@ABCDEFGHIJKLMNOPQRSTUVWXYZ^_abcdefghijklmnopqrstuvwxyz{}~';
        $key = str_shuffle($character_set);
        $cipher_text = '';
        for ($i = 0; $i < strlen($email); $i++)
        {
            $cipher_text .= $key[strpos($character_set, $email[$i])];
        }
        $script = 'var Ma="'.$key.'",Mb=Ma.split("").sort().join(""),Mc="'.$cipher_text.'",Md="";';
        $script .= 'for(var Mi=0;Mi<Mc.length;Mi++)Md+=Mb.charAt(Ma.indexOf(Mc.charAt(Mi)));';
        $script .= 'document.write(Md);';
        $script = '<script type="text/javascript">(function(){'.$script.'})();</script>';
        return $script;
    }

} // End HTML
