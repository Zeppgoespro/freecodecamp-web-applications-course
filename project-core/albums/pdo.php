<?php

$pdo = new PDO('mysql:host=mysql-wa4e; dbname=albums', 'root', 'yesenin');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>