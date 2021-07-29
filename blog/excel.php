<?php
session_start();
require_once realpath("../vendor/autoload.php");

use App\Controllers\Blogs as Blog;

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 'authorized') {
  header('Location: ../user/login.php');
} else {
  $blog = new Blog();
  $result = $blog->getAllBlogs();
  function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }
  $filename = "excel_data" . date('Ymd') . ".xls";

  header('Content-Type: application/vnd.ms-excel');
  header("Content-Disposition: attachment; filename=\"$filename\"");

  $headers = array();
  $values = array();
  $printHeaders = $false;
  foreach ($result as $row) {
    if (!$printHeaders) {
      foreach ($row as $key => $value) {
        echo $key . "\t";
      }
      echo "\n";
      $printHeaders = true;
    }
    foreach ($row as $key => $value) {
      cleanData($value);
      echo $value . "\t";
    }
    echo "\n";
  }
  exit();
}
