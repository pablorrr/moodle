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
 * @package     local_uploaduser
 * @copyright   2022 Your name <your@email>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_uploaduser\form\form_handle;
use local_uploaduser\form\form;
use local_uploaduser\helper;


// ===============
//
//
// PAGE REQUIREMENTS
//
//
// ===============

global $PAGE, $USER, $OUTPUT, $DB, $CFG;
require_once('../../config.php');

require_once($CFG->libdir . '/formslib.php');

// ===============
//
//
// PAGE SETTINGS
//
//
// ===============


$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/uploaduser/index.php'));
$PAGE->set_pagelayout('standard');
//$PAGE->set_heading(get_string('pluginname', 'local_greetings'));
$PAGE->set_title('uploaduser plugin');
require_login();
require_capability('local/uploaduser:uploaduser', $context);

// ===============
//
//
// PAGE LOGIC
//
//
// ===============
/*$form = new form();

if ($data = $form->get_data()) {

    $content = $form->get_file_content('userfile');



    $form_handle = new form_handle();
     if (isset ($content)) {

      $form_handle->insert_csv_to_tables($content);

      $form_handle->insert_user_orgunit_id();
     $form_handle->insert_user_pos_id();
     }
}*/

// ===============
//
//
// PAGE OUTPUT
//
//
// ===============
echo $OUTPUT->header();


$form = new form();

if ($data = $form->get_data()) {

    $content = $form->get_file_content('userfile');

    $form_handle = new form_handle();
    if (isset ($content)) {

        $form_handle->insert_csv_to_tables($content);

        $form_handle->insert_user_orgunit_id();
        $form_handle->insert_user_pos_id();
    }
}





$form->display();
//echo '<pre>';
//print_r($data);
//echo '</pre>';


echo $OUTPUT->footer();
