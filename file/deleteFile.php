<?php
session_start();
require_once realpath("../vendor/autoload.php");

use App\Controllers\Files as File;


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 'authorized') {
  header('Location: ../user/login.php');
} else {
  if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0 && $_GET['path'] != '') {
    $file = new File();
    $result = $file->deleteFile($_GET['id']);
    unlink($_GET['path']);
    header('Location: files.php');
  } else {
    exit();
  }
}
