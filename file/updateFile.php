<?php
session_start();
require_once realpath("../vendor/autoload.php");

use App\Controllers\Files as File;


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 'authorized') {
  header('Location: ../user/login.php');
} else {
  if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    $file = new File();
    if (isset($_POST['updateFile'])) {
      $result = $file->updateFile($_POST['name'], $_GET['id']);
      if ($result['data']['msg'] == 'Filename updated') {
        $id = $_SESSION['user'];
        $oldName = $_GET['name'];
        $format = $_GET['format'];
        $newName = $result['data']['name'];
        rename("uploads/$id/$oldName." . $format, "uploads/$id/$newName." . $format);
      }
    } else {
      $files = $file->getFileName($_GET['id']);
    }
  } else {
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Dashboard page for admins. Here admins can update their own files">
  <script src="//cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
  <title>Blog Dashboard</title>
  <link rel="stylesheet" href="../blog/main.css">
</head>

<body>
  <nav class="nav">
    <h1 class="nav-logo">Hello Admin</h1>
    <hr class="nav__line" />
    <ul class="nav-links">
      <a class="nav-link" href='blogs.php'>
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
      <span class="component-name">Update File</span>
      <?php
      if (isset($_POST['updateFile']) && $result['data']['msg']) {
        echo "<span class='reply'>" . $result['data']['msg'] . "</span>";
      }
      ?>
      <span class="reply">

      </span>
    </div>
    <form action="" method="POST">
      <div class="form-group">
        <label>Filename</label>

        <input value="<?php
                      if (isset($_POST['name'])) {
                        echo $result['data']['name'];
                      } else {
                        echo $files->name;
                      }
                      ?>" type="text" name="name" placeholder="Name" />
      </div>
      <div class="form-group">
        <button style="border: none; font-size: 18px;" name="updateFile" class="link-btn">Update File</button>
      </div>
    </form>
  </div>
</body>

</html>