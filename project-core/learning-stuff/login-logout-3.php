<?php

session_start();
session_unset();
session_destroy();

header('location: login-logout-2.php');
return;

?>