<?php
//https://docs.moodle.org/dev/Access_API
//okreslanie dostepnosci do db tabel wtyczki za pomoca rol moodle
$capabilities = [
    'local/adduser:admin' => [
        'riskbitmask' => RISK_SPAM,
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'manager' => CAP_ALLOW,
        ],
    ],
];
