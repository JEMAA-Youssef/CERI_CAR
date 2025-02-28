<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db['dsn'] = 'PostgreSQL:host=127.0.0.1;dbname=etd';

return $db;
