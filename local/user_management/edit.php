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



use local_user_management\createvar;

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

$create_vars = new createvar();

if (isset($_POST['submit'])) {

    try {
        //change user data values according to  form fields

        $user->username = $create_vars->create_vars()['username'];
        $user->password = $create_vars->create_vars()['password'];
        $user->idnumber = $create_vars->create_vars()['idnumber'];
        $user->firstname = $create_vars->create_vars()['firstname'];
        $user->lastname = $create_vars->create_vars()['lastname'];
        $user->middlename = $create_vars->create_vars()['middlename'];
        $user->lastnamephonetic = $create_vars->create_vars()['lastnamephonetic'];
        $user->firstnamephonetic = $create_vars->create_vars()['firstnamephonetic'];
        $user->alternatename = $create_vars->create_vars()['alternatename'];
        $user->email = $create_vars->create_vars()['email'];
        $user->description = $create_vars->create_vars()['description'];
        $user->city = $create_vars->create_vars()['city'];
        $user->country = $create_vars->create_vars()['country'];

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
