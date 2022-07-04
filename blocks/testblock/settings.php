<?php


defined('MOODLE_INTERNAL') || die;

global $ADMIN;
if ($ADMIN->fultree) {


    $settings->add(new admin_setting_configcheckbox('block_testblock/showcourses',
        get_string('showcourses', 'block_testblock'),
        get_string('showcoursesdesc', 'block_testblock'),
        0));

}