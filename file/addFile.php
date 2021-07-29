<?php
session_start();
require_once realpath("../vendor/autoload.php");

use App\Controllers\Files as File;


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 'authorized') {
  header('Location: ../user/login.php');
} else {
  if (isset($_POST['addFile'])) {
    $file = new File();
    $result = $file->addFile($_SESSION['user']);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Dashboard page for admins. Here admins can add their own files">

  <title>Blog Dashboard</title>
  <link rel="stylesheet" href="../blog/main.css">
</head>

<body>
  <nav class="nav">
    <h1 class="nav-logo">Hello Admin</h1>
    <hr class="nav__line" />
    <ul class="nav-links">
      <a class="nav-link" href='../blog/blogs.php'>
        <li>Blogs</li>
      </a>

      <a class="nav-link" href='files.php'>
        <li class="active">Files</li>
      </a>

      <a class="nav-link" href='../blog/logout.php'>
        <li>Logout</li>
      </a>
    </ul>
  </nav>

  <div class="div-wrapper">
    <div class="component-div">
      <span class="component-name">Add File</span>
      <?php
      if (isset($_POST['addFile']) && $result['data']['msg']) {
        echo "<span class='reply'>" . $result['data']['msg'] . "</span>";
      }
      ?>
      <span class="reply">

      </span>
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>File name</label>
        <input type="text" name="name">
      </div>
      <input style="margin-bottom: 10px;" type="file" name="fileUpload">
      <div class="form-group">
        <button style="border: none; font-size: 18px;" name="addFile" class="link-btn">Add File</button>
      </div>
    </form>
  </div>
</body>

</html>