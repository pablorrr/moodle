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
/**
 * @throws ddl_table_missing_exception
 * @throws ddl_exception
 */
function xmldb_local_add_user_install()
{
    global $DB;

    $dbman = $DB->get_manager();

    /*$table = new xmldb_table('calendar');
    $field = new xmldb_field('name of field', ...); // You'll have to look up the definition to see what other params are needed.

    if (!$dbman->field_exists($table, $field)) {
        $dbman->add_field($table, $field);
    }*/
    
    /*$table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null, null, null);
$table->add_field('name', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, null, 'default name');
$table->add_field('course', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null, null, null);
$table->add_field('type', XMLDB_TYPE_CHAR, '20', null, XMLDB_NOTNULL, null, XMLDB_ENUM, array('type1', 'type2', 'type3'), 'type1');
$table->add_field('summary', XMLDB_TYPE_TEXT, 'medium', null, null, null, null, null, null);
 
$table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'), null, null);
$table->add_key('foreignkey1', XMLDB_KEY_FOREIGN, array('courseid'), 'course', array('id')); 
    
   dodanie kolumn do 'mdl_user': position_id (identyfikator wraz z indexem), organizational_unit_id
(identyfikator wraz z indexem), employee_number (varchar). 
    
    */
    
    /*
     * table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null, null, null);
     * 
     * Jednostki organizacyjne są wynikiem podziału pracy .
     * 
     *  Dział tworzy różne jednostki ds. IT, księgowości, sprzedaży, marketingu, HR, finansów itp.
     *  IT oznacza technologię informacyjną , a HR oznacza zasoby ludzkie .
     * 
     * Menedżer : jest to kierownik każdego na niższym stanowisku, niezależnie od jego działu. Nie należy tego mylić z rolą menedżera Moodle!
Kierownik działu : jest to kierownik dowolnej osoby z niższego działu lub poddziału, niezależnie od zajmowanego
     * 
     * 
     * */

    $table = new xmldb_table('user');
    $position_id_field = new xmldb_field('position_id'); 

    if (!$dbman->field_exists($table, $position_id_field)) {
      //  $dbman->add_field($table, $position_id_field);
        $table->add_field('position_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null, null);
        $table->add_key('foreignkey1', XMLDB_KEY_FOREIGN, array('position_id'), 'position', array('id'));

    }

    $organizational_unit_id_field = new xmldb_field('organizational_unit_id');
    
    if (!$dbman->field_exists($table, $organizational_unit_id_field)) {
        $dbman->add_field($table, $organizational_unit_id_field);
    }



}

