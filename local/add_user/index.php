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
use add_user\form\form_handle;


require_once(__DIR__ . '/../../config.php');//zalacznie moodle
require_once(__DIR__ . '\classes\form\form.php');
require_once(__DIR__ . '\classes\form\form_handle.php');
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
    echo '<a href="/local/add_user/index.php"><input type="button" value="Try Again" /><a>';
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
        global $DB;
        $form_handle = new form_handle();
        // Look through each file being managed
        foreach ($files as $file) {

            $form_handle->insert_csv_to_tables($file);
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
