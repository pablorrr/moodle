<?php

namespace local_uploaduser\form;

use dml_exception;
use stdClass;

class form_handle
{
    public $db;


    public function __construct()
    {
        global $DB;
        $this->db = $DB;
    }


    public function insert_data_to_user_table($user_object_arr_param)
    {
        try {

            $this->db->insert_records('user', $user_object_arr_param);
        } catch (dml_exception $e) {
            echo $e->getMessage();
            echo '<br>';
            echo $e->debuginfo;
            echo '<br>';
            echo '<br>';
            echo $e->errorcode;
            echo '<br>';
            echo '<br>';
            echo $e->getLine();
            echo '<br>';
            echo '<br>';
            echo $e->getTrace();
            echo '<br>';
        }
    }


    public function insert_data_to_position_table($position_object_arr_param)
    {

        try {

            $this->db->insert_records('position', $position_object_arr_param);
        } catch (dml_exception $e) {
            echo $e->getMessage();
            echo '<br>';
            echo $e->debuginfo;
            echo '<br>';
            echo '<br>';
            echo $e->errorcode;
            echo '<br>';
            echo '<br>';
            echo $e->getLine();
            echo '<br>';
            echo '<br>';
            echo $e->getTrace();
            echo '<br>';
        }
    }


    public function insert_data_to_organizational_unit_table($organizational_unit_object_arr_param)
    {

        try {

            $this->db->insert_records('organizational_unit', $organizational_unit_object_arr_param);
        } catch (dml_exception $e) {
            echo $e->getMessage();
            echo '<br>';
            echo $e->debuginfo;
            echo '<br>';
            echo '<br>';
            echo $e->errorcode;
            echo '<br>';
            echo '<br>';
            echo $e->getLine();
            echo '<br>';
            echo '<br>';
            echo $e->getTrace();
            echo '<br>';
        }
    }


    public function insert_csv_to_tables($content)
    {
        //  $get_content = $single_file->get_content();
        $enoflinestring = str_replace("\n", 'endOfLine', trim($content));

        $arr = explode('endOfLine', $enoflinestring);

        //user table has following columns names:
        $additional_arr_key = ['description', 'imagealt', 'lastnamephonetic', 'firstnamephonetic', 'middlename', 'alternatename', 'moodlenetprofile'];
        $keys_arr = array_merge(explode(',', trim($arr[0])), $additional_arr_key);

        //cut off header from the array - seprate content of array from keys name(as future column names)
        array_shift($arr);
        //  var_dump($arr);
        //additional values to array to setup fields in table which cant be default
        foreach ($arr as $key => $value) {
            $arr[$key] = $value . ',description,imagealt,lastnamephonetic,firstnamephonetic,middlename,alternatename,moodlenetprofile';
        }

        //create  array of objects
        foreach ($arr as $item) {
            $object_arr[] = (object)array_combine($keys_arr, explode(',', $item));
        }

        $this->count_arr_el = count($object_arr);

        //  $count_arr_el= count($object_arr);
        // echo '<pre>';
        // var_dump($count_arr_el);
        //   echo '</pre>';

        //cloning objects to specify which object is sending as parameter to given table name at insert method
        foreach ($object_arr as $clon) {
            if (is_object($clon)) {
                $user_object_arr[] = clone $clon;
                $position_object_arr[] = clone $clon;
                $organizational_unit_object_arr[] = clone $clon;
            }
        }
        /**
         *send data to user table
         */
        //user_object_arr preparation for sending to table
        foreach ($user_object_arr as $object) {
            if (is_object($object)) {
                unset($object->organizational_unit);
                unset($object->position);

            }
        }
        //convert obj to array to get username col val
        foreach ($user_object_arr as $object) {
            $arr = (array)$object;
            $multi_arr[] = $arr;
        }

        // var_dump($multi_arr);

        $username_arr = array_column($multi_arr, 'username');

        if (count($username_arr) !== count(array_unique($username_arr))) {

            echo '<h1>usernames must be different !!!</h1>';

        } else {
            $this->insert_data_to_user_table($user_object_arr);
        }


        /**
         *send data to position table
         */

        foreach ($position_object_arr as $object) {
            unset($object->username);
            unset($object->lastname);
            unset($object->email);
            unset($object->firstname);

            unset($object->description);
            unset($object->imagealt);
            unset($object->lastnamephonetic);
            unset($object->firstnamephonetic);
            unset($object->middlename);
            unset($object->alternatename);
            unset($object->moodlenetprofile);

            unset($object->employee_number);
            unset($object->organizational_unit);
        }

        $this->insert_data_to_position_table($position_object_arr);


        /**
         * send data to organizational_unit table
         */

        foreach ($organizational_unit_object_arr as $object) {

            unset($object->username);
            unset($object->lastname);
            unset($object->email);
            unset($object->firstname);
            unset($object->employee_number);
            unset($object->position);

            unset($object->description);
            unset($object->imagealt);
            unset($object->lastnamephonetic);
            unset($object->firstnamephonetic);
            unset($object->middlename);
            unset($object->alternatename);
            unset($object->moodlenetprofile);

        }

        $this->insert_data_to_organizational_unit_table($organizational_unit_object_arr);
    }


    public function insert_user_pos_id()
    {
        //odnajdz usera z najwyzszym id -ostatniego
        $sql = 'SELECT `id` FROM `mdl_user` WHERE `id` = (SELECT MAX(`id`) FROM `mdl_user`)';
        $user_id = $this->db->get_record_sql($sql);

        //zbierz wszytskie id z tabeli position
        $position = $this->db->get_records('position');


        //rewers  tablicy by id  buyly odpwiednio dopasowane
        $reversed_pos = array_reverse($position);
        //update kolumny
        foreach ($reversed_pos as $pos_id) {

            $user = new stdClass();
            $user->id = $user_id->id;
            $user->position_id = $pos_id->id;

            $this->db->update_record('user', $user);
            $user_id->id--;
        }

    }

    public function insert_user_orgunit_id()
    {
        //odnajdz usera z najwyzszym id -ostatniego
        $sql = 'SELECT `id` FROM `mdl_user` WHERE `id` = (SELECT MAX(`id`) FROM `mdl_user`)';
        $user_id = $this->db->get_record_sql($sql);

        //zbierz wszytskie id z tabeli position
        $organizational_unit = $this->db->get_records('organizational_unit');

        //rewers  tablicy by id  buyly odpwiednio dopasowane
        $reversed_org = array_reverse($organizational_unit);
        //update kolumny
        foreach ($reversed_org as $unit_id) {

            $user = new stdClass();
            $user->id = $user_id->id;
            $user->organizational_unit_id = $unit_id->id;

            $this->db->update_record('user', $user);
            $user_id->id--;
        }

    }

}