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
require_once(__DIR__ . '/../../config.php');//zalacznie moodle

global $DB;//db handle main class

require_login();
$context = context_system::instance();
require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/message/manage.php'));//przypisanie tego pliku do url moodle
$PAGE->set_context(\context_system::instance());//njprwd kontekst moodle- njprwd zasieg wtyczki - tutaj njprwd zasieg system - ogolny
$PAGE->set_title(get_string('manage_messages', 'local_message'));
$PAGE->set_heading(get_string('manage_messages', 'local_message'));
//https://docs.moodle.org/dev/AMD_Modal
$PAGE->requires->js_call_amd('local_message/confirm');//zalczemie js z modulu AMD
$PAGE->requires->css('/local/message/styles.css');//zalaczenie css do wtyczki
//get records - pobranie rekordow z db z okreslonym lub nie  filtrem sql
$messages = $DB->get_records('local_message', null, 'id');//pobranie wiadomosci z db

/**
 * njprwd czesc front end
 */
echo $OUTPUT->header();//njprwd zalaczenie naglowka wtyczki

$templatecontext = (object)[
    'messages' => array_values($messages),
    'editurl' => new moodle_url('/local/message/edit.php'),
    'bulkediturl' => new moodle_url('/local/message/bulkedit.php'),
];
// ponizej wsk na sciezke oraz zmienna z jakiej ma byc rendrerowana tyresc front end wtyczki
echo $OUTPUT->render_from_template('local_message/manage', $templatecontext);//renderowanie templatki formularza
$url = new moodle_url('/local/message/pdf/example.pdf');
//$CFG->wwwroot;

echo '<a href="' . $url . '">test pdf</a>';

echo '<a href="' . $CFG->wwwroot . '">test root url</a>';
echo $OUTPUT->footer();
