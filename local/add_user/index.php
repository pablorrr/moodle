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

use add_user\form\simplehtml_form;

require_once(__DIR__ . '/../../config.php');//zalacznie moodle
require_once(__DIR__ . '\classes\form\simplehtml_form.php');
global $DB;//db handle main class

require_login();
$context = context_system::instance();
require_capability('local/add_user:add_user', $context);

$PAGE->set_url(new moodle_url('/local/add_user/index.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('add_user', 'local_add_user'));
$PAGE->set_heading(get_string('add_user', 'local_add_user'));

//get records - pobranie rekordow z db z okreslonym lub nie  filtrem sql
//$messages = $DB->get_records('local_add_user', null, 'id');

//Instantiate simplehtml_form 


//Form processing and displaying is done here
/*if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
    //In this case you process validated data. $mform->get_data() returns data posted in form.
} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.

    //Set default data (if any)
    $mform->set_data($toform);
    //displays the form
    //$mform->display();
}*/

/*
 * https://www.tutsmake.com/import-csv-file-into-mysql-using-php/
 * 
 * <?php
// include mysql database configuration file
include_once 'db.php';
 
if (isset($_POST['submit']))
{
 
    // Allowed mime types
    $fileMimes = array(
        'text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain'
    );
 
    // Validate whether selected file is a CSV file
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes))
    {
 
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
 
            // Skip the first line
            fgetcsv($csvFile);
 
            // Parse data from CSV file line by line
             // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE)
            {
                // Get row data
                $name = $getData[0];
                $email = $getData[1];
                $phone = $getData[2];
                $status = $getData[3];
 
                // If user already exists in the database with the same email
                $query = "SELECT id FROM users WHERE email = '" . $getData[1] . "'";
 
                $check = mysqli_query($conn, $query);
 
                if ($check->num_rows > 0)
                {
                    mysqli_query($conn, "UPDATE users SET name = '" . $name . "', phone = '" . $phone . "', status = '" . $status . "', created_at = NOW() WHERE email = '" . $email . "'");
                }
                else
                {
                     mysqli_query($conn, "INSERT INTO users (name, email, phone, created_at, updated_at, status) VALUES ('" . $name . "', '" . $email . "', '" . $phone . "', NOW(), NOW(), '" . $status . "')");
 
                }
            }
 
            // Close opened CSV file
            fclose($csvFile);
 
            header("Location: index.php");
         
    }
    else
    {
        echo "Please select valid file";
    }
}
 * */
$mform = new simplehtml_form();
if ($data = $mform->get_data()) {
    var_dump($_FILES);
    $name = $mform->get_new_filename('attachments');
    $content = $data;
   var_dump($content);
    $contentos = 'not empty';
    
} else {
    $name="empty";
    $contentos = 'empty';
}

/**
 * njprwd czesc front end
 */
echo $OUTPUT->header();


$mform->display();
//var_dump($content);
echo $name;
echo $contentos;

echo $OUTPUT->footer();


/**
 * njprwd czesc koniec front end
 */

