<?php

/**
 * @package  moodle_local_plugin
 * @copyright 2017, Mohammed Essaid MEZERREG <me@mohessaid.com>
 * @license MIT
 * @doc 
 */

// Allows you to execute a PHP code right after the plugin's database scheme has been installed.
 
defined('MOODLE_INTERNAL') || die();


//source https://moodle.org/mod/forum/discuss.php?d=262419
/**
 * @throws ddl_table_missing_exception
 * @throws ddl_exception
 */
function xmldb_local_add_user_install()
{
    global $DB;

    $dbman = $DB->get_manager();
    
    $table = new xmldb_table('user');
    $position_id_field = new xmldb_field('position_id'); 

    if (!$dbman->field_exists($table, $position_id_field)) {
        $table->add_field('position_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null, null);
        $table->add_key('position_id', XMLDB_KEY_FOREIGN, array('position_id'), 'position', array('id'));

    }
    $table = new xmldb_table('user');
    $organizational_unit_id_field = new xmldb_field('organizational_unit_id');
    
    if (!$dbman->field_exists($table, $organizational_unit_id_field)) {
       
        $table->add_field('organizational_unit_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null, null);
        $table->add_key('organizational_unit_id', XMLDB_KEY_FOREIGN, array('organizational_unit_id'), 'organizational_unit', array('id'));
    }


    $table = new xmldb_table('user');
    $employee_number = new xmldb_field('employee_number');

    if (!$dbman->field_exists($table,  $employee_number)) {

        $table->add_field('employee_number', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null, null);
     
    }
//employee_number
}

