<?php
/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_greetings
 * @copyright   2022 Your Name <you@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_greetings\form;

use moodleform;

class message_form extends moodleform
{

    /**
     * Define the form.
     */
    public function definition()
    {
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('textarea', 'message', get_string('yourmessage', 'local_greetings'));
        $mform->setType('message', PARAM_TEXT);
        $submitlabel = get_string('submit');
        $mform->addElement('submit', 'submitmessage', $submitlabel);
    }


}
