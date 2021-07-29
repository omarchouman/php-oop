<?php
session_start();
require_once realpath("../vendor/autoload.php");

use App\Controllers\Blogs as Blog;



if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 'authorized') {
  header('Location: ../user/login.php');
} else {
  $limit = 10;
  if (isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] > 0) {
    $page = $_GET['page'];
  } else {
    $page = 1;
  }
  $blog = new Blog();
  $result = $blog->getBlogsWithoutContent($page, $limit, $_SESSION['user']);
  $total = $blog->getTotalBlogs();
  $end = $page * $limit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Dashboard page for admins. Here admins can view their own blogs">
  <title>Blog Dashboard</title>
  <link rel="stylesheet" href="main.css">
</head>

<body>
  <nav class="nav">
    <h1 class="nav-logo">Hey Admin</h1>
    <hr class="nav__line" />
    <ul class="nav-links">
      <a class="nav-link" href='blogs.php'>
        <li class="active">Blogs</li>
      </a>

      <a class="nav-link" href='../file/files.php'>
        <li>Files</li>
      </a>

      <a class="nav-link" href='logout.php'>
        <li>Logout</li>
      </a>
    </ul>
  </nav>

  <div class="div-wrapper">
    <div class="component-div">
      <span class="component-name">Blogs</span>
    </div>
    <a class="link-btn" href='addBlog.php'>Add Blog</a>
    <a style="margin-left: 20px;" class="link-btn" href='excel.php'>Export data as excel sheet</a>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Overview</th>
          <th>Created</th>
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
            echo "<td>
            <a class='update-btn' href='updateBlog.php?id=$id'>Update</a>
            <a class='delete-btn' href='deleteBlog.php?id=$id'>Delete</a>
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