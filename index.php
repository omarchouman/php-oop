<?php
session_start();
require_once realpath("vendor/autoload.php");

if (!isset($_SESSION['logged_in'])) {
  header('Location: /user/login.php');
} else {
  if ($_SESSION['logged_in'] === 'authorized') {
    header('Location: blog/blogs.php');
  } else {
    header('Location: user/login.php');
  }
}
