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




require_once(__DIR__ . '/../../config.php');//zalacznie moodle


global $CFG, $USER, $DB, $OUTPUT, $PAGE;

require_login();
$context = context_system::instance();
if (!has_capability('local/user_management:view', $context)) {
    die();
}

require_capability('local/user_management:view', $context);


$PAGE->set_url(new moodle_url('/local/user_management/index.php'));
$PAGE->set_context(\context_system::instance());


// Setup the page
//todo moustache conversion
$PAGE->set_title('Main plugin page. Show all users.');
$PAGE->set_heading('Main plugin page.');


// ===============
//
//
// PAGE LOGIC
//
//
// ===============
global $DB;

$users = $DB->get_records('user');


// ===============
//
//
// PAGE OUTPUT
//
//
// ===============
echo $OUTPUT->header();



// echo $employee_number->employee_number;

$templatecontext = (object)[
    'users' => array_values($users),
    'showuserurl' => new moodle_url('/local/user_management/index.php'),
    'edituserurl' => new moodle_url('/local/user_management/edit.php'),
    'createuserurl' => new moodle_url('/local/user_management/create.php'),


];
echo $OUTPUT->render_from_template('local_user_management/showuser', $templatecontext);


echo $OUTPUT->footer();
