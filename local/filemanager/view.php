<?php

// --------------
//
// Standard Moodle Setup
//
// --------------
require_once('../../config.php');
global $CFG, $USER, $DB, $OUTPUT, $PAGE;

$PAGE->set_url('/local/filemanager/index.php');
require_login();

$PAGE->set_pagelayout('admin');

// Choose the most appropriate context for your file manager - e.g. block, course, course module, this example uses
// the system context (as we are in a 'local' plugin without any other context)
// This is VERY important, the filemanager MUST have a valid context!
$context = context_system::instance();
$PAGE->set_context($context);

// Setup the page
$PAGE->set_title('File Manager Example');
$PAGE->set_heading('File Manager Example');

//DEFINITIONS
require_once($CFG->libdir . '/formslib.php');
require_once('lib.php');


// ===============
//
//
// PAGE OUTPUT
//
//
// ===============
echo $OUTPUT->header();

echo "<a href='/local/filemanager/index.php'><input type='button' value='Manage Files'></a>";
echo "<a style='padding-left:10px' href='/local/filemanager/view.php'><input type='button' value='View Files'></a>";
echo "<br /><br /><br />";


// ---------
// Display Managed Files!
// ---------
$fs = get_file_storage();
echo "<h1>fs</h1>";
echo '<pre>';
var_dump($fs);
echo '</pre>';

echo "<h1>_FILES</h1>";
echo '<pre>';
var_dump($_FILES);
echo '</pre>';

echo "<h1>POST</h1>";
echo '<pre>';
var_dump($_POST);
echo '</pre>';

if ($files = $fs->get_area_files($context->id, 'local_filemanager', 'attachment', '0', 'sortorder', false)) {
    echo "<h1>files</h1>";
    echo '<pre>';
    var_dump($files);
    echo '</pre>';
    // Look through each file being managed
    foreach ($files as $file) {
        echo "<h1>file</h1>";
        echo '<pre>';
        var_dump($file);
        echo '</pre>';
        // Build the File URL. Long process! But extremely accurate.
        $fileurl = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), $file->get_itemid(), $file->get_filepath(), $file->get_filename());
        // Display the image
        $download_url = $fileurl->get_port() ? $fileurl->get_scheme() . '://' . $fileurl->get_host() . $fileurl->get_path() . ':' . $fileurl->get_port() : $fileurl->get_scheme() . '://' . $fileurl->get_host() . $fileurl->get_path();
        echo '<a href="' . $download_url . '">' . $file->get_filename() . '</a><br/>';
    }
} else {
    echo '<p>Please upload an image first</p>';
}


echo $OUTPUT->footer();