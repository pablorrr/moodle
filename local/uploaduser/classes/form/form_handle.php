<?php

namespace local_uploaduser\form;

use dml_exception;
use Exception;
use stdClass;

class form_handle
{
    public $db;
    public $error;

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

        $enoflinestring = str_replace("\n", 'endOfLine', trim($content));

        $arr = explode('endOfLine', $enoflinestring);

        //user table has following columns names:
        $additional_arr_key = ['description', 'imagealt', 'lastnamephonetic', 'firstnamephonetic', 'middlename', 'alternatename', 'moodlenetprofile'];
        $keys_arr = array_merge(explode(',', trim($arr[0])), $additional_arr_key);

        //cut off header from the array - seprate content of array from keys name(as future column names)
        array_shift($arr);
        echo '<pre>';
        //    print_r($arr);
        echo '</pre>';
//create temporary array
        echo '<pre>';
        $temp_array = $arr;

        $func = function ($value) {
            return array_values(explode(',', $value));
        };

        $temp_array = array_map($func, $temp_array);

        // print_r($temp_array);


       // print_r($arr);


        echo '</pre>';


        //additional values to array to setup fields in table which cant be default
        foreach ($arr as $key => $value) {
            $arr[$key] = $value . ',description,imagealt,lastnamephonetic,firstnamephonetic,middlename,alternatename,moodlenetprofile';
        }

        //create  array of objects
        //todo njprwd array combine zwoci blad przy gdy bedzie problem przy przypisywaniu kluczy do wartosci - oznacza to niewlasciwy format - DO WYKORZYTSANIA PRZY WALIDACJI!!
        foreach ($arr as $item) {
            try {
                $array_combine = array_combine($keys_arr, explode(',', $item));
            } catch (Exception $e) {
                echo 'Message: ' . $e->getMessage();
            }
            /**walidacja ogolna czy  poprawny format csv liczba kolumn musi odpowiaddac ilisc przyporzadkowanych wartosci**/
            //sprawdz opreacaja array combine powiodla sie - dopasowanie iloscin kluczy do wartosci
            if (!is_array($array_combine) && !$array_combine) {
                $this->error = 'format CSV nieprawidlowy';
                echo $this->error;
                return;
            }
            $object_arr[] = (object)$array_combine;
        }

      //  print_r($arr);

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


        //get username from our csv file
        $username_arr_csv = array_column($multi_arr, 'username');


        /** check if username is empty**/
        if (empty($username_arr_csv)) {
            echo '<h1>brak nazw uzytkownikow w pliku!!!</h1>';
            return;
        }



        //todo return testowe do usniecia!!!!
        return;


        /** check if username is unique**/
        //get username from user table
        $users = $this->db->get_records('user');

        $user_names_arr_db = [];
        foreach ($users as $user) {
            array_push($user_names_arr_db, $user->username);
        }

        //print_r($user_names_arr);
        //compares two arrays of usernames to check if username is unique
        //jesli result pusty oznacza ze nie ma powtorzen

        $result = array_intersect($user_names_arr_db, $username_arr_csv);

        if (is_array($result) && !empty ($result)) {

            echo '<h1>usernames must be different !!!</h1>';
            return;

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