<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 'authorized') {
  header('Location: ../user/login.php');
} else {
  if (isset($_GET['path']) && $_GET['path'] != '') {
    $file = $_GET['path'];
    $filetype = filetype($file);
    $filename = basename($file);
    header("Content-Type: " . $filetype);
    header("Content-Length: " . filesize($file));
    header("Content-Disposition: attachment; filename=" . $filename);
    readfile($file);
  } else {
    exit();
  }
}
