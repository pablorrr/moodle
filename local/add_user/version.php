<?php

/**
 * @package  local_plugin_test
 * @copyright 2017, PABLOZZ <me@pablozzz.com>
 * @license MIT
 * @doc https://docs.moodle.org/dev/version.php
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version  = 2021051700;    // The current module version (Date: YYYYMMDDXX).
$plugin->requires = 2021051100;    // Requires this Moodle version.
$plugin->maturity = MATURITY_ALPHA; // This is considered as ALPHA for production sites.
$plugin->release = 'v0.0.1'; // This is our first.
$plugin->component = 'local_plugin_test'; // Declare the type and name of this plugin.