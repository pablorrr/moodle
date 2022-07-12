<?php

/**
 * @package  moodle_local_plugin
 * @copyright 2017, Mohammed Essaid MEZERREG <me@mohessaid.com>
 * @license MIT
 * @doc https://docs.moodle.org/dev/Event_2
 */

namespace add_user\form;

use moodleform;

defined('MOODLE_INTERNAL') || die();

// moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");



class form  extends moodleform {
// Add elements to form.
    public function definition() {
        //https://docs.moodle.org/dev/Using_the_File_API_in_Moodle_forms#filepicker
        // A reference to the form is stored in $this->form.
        // A common convention is to store it in a variable, such as `$mform`.
        $mform = $this->_form; // Don't forget the underscore!
        $maxbytes =  5000000;
        $mform->addElement('filepicker', 'userfile', get_string('file'), null,
            array('maxbytes' => $maxbytes, 'accepted_types' => 'csv'));


    }

    // Custom validation should be added here.
    function validation($data, $files) {
        return [];
    }
}
