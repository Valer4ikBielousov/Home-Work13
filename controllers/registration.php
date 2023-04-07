<?php
session_start();
require __DIR__.'/../functions/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
  $_SESSION['alerts'] = 'Method not allowed!';
  header ('location: http://validation');
}

