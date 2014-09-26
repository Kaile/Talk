<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=talk',
    'username' => 'root',
    'password' => (gethostbyaddr('127.0.0.1') === 'WS23-15') ? 'toortoor' : 'root',
    'charset' => 'utf8',
];
