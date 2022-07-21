<?php
//Instantiate simplehtml_form 
use add_user\form\simplehtml_form;

//

require_once(__DIR__ . '/../../config.php');
/**
 * edit message template , associate with same named class
 *
 */
require_login();
$context = context_system::instance();
//require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/add_user/simplehtml_form.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Form');



// We want to display our form.
$mform = new simplehtml_form();

if ($mform->is_cancelled()) {//after  cancel form button clicking redirect to the maanage page
    // Go back to manage.php page
   // redirect($CFG->wwwroot . '/local/message/manage.php', get_string('cancelled_form', 'local_message'));

} else if ($fromform = $mform->get_data()) {//do this after submit form
  
echo 'submitted';
 
}



echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();

