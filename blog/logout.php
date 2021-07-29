<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 'authorized') {
  header('Location: ../user/login.php');
} else {
  unset($_SESSION['logged_in']);
  unset($_SESSION['user']);
  header('Location: ../user/login.php');
}
