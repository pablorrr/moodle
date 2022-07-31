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





require_once(__DIR__ . '/../../config.php');//zalacznie moodle

require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/csvlib.class.php');
require_once($CFG->dirroot.'/'.$CFG->admin.'/tool/uploaduser/locallib.php');
require_once($CFG->dirroot.'/'.$CFG->admin.'/tool/uploaduser/user_form.php');

global $CFG, $USER, $DB, $OUTPUT, $PAGE;

require_login();
$context = context_system::instance();
//todo:fix that below capability
$PAGE->set_pagelayout('admin');
//require_capability('local/add_user:managemessages', $context);

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
$iid         = optional_param('iid', '', PARAM_INT);
$previewrows = optional_param('previewrows', 10, PARAM_INT);

core_php_time_limit::raise(60 * 60); // 1 hour should be enough.
raise_memory_limit(MEMORY_HUGE);

admin_externalpage_setup('tooluploaduser');

$returnurl = new moodle_url('/admin/tool/uploaduser/index.php');
$bulknurl  = new moodle_url('/admin/user/user_bulk.php');

if (empty($iid)) {
    $mform1 = new admin_uploaduser_form1();

    if ($formdata = $mform1->get_data()) {
        $iid = csv_import_reader::get_new_iid('uploaduser');
        $cir = new csv_import_reader($iid, 'uploaduser');

        $content = $mform1->get_file_content('userfile');

        $readcount = $cir->load_csv_content($content, $formdata->encoding, $formdata->delimiter_name);

        $csvloaderror = $cir->get_error();
        unset($content);

        if (!is_null($csvloaderror)) {
            print_error('csvloaderror', '', $returnurl, $csvloaderror);
        }
        // Continue to form2.

    } else {
        echo $OUTPUT->header();

        echo $OUTPUT->heading_with_help(get_string('uploadusers', 'tool_uploaduser'), 'uploadusers', 'tool_uploaduser');

        $mform1->display();
        echo $OUTPUT->footer();
        die;
    }
} else {
    $cir = new csv_import_reader($iid, 'uploaduser');
}

// ===============
//
//
// PAGE OUTPUT
//
//
// ===============
//echo $OUTPUT->header();
//echo '<h1>works</h1>';
//echo $OUTPUT->footer();