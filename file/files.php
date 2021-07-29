<?php
session_start();
require_once realpath("../vendor/autoload.php");

use App\Controllers\Files as File;

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 'authorized') {
  header('Location: ../user/login.php');
} else {
  $limit = 10;
  if (isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] > 0) {
    $page = $_GET['page'];
  } else {
    $page = 1;
  }
  $file = new File();
  $result = $file->getAllFiles($page, $limit, $_SESSION['user']);
  $total = $file->getTotalFiles();
  $end = $page * $limit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Dashboard page for admins. Here admins can view their own files">
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
      <span class="component-name">Files</span>
    </div>
    <a class="link-btn" href='addFile.php'>Add File</a>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>name</th>
          <th>size</th>
          <th>format</th>
          <th>path</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (sizeof($result) > 0) {
          for ($i = 0; $i < sizeof($result); $i++) {
            echo "<tr>";
            foreach ($result[$i] as $key => $value) {
              echo "<td>$value</td>";
            }
            $id = $result[$i]->id;
            $fullPath = $result[$i]->path . $result[$i]->name . "." . $result[$i]->format;
            $name = $result[$i]->name;
            $format = $result[$i]->format;
            echo "<td>
            <a class='update-btn' href='updateFile.php?id=$id&name=$name&format=$format'>Update</a>
            <a class='delete-btn' href='deleteFile.php?id=$id&path=$fullPath'>Delete</a>
            <a class='update-btn' href='downloadFile.php?path=$fullPath'>Download</a>
            </td>";
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
    <div class="paginated-div">
      <ul class="paginated-list">
        <a href="?page=<?php
                        if ($page == 1) {
                          echo 1;
                        } else {
                          echo $page - 1;
                        }
                        ?>">
          <li>prev</li>
        </a>
        <a href="?page=<?php
                        if ($total->total - $end < 0) {
                          echo $page;
                        } else {
                          echo $page + 1;
                        }
                        ?>">
          <li>next</li>
        </a>
      </ul>
    </div>
  </div>
</body>


</html>