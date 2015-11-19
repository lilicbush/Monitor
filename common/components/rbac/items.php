<?php
return [
    'dashboard' => [
        'type' => 2,
        'description' => 'Главная панель радара',
    ],
    'observer' => [
        'type' => 1,
        'description' => 'Наблюдатель',
        'ruleName' => 'userRole',
    ],
    'manager' => [
        'type' => 1,
        'description' => 'Управляющий',
        'ruleName' => 'userRole',
        'children' => [
            'observer',
            'dashboard',
        ],
    ],
];
