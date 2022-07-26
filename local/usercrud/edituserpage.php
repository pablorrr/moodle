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
require_once(__DIR__ . '/../../config.php');//zalacznie moodle
//require_once(__DIR__ . '\classes\form\form.php');

global $CFG, $USER, $DB, $OUTPUT, $PAGE;

//require_login();
$context = context_system::instance();
//todo:fix that below capability
//local/usercrud:crudallusers
require_capability('local/usercrud:crudallusers', $context);

$PAGE->set_url(new moodle_url('/local/usercrud/edituserpage.php'));
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




// ===============
//
//
// PAGE OUTPUT
//
//
// ===============
echo $OUTPUT->header();
echo '<h1>Edit User Page</h1>';
echo $OUTPUT->footer();

