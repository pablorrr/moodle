<?php
// This file is part of Moodle Course Rollover Plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     local_message
 * @author      Kristian
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Njprwd glowny plik boostraopowy wtyczki
 *
 *
 */

use add_user\form\form;


require_once(__DIR__ . '/../../config.php');//zalacznie moodle
require_once(__DIR__ . '\classes\form\form.php');
global $CFG, $USER, $DB, $OUTPUT, $PAGE;

require_login();
$context = context_system::instance();
//todo:fix that below capability
$PAGE->set_pagelayout('admin');
require_capability('local/add_user:add_user', $context);

$PAGE->set_url(new moodle_url('/local/add_user/index.php'));
$PAGE->set_context(\context_system::instance());

//$PAGE->set_title(get_string('add_user', 'local_add_user'));
//$PAGE->set_heading(get_string('add_user', 'local_add_user'));

// Setup the page
$PAGE->set_title('Send User to DB');
$PAGE->set_heading('Send User to DB');


// ===============
//
//
// PAGE LOGIC
//
//
// ===============

// Create some options for the file manager
$filemanageropts = array('subdirs' => 0, 'maxbytes' => '0', 'maxfiles' => 50, 'context' => $context);
$customdata = array('filemanageropts' => $filemanageropts);

// Create a new form object (found in lib.php)
$mform = new form(null, $customdata);
// ===============
//
//
// PAGE OUTPUT
//
//
// ===============
echo $OUTPUT->header();
// ----------
// Form Submit Status
// ----------
if ($mform->is_cancelled()) {
    // CANCELLED
    echo '<h1>Cancelled</h1>';
    echo '<p>Handle form cancel operation, if cancel button is present on form<p>';
    echo '<a href="/local/filemanager/index.php"><input type="button" value="Try Again" /><a>';
} else if ($data = $mform->get_data()) {

    // SUCCESS
    echo '<h1>Success!</h1>';
    echo '<p>In this case you process validated data. $mform->get_data() returns data posted in form.<p>';
    echo '<h1>data var</h1>';
    echo '<pre>';


    // ---------
// Display Managed Files!
// ---------
    $fs = get_file_storage();


    if ($files = $fs->get_area_files($context->id, 'local_filemanager', 'attachment', '0', 'sortorder', false)) {

        // Look through each file being managed
        foreach ($files as $file) {

            $get_content = $file->get_content();
            $enoflinestring = str_replace("\n", 'endOfLine', trim($get_content));
            //echo  $enoflinestring;
            $arr = explode('endOfLine', $enoflinestring);
            echo '<pre>';
            var_dump($arr);
            echo '</pre>';
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
                $DB->insert_records('user', $user_object_arr);
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
                $DB->insert_records('position', $position_object_arr);
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
                $DB->insert_records('organizational_unit', $organizational_unit_object_arr);
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
    } else {
        echo '<p>Please upload an image first</p>';
    }


} else {
    // FAIL / DEFAULT
    echo '<h1 style="text-align:center">Display form</h1>';
    echo '<p>This is the form first display OR "errors"<p>';
    $mform->display();
}
echo $OUTPUT->footer();
