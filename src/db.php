<?php
function getDb(): PDO
{
    static $db;
    if ($db === null) {
        $config = require __DIR__ . '/../config/config.php';
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $config['db_host'], $config['db_name']);
        $db = new PDO($dsn, $config['db_user'], $config['db_pass']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return $db;
}
