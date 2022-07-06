<?php
/**
 * get_string - refre to  id in lan/en/localmessage
 *
 * set up settings of plugin (option plugin db value)
 *
 * https://docs.moodle.org/dev/Admin_settings
 */
if ($hassiteconfig) { // needs this condition or there is error on login page, check capabilities
//njprwd dodoanie nowej kategori admina powiazanie z prawami dostepu
    $ADMIN->add('localplugins', new admin_category('local_message_category', get_string('pluginname', 'local_message')));
//stworzenie strony z ustwaineimai wtyczki
    $settings = new admin_settingpage('local_message', get_string('pluginname', 'local_message'));

    //dodanie do wtyczki strony ustawien
    $ADMIN->add('local_message_category', $settings);
//njprwd dodoanie do strony ustweinn pol typu checkbox formularza
    $settings->add(new admin_setting_configcheckbox('local_message/enabled',
        get_string('setting_enable', 'local_message'), get_string('setting_enable_desc', 'local_message'), '1'));
//njprwd spiecie wszytskiego razem
    //component value is set up in version.php
    $ADMIN->add('local_message_category', new admin_externalpage('local_message_manage', get_string('manage', 'local_message'),
        $CFG->wwwroot . '/local/message/manage.php'));
}
