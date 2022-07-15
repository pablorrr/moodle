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
$mform = new simplehtml_form();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
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
}

/**
 * njprwd czesc front end
 */
echo $OUTPUT->header();
//$templatecontext = (object)[

  //  'editurl' => new moodle_url('/local/add_user/simplehtml_form.php')

//];
// ponizej wsk na sciezke oraz zmienna z jakiej ma byc rendrerowana tyresc front end wtyczki
//echo $OUTPUT->render_from_template('local_add_user/add_user',$templatecontext);//renderowanie templatki formularza

//D:\MoodleWindowsInstaller-latest-311\server\moodle\local\add_user
echo  __DIR__ .'\classes\form\simplehtml_form.php';
$mform->display();
echo $OUTPUT->footer();


/**
 * njprwd czesc koniec front end
 */

