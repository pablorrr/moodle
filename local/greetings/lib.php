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


/**
 * Insert a link to index.php on the site front page navigation menu.
 *
 * @param navigation_node $frontpage Node representing the front page in the navigation tree.
 */

/*function local_greetings_extend_navigation_frontpage(navigation_node $frontpage) {
    $frontpage->add(
        get_string('pluginname', 'local_greetings'),
        new moodle_url('/local/greetings/index.php')
    );
}*/


/**
 * Add link to index.php into navigation drawer.
 *
 * @param global_navigation $root Node representing the global navigation tree.
 */
function local_greetings_extend_navigation(global_navigation $root) {

    $node = navigation_node::create(
        get_string('pluginname', 'local_greetings'),
        new moodle_url('/local/greetings/index.php'),
        navigation_node::TYPE_CUSTOM,
        null,
        null,
        new pix_icon('t/message', '')
    );
    $node->showinflatnavigation = true;

    $root->add_node($node);
}