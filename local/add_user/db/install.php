<?php

/**
 * @package  moodle_local_plugin
 * @copyright 2017, Mohammed Essaid MEZERREG <me@mohessaid.com>
 * @license MIT
 * @doc 
 */

// Allows you to execute a PHP code right after the plugin's database scheme has been installed.
 
defined('MOODLE_INTERNAL') || die();

/*function xmldb_moodle_local_plugin_install(){
    // Installation code goes here

}*/
//source https://moodle.org/mod/forum/discuss.php?d=262419
function xmldb_local_add_user_install() {
    global $DB;
    
    
  /*  $dbman = $DB->get_manager();

    $table = new xmldb_table('calendar');
    $field = new xmldb_field('name of field', ... ); // You'll have to look up the definition to see what other params are needed.

    if (!$dbman->field_exists($table, $field)) {
        $dbman->add_field($table, $field);*/
    }

