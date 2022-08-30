<?php
/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_greetings
 * @copyright   2022 Your Name <you@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_uploaduser\form;

use moodleform;

class form extends moodleform
{

    /**
     * Define the form.
     */
    public function definition()
    {
        $mform = $this->_form; // Don't forget the underscore!
       // https://www.rozmiar.com/ile-mb-ma-kb-bajtow.php
        //przlicznik - 1 MB =  1 048 576 B (bajtow )
       // $maxbytes = 500;
        $maxbytes = 5242880;//5MB
        $mform->addElement('filepicker', 'userfile', get_string('file'), null,
            array('maxbytes' => $maxbytes, 'accepted_types' => 'csv'));

        $submitlabel = get_string('submit');
        $mform->addElement('submit', 'submitmessage', $submitlabel);
    }
}
