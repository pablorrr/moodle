<?php
//https://docs.moodle.org/dev/Access_API

$capabilities = [
    'local/usercrud:crudallusers' => [
        'riskbitmask' => RISK_SPAM,
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'manager' => CAP_ALLOW,
        ],
    ],
];
