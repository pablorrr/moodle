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

use local_message\form\bulkedit;
use local_message\manager;

/**
 * bulk editor - menu rozwijalne do masowych zastosowan przy edycji w formualrzu wtyczki
 *
 * scisle powiwazaznie z drugim plik bulk edit w classes / form
 */
require_once(__DIR__ . '/../../config.php');
/**
 *  This function checks that the current user is logged in and has the
 * required privileges
 */
require_login();

/**
 * kontekst i zasueg wtyczki tutaj njprwd oglonosdostepny w w moodle
 */
$context = context_system::instance();

/**
 * check if user  has possibility to use plugin
 */
require_capability('local/message:managemessages', $context);
//https://docs.moodle.org/dev/Page_API#.24PAGE_The_Moodle_page_global
// $PAGE służy do konfiguracji strony, a $OUTPUT służy do wyświetlania strony
$PAGE->set_url(new moodle_url('/local/message/bulkedit.php'));//create  access uri
$PAGE->set_context(\context_system::instance());
//get_string - njpwd internacjpnalizacja
$PAGE->set_title(get_string('bulk_edit', 'local_message'));//setes title of the page
//zalaczenie html powyzej <body>
$PAGE->set_heading(get_string('bulk_edit_messages', 'local_message'));//zalaczenie nagłówka
/**
 * do ndanaia wartosci parametrom przesylanym przez post  i get
 */
$messageid = optional_param('messageid', null, PARAM_INT);

// We want to display our form.
$mform = new bulkedit();//custom class defined in plugin
$manager = new manager();//custom class defined in plugin

if ($mform->is_cancelled()) {//do when  cancel button is clicked, is canceled native moodle function
    // Go back to manage.php page
    //$CFG - moodel  global var built in , referring to config file
    redirect($CFG->wwwroot . '/local/message/manage.php', get_string('cancelled_form', 'local_message'));

    /**
     *  get_data() -Return submitted data if properly submitted or returns NULL if validation fails or
     * if there is no submitted data.
     */
} else if ($fromform = $mform->get_data()) {//if form is submitted
    $messages = $fromform->messages;//pobranie  wodomosci z przeslanego formualrza
    $messageids = [];
    foreach ($messages as $key => $enabled) {
        if ($enabled == true) {
            $messageids[] = substr($key, 9);//njpwrd tworzenie tablicy z id messages tworzonychz apomoca substringu liczby
        }
    }
    //if (is_array($messageids)) {
    if ($messageids) {
        if ($fromform->deleteall == true) {//njprwd gdy checkbox
            $manager->delete_messages($messageids);//usun wiaodmosci z metody pluginu
        } else {//gdy message nie istniaja aktualizuj je
            $manager->update_messages($messageids, $fromform->messagetype);
        }
    }
//redirect with return message
    redirect($CFG->wwwroot . '/local/message/manage.php', get_string('bulk_edit_successful', 'local_message'));
}
/**
 * fornt end part
 * $OUTPUT - moddel supert global var for echoing fornt end plugin content
 *
 */
echo $OUTPUT->header();//echoing header
$mform->display();//display plugin form content
echo $OUTPUT->footer();//echoing footer
