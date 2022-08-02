<?php
// This file is part of Moodle Course Rollover Plugin
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
 * @package     local_usercrud
 * @author      PablozzzCMP
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


//use add_user\form\form_handle;
require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/user/lib.php');//apply moodle user lib
//require_once(__DIR__ . '\classes\form\form.php');

global $CFG, $USER, $DB, $OUTPUT, $PAGE;

require_login();
$context = context_system::instance();

if (!has_capability('local/user_management:edit', $context)) {
    die();
}
require_capability('local/user_management:edit', $context);

$PAGE->set_url(new moodle_url('/local/user_management/edit.php'));
$PAGE->set_context(\context_system::instance());


// Setup the page
//todo moustache conversion
$PAGE->set_title('Edit User Page.');
$PAGE->set_heading('Edit User Page.');


// ===============
//
//
// PAGE LOGIC
//
//
// ===============

/**
 *
 * Test user_update_user.
 *
 * public function test_user_update_user()
 * {
 * global $DB;
 * $this->resetAfterTest();
 * // Create user and modify user profile.
 * $user = $this->getDataGenerator()->create_user();
 * $user->firstname = 'Test';
 * $user->password = 'M00dLe@T';
 * // Update user and capture event.
 * $sink = $this->redirectEvents();
 * user_update_user($user);
 * $events = $sink->get_events();
 * $sink->close();
 * $event = array_pop($events);
 * // Test updated value.
 * $dbuser = $DB->get_record('user', array('id' => $user->id));
 * $this->assertSame($user->firstname, $dbuser->firstname);
 * $this->assertNotSame('M00dLe@T', $dbuser->password);
 * // Test event.
 * $this->assertInstanceOf('\\core\\event\\user_updated', $event);
 * $this->assertSame($user->id, $event->objectid);
 * $this->assertSame('user_updated', $event->get_legacy_eventname());
 * $this->assertEventLegacyData($dbuser, $event);
 * $this->assertEquals(context_user::instance($user->id), $event->get_context());
 * $expectedlogdata = array(SITEID, 'user', 'update', 'view.php?id=' . $user->id, '');
 * $this->assertEventLegacyLogData($expectedlogdata, $event);
 * // Update user with no password update.
 * $password = $user->password = hash_internal_user_password('M00dLe@T');
 * user_update_user($user, false);
 * $dbuser = $DB->get_record('user', array('id' => $user->id));
 * $this->assertSame($password, $dbuser->password);
 *
 */


/*try {
    user_update_user();
} catch (moodle_exception $e) {
}*/

global $DB;
$userID = 2;
//$DB->get_record('test',array('id'=>5),'name,age');
$userObj = $DB->get_record('user', array('id' => $userID));
$userObj->firstname = 'Mike';

//firstname

user_update_user($userObj);
// ===============
//
//
// PAGE OUTPUT
//
//
// ===============
echo $OUTPUT->header();
$templatecontext = (object)['showuserurl' => new moodle_url('/local/user_management/index.php'),];
echo $OUTPUT->render_from_template('local_user_management/edituser', $templatecontext);
echo '<pre>';
var_dump($userObj);
echo '</pre>';
echo $OUTPUT->footer();
