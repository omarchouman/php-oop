<?php
session_start();
require_once realpath("../vendor/autoload.php");

use App\Controllers\Users as User;

if (isset($_POST['login'])) {
  $user = new User();
  $result = $user->login();
  if ($result['success']) {
    $_SESSION['user'] = $result['id'];
    $_SESSION['logged_in'] = 'authorized';
    header('Location: ../index.php');
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Login page for admins. Here you can signin to your account to access your own dashboard">
  <title>Login Page | Admin's Dashboard Login</title>
  <link rel="stylesheet" href="register.css">
</head>

<body>
  <div class="wrapper">
    <div class="form-wrapper">
      <h1>Login</h1>
      <form action="" method="POST">
        <div class="form-group">
          <label for="email_usr">Email or Username</label>
          <span class="error">
            <?php if (isset($_POST['login'])) {
              echo $result['data']['email_usr_err'];
            }
            ?>
          </span>
          <input value="<?php
                        if (isset($_POST['email_usr'])) {
                          echo $result['data']['email_usr'];
                        }
                        ?>" type="text" id="email_usr" name="email_usr" placeholder="Email or Username">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <span class="error">
            <?php if (isset($_POST['login'])) {
              echo $result['data']['password_err'];
            }
            ?>
          </span>
          <input type="password" value="<?php
                                        if (isset($_POST['password'])) {
                                          echo $result['data']['password'];
                                        }
                                        ?>" id="password" name="password" placeholder="Password">
        </div>
        <div class="form-group">
          <button class="btn" name="login">Login</button>
        </div>
        <span class="register">No account? <a href="register.php">Register here</a></span>
      </form>
    </div>
  </div>
</body>

</html>