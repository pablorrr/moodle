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


use local_user_management\createvar;

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

$PAGE->set_title('Create User Page.');
$PAGE->set_heading('Create User Page.');


// ===============
//
//
// PAGE LOGIC
//
//
// ===============

$create_vars = new createvar();

$user = (object)$create_vars->create_vars();

if (!is_object($user)) {
    return;
}

if (isset($_POST['submit'])) {

    try {
        $user_id = user_create_user($user);
        if (isset ($user_id) && !empty($user_id)) {
            $msg = $user_id;
            redirect($CFG->wwwroot . '/local/user_management/index.php', get_string('success_create', 'local_user_management') . $msg);

        }
    } catch (moodle_exception $e) {

        $error = $e->getMessage();
        echo get_string('fail_create', 'local_user_management') . '  ' . $error;
        // $error = $e->getMessage() . '<br>';
        //  echo get_string('fail_create', 'local_user_management');

        //$msg = 'no user has been added';

    }
} else {

    $msg = 'form has not been sent';
    echo get_string('fail_form', 'local_user_management') . $msg;


}

// ===============
//
//
// PAGE OUTPUT
//
//
// ===============
echo $OUTPUT->header();

$templatecontext = (object)['showuserurl' => new moodle_url('/local/user_management/index.php'), 'msg' => $msg, 'error' => $error,];

echo $OUTPUT->render_from_template('local_user_management/createuser', $templatecontext);


//var_dump($_POST);
//var_dump($fname);
//todo form validation, moodle message system create

//var_dump($user);
echo $OUTPUT->footer();
