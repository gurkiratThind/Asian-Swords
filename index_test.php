<?php

require_once 'db_pdo.php';

$DB = new db_pdo();
//$DB->query('INSERT INTO users(name,email,pw,level) VALUES ("test mam","test@gmail.com","12312312","employee")');
$users = $DB->querySelect('SELECT * from users');
var_dump($users);
$DB->disconnect();
