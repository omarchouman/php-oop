<?php
session_start();
require_once realpath("../vendor/autoload.php");

use App\Controllers\Blogs as Blog;


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 'authorized') {
  header('Location: ../user/login.php');
} else {
  if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    $blog = new Blog();
    $result = $blog->deleteBlog($_GET['id']);
    header('Location: blogs.php');
  } else {
    exit();
  }
}
