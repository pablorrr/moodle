<?php
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>;.

/**
 * @package     local_greetings
 * @copyright   2022 Your name <your@email>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_greetings\form\message_form;

// ===============
//
//
// PAGE REQUIREMENTS
//
//
// ===============
require_once('../../config.php');
require_once($CFG->dirroot . '/local/greetings/lib.php');
require_once($CFG->libdir . '/formslib.php');

// ===============
//
//
// PAGE SETTINGS
//
//
// ===============
global $PAGE, $USER, $OUTPUT, $DB;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/greetings/index.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('pluginname', 'local_greetings'));
$PAGE->set_title('Greetings plugin');

// ===============
//
//
// PAGE LOGIC
//
//
// ===============
$messageform = new message_form();

if ($data = $messageform->get_data()) {
    $message = required_param('message', PARAM_TEXT);

    if (!empty($message)) {
        $record = new stdClass;
        $record->message = $message;
        $record->timecreated = time();

        $DB->insert_record('local_greetings_messages', $record);
    }
}

// ===============
//
//
// PAGE OUTPUT
//
//
// ===============
echo $OUTPUT->header();
if (isloggedin()) {
    //  echo '<h2>Greetings, ' . fullname($USER) . '</h2>';
    // echo get_string('greetingloggedinuser', 'local_greetings', fullname($USER));
    echo local_greetings_get_greeting($USER);
} else {
    echo '<h2>Greetings, user</h2>';
}

$messageform->display();

/*if ($data = $messageform->get_data()) {
    var_dump($data);

    $message = required_param('message', PARAM_TEXT);

    echo $OUTPUT->heading($message, 4);
}*/


echo $OUTPUT->footer();
