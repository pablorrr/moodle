<?php
// This file is part of Moodle - http://moodle.org/
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
 * Form for editing HTML block instances.
 *
 * @package   block_testblock
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * ONLY FOR EDUCATIONAL PURPOSES
 * https://youtu.be/Dy_1LueyAxo
 */
class block_testblock extends block_base
{

    function init()
    {
        $this->title = get_string('test block', 'block_testblock');
    }


    function has_config()
    {
        return true;
    }


    function get_content()
    {

        global $DB;

        if ($this->content !== NULL) {
            return $this->content;
        }


        //get useres from DB

        //get courses courses
        $content = '';
        $courses = $DB->get_records('course');

        foreach ($courses as $course) {
            $content .= $course->fullname . '<br>';
        }

        $this->content = new stdClass;
        $this->content->text = $content;
        $this->content->footer = 'footer text';


        return $this->content;
    }
}
