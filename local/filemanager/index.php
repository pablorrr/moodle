<?php
// ===============
//
//	FILE MANAGER EXAMPLE
//
// ===============
// @Author: Andy Normore
// @Author: Davo Smith  
// https://github.com/AndyNormore/MoodleFileManager

// The point of this file is to demonstrate how to manage files within Moodle 2.3
// Why? Because file management is incredibly hard for some reason.
// This file is built to run as STANDALONE, no external files or strings. Just 100% easy to understand! (Noob friendly)
// Thanks to Davo Smith for helping to create this project. 


// --------------
//
// Standard Moodle Setup
//
// --------------


/*
 *
 * https://docs.moodle.org/dev/File_API WAZNE!!!!!
 * */
require_once('../../config.php');
global $CFG, $USER, $DB, $OUTPUT, $PAGE;

$PAGE->set_url(new moodle_url('/local/filemanager/index.php'));
require_login();

$PAGE->set_pagelayout('admin');

// Choose the most appropriate context for your file manager - e.g. block, course, course module, this example uses
// the system context (as we are in a 'local' plugin without any other context)
// This is VERY important, the filemanager MUST have a valid context!
$context = context_system::instance();
$PAGE->set_context($context);

// Setup the page
$PAGE->set_title('File Manager Example');
$PAGE->set_heading('File Manager Example');

//DEFINITIONS
require_once($CFG->libdir . '/formslib.php');
require_once('lib.php');


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
$mform = new simplehtml_form(null, $customdata);

// ---------
// CONFIGURE FILE MANAGER
// ---------
// From http://docs.moodle.org/dev/Using_the_File_API_in_Moodle_forms#filemanager
$itemid = 0; // This is used to distinguish between multiple file areas, e.g. different student's assignment submissions, or attachments to different forum posts, in this case we use '0' as there is no relevant id to use

// Fetches the file manager draft area, called 'attachments' 
$draftitemid = file_get_submitted_draft_itemid('attachments');

// Copy all the files from the 'real' area, into the draft area
file_prepare_draft_area($draftitemid, $context->id, 'local_filemanager', 'attachment', $itemid, $filemanageropts);

// Prepare the data to pass into the form - normally we would load this from a database, but, here, we have no 'real' record to load
$entry = new stdClass();
$entry->attachments = $draftitemid; // Add the draftitemid to the form, so that 'file_get_submitted_draft_itemid' can retrieve it
// --------- 


// Set form data
// This will load the file manager with your previous files
$mform->set_data($entry);


// ===============
//
//
// PAGE OUTPUT
//
//
// ===============
echo $OUTPUT->header();

echo "<a href='/local/filemanager/index.php'><input type='button' value='Manage Files'></a>";
echo "<a style='padding-left:10px' href='/local/filemanager/view.php'><input type='button' value='View Files'></a>";

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

    $saved = file_save_draft_area_files($draftitemid, $context->id, 'local_filemanager', 'attachment', $itemid, $filemanageropts);
    //file_save_draft_area_files($draftitemid, $context->id, 'local_filemanager', 'attachment', $itemid, $filemanageropts);
    // var_dump($saved);


    // ---------
// Display Managed Files!
// ---------
    $fs = get_file_storage();
    echo "<h1>fs</h1>";
    echo '<pre>';
    // var_dump($fs);
    echo '</pre>';


    if ($files = $fs->get_area_files($context->id, 'local_filemanager', 'attachment', '0', 'sortorder', false)) {
        echo "<h1>files</h1>";
        echo '<pre>';
        //  var_dump($files);
        echo '</pre>';
        // Look through each file being managed
        foreach ($files as $file) {
            echo "<h1>file</h1>";
            echo '<pre>';
            //   var_dump($file);

            echo '</pre>';


            $get_content = $file->get_content();
            echo "<h1>file content</h1>";
            echo '<pre>';
            //   var_dump($get_content);

            echo '</pre>';
            if (is_string($get_content)) {
                echo '<h1>is string</h1>';
            } else {
                echo '<h1>is string</h1>';
            }


            echo '<pre>';
            echo '</pre>';

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
            var_dump($arr);
            //additional values to array to setup fields in table which cant be default
            foreach ($arr as $key => $value) {
                $arr[$key] = $value . ',description,imagealt,lastnamephonetic,firstnamephonetic,middlename,alternatename,moodlenetprofile';
            }

            //create  array of objects
            foreach ($arr as $item) {
                //  echo '<br>';
                //  echo $item;
                //  echo '<br>';
                $object_arr[] = (object)array_combine($keys_arr, explode(',', $item));

            }

            echo '<h1>object arr el count' . count($object_arr) . '<br>arr el count' . count($arr) . '</h1>';
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


            // Build the File URL. Long process! But extremely accurate.
            $fileurl = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), $file->get_itemid(), $file->get_filepath(), $file->get_filename());
            // Display the image
            $download_url = $fileurl->get_port() ? $fileurl->get_scheme() . '://' . $fileurl->get_host() . $fileurl->get_path() . ':' . $fileurl->get_port() : $fileurl->get_scheme() . '://' . $fileurl->get_host() . $fileurl->get_path();
            echo '<a href="' . $download_url . '">' . $file->get_filename() . '</a><br/>';
        }
    } else {
        echo '<p>Please upload an image first</p>';
    }


    $saved = file_save_draft_area_files($draftitemid, $context->id, 'local_filemanager', 'attachment', $itemid, $filemanageropts);
    //file_save_draft_area_files($draftitemid, $context->id, 'local_filemanager', 'attachment', $itemid, $filemanageropts);
    var_dump($saved);
} else {
    // FAIL / DEFAULT
    echo '<h1 style="text-align:center">Display form</h1>';
    echo '<p>This is the form first display OR "errors"<p>';
    $mform->display();
}
echo $OUTPUT->footer();
