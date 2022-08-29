<?php
/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_uploaduser
 * @copyright   2022 Your Name <you@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_uploaduser;
class helper
{
    /**
     * Define helper vardump format
     */
    public function helper($data)
    {
        echo '<pre>';
        vardump($data);
        echo '<pre>';

    }
}