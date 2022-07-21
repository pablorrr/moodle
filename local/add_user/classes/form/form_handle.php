<?php

namespace add_user\form;

use dml_exception;

class form_handle
{
    public $db;

    public function __construct()
    {
        global $DB;
        $this->db = $DB;
    }

    public function insert_csv_to_tables($single_file)
    {

        //global $DB;
        $get_content = $single_file->get_content();
        $enoflinestring = str_replace("\n", 'endOfLine', trim($get_content));
        //echo  $enoflinestring;
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


        //cloning objects to specify which object is sendig as parameter to given table name at insert method
        foreach ($object_arr as $clon) {
            if (is_object($clon)) {
                $user_object_arr[] = clone $clon;
                $position_object_arr[] = clone $clon;
                $organizational_unit_object_arr[] = clone $clon;
            }
        }

        //user_object_arr preparation for sending to table
        foreach ($user_object_arr as $object) {
            if (is_object($object)) {
                unset($object->organizational_unit);
                unset($object->position);

            }
        }

///////////////send data to user table//////////////////////////////////////
        try {
            
            $this->db->insert_records('user', $user_object_arr);
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

        /////////////////////send data to position table///////////////////////////////////

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


        try {
            $this->db->insert_records('position', $position_object_arr);
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


        /////////////////////send data to organizational_unit table///////////////////////////////////

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


        try {
            $this->db->insert_records('organizational_unit', $organizational_unit_object_arr);
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

}