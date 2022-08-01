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

// ===============
//
//
// PAGE REQUIRE , SETUP, ACCESS SECURITY
//
//
// ===============
//use add_user\form\form_handle;


require_once(__DIR__ . '/../../config.php');//zalacznie moodle
//require_once(__DIR__ . '\classes\form\form.php');
require_once($CFG->dirroot . '/user/lib.php');//apply moodle user lib
//$CFG->dirroot

global $CFG, $USER, $DB, $OUTPUT, $PAGE;
echo '<pre>';


//var_dump($CFG);
echo '</pre>';
require_login();
$context = context_system::instance();

if (!has_capability('local/user_management:create', $context)) {
    die();
}
require_capability('local/user_management:create', $context);

$PAGE->set_url(new moodle_url('/local/user_management/create.php'));
$PAGE->set_context(\context_system::instance());


// Setup the page
//todo moustache conversion
$PAGE->set_title('Create User Page.');
$PAGE->set_heading('Create User Page.');


// ===============
//
//
// PAGE LOGIC
//
//
// ===============

/*$user = array('username' => 'usernametest1',
    'password' => 'Moodle2012!',
    'idnumber' => 'idnumbertest1',
    'firstname' => 'First Name User Test 1',
    'lastname' => 'Last Name User Test 1',
    'middlename' => 'Middle Name User Test 1',
    'lastnamephonetic' => '最後のお名前のテスト一号',
    'firstnamephonetic' => 'お名前のテスト一号',
    'alternatename' => 'Alternate Name User Test 1',
    'email' => 'usertest1@email.com',
    'description' => 'This is a description for user 1',
    'city' => 'Perth',
    'country' => 'au');*/

/*try {
    user_create_user($user);
} catch (moodle_exception $e) {
    echo $e->getMessage() . '<br>';

}*/

$username = optional_param('username', 'Jake', PARAM_USERNAME);
$password = optional_param('password', 'Moodle2012!', PARAM_TEXT);
$idnumber = optional_param('idnumber', 'idnumbertest1', PARAM_STRINGID);
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

/*if ($username && $password && $idnumber && $firstname && $lastname && $middlename
    && $lastnamephonetic && $firstnamephonetic && $alternatename
    && $email && $description && $city && $country
)*/

/*
$city  = "San Francisco";
$state = "CA";
$event = "SIGGRAPH";

$location_vars = array("city", "state","event");

$result = compact($location_vars);*/


$location_vars = ['username', 'password', 'idnumber', 'firstname', 'lastname', 'middlename', 'lastnamephonetic',
         'firstnamephonetic', 'alternatename', 'email', 'description', 'city', 'country'];

$user = compact($location_vars);


// ===============
//
//
// PAGE OUTPUT
//
//
// ===============
echo $OUTPUT->header();
$templatecontext = (object)['showuserurl' => new moodle_url('/local/user_management/index.php'),];
echo $OUTPUT->render_from_template('local_user_management/createuser', $templatecontext);

//var_dump($_POST);
//var_dump($fname);

print_r($user);
echo $OUTPUT->footer();
