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
 * @package     local_usercrud
 * @author      PablozzzCMP
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


//use add_user\form\form_handle;
require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/user/lib.php');//apply moodle user lib
//require_once(__DIR__ . '\classes\form\form.php');

global $CFG, $USER, $DB, $OUTPUT, $PAGE;

require_login();
$context = context_system::instance();

if (!has_capability('local/user_management:edit', $context)) {
    die();
}
require_capability('local/user_management:edit', $context);

$PAGE->set_url(new moodle_url('/local/user_management/edit.php'));
$PAGE->set_context(\context_system::instance());


// Setup the page
//todo moustache conversion
$PAGE->set_title('Edit User Page.');
$PAGE->set_heading('Edit User Page.');


// ===============
//
//
// PAGE LOGIC
//
//
// ===============

//get user id from uri
$userID = optional_param('userid', null, PARAM_INT);

global $DB;
//get user obj data within user id - send it to mustache template
$user = $DB->get_record('user', array('id' => $userID));

//todo add field oranizatinal unit and position
//prepare user optional param according to form
$username = optional_param('username', 'Jake', PARAM_USERNAME);
$password = optional_param('password', 'Moodle2012!', PARAM_TEXT);
$idnumber = optional_param('idnumber', 'idnumbertest1', PARAM_TEXT);
$firstname = optional_param('firstname', 'First Name User Test 1', PARAM_TEXT);
$lastname = optional_param('lastname', 'Last Name User Test 1', PARAM_TEXT);
$middlename = optional_param('middlename', 'Middle Name User Test 1', PARAM_TEXT);
$lastnamephonetic = optional_param('lastnamephonetic', '最後のお名前のテスト一号', PARAM_TEXT);
$firstnamephonetic = optional_param('firstnamephonetic', '最後のお名前のテスト一号', PARAM_TEXT);
$alternatename = optional_param('alternatename', 'Alternate Name User Test 1', PARAM_TEXT);
$email = optional_param('email', 'usertest1@email.com', PARAM_EMAIL);
$description = optional_param('description', 'This is a description for user 1', PARAM_TEXT);
$city = optional_param('city', 'Perth', PARAM_TEXT);
$country = optional_param('country', 'au', PARAM_TEXT);


if (isset($_POST['submit'])) {

    try {
        //change user data values according to  form fields

        $user->username = $username;
        $user->password = $password;
        $user->idnumber = $idnumber;
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->middlename = $middlename;
        $user->lastnamephonetic = $lastnamephonetic;
        $user->firstnamephonetic = $firstnamephonetic;
        $user->alternatename = $alternatename;
        $user->email = $email;
        $user->description = $description;
        $user->city = $city;
        $user->country = $country;

        user_update_user($user);

        $msg = 'user has been changed with follow id ' . $userID;

    } catch (moodle_exception $e) {
        $error = $e->getMessage() . '<br>';
        $msg = 'no user  data has been changed';

    }
} else {
    $msg = 'form has not been sent';
}

// ===============
//
//
// PAGE OUTPUT
//
//
// ===============
echo $OUTPUT->header();
$templatecontext = (object)['showuserurl' => new moodle_url('/local/user_management/index.php'),
                            'userobj' => $user, 'msg' => $msg, 'error' => $error,];

echo $OUTPUT->render_from_template('local_user_management/edituser', $templatecontext);
echo $OUTPUT->footer();
