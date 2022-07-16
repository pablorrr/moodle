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
        $maxbytes =  5000000;
        $mform->addElement('filemanager', 'attachments', get_string('attachment', 'moodle'), null,
            array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 50,
                'accepted_types' => array('csv'), 'return_types'=> FILE_INTERNAL | FILE_EXTERNAL));

    }

    //Custom validation should be added here
    function validation($data, $files)
    {
        return array();
    }
}