<?php

namespace add_user\form;
//moodleform is defined in formslib.php
use moodleform;

require_once("$CFG->libdir/formslib.php");

class simplehtml_form extends moodleform

{
    //Add elements to form
    public function definition()
    {
        global $CFG;

        $mform = $this->_form; // Don't forget the underscore! 

        $mform->addElement('filepicker', 'userfile', get_string('file'), null,
            array('maxbytes' => $maxbytes, 'accepted_types' => '*'));    // Default value.

    }

    //Custom validation should be added here
    function validation($data, $files)
    {
        return array();
    }
}