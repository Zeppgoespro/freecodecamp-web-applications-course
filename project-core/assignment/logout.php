<?php

  session_start();

  unset($_SESSION['name']);
  unset($_SESSION['user_id']);

  session_destroy();

  header('location: ../assignment.php');
  return;

?>