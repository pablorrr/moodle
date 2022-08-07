<?php
/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_greetings
 * @copyright   2022 Your Name <you@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function local_greetings_get_greeting($user)
{
    if ($user == null) {
        return get_string('greetinguser', 'local_greetings');
    }

    $country = $user->country;
// Australia, Fiji and New Zealand.
    switch ($country) {
        case 'ES':
            $langstr = 'greetinguseres';
            break;

        case 'AU':
            $langstr = 'greetinguserau';
            break;

        case 'FJ':
            $langstr = 'greetinguserfj';
            break;

        case 'NZ':
            $langstr = 'greetingusernz';
            break;


        default:
            $langstr = 'greetingloggedinuser';
            break;
    }

    return get_string($langstr, 'local_greetings', fullname($user));
}