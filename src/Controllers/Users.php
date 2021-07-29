<?php

namespace App\Controllers;

use App\Models\User as User;

class Users
{
  public function __construct()
  {
    $this->User = new User();
  }
  public function register()
  {
   
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'email' => trim($_POST['email']),
        'username' => trim($_POST['username']),
        'password' => trim($_POST['password']),
        'email_err' => '',
        'username_err' => '',
        'password_err' => ''
      ];

      // Email Validation
      if (empty($data['email'])) {
        $data['email_err'] = 'Email is required';
      } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $data['email_err'] = "Invalid email";
      } else if ($this->User->findUserByEmail($data['email'])) {
        $data['email_err'] = 'Email is already taken';
      }

      // Username Validation
      if (empty($data['username'])) {
        $data['username_err'] = 'Username is required';
      } else {
        if ($this->User->findUserByUsername($data['username'])) {
          $data['username_err'] = 'Username is already taken';
        }
      }


      if (empty($data['password'])) {
        $data['password_err'] = 'Password is required';
      } else {
        
        $uppercase = preg_match('@[A-Z]@', $data['password']);
        $lowercase = preg_match('@[a-z]@', $data['password']);
        $number    = preg_match('@[0-9]@', $data['password']);
        $specialChars = preg_match('@[^\w]@', $data['password']);


      }

    
      if (empty($data['email_err']) && empty($data['username_err']) && empty($data['password_err'])) {

        // Password Hashing
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        
        if ($this->User->register($data)) {
          return [
            'success' => true,
            'data' => $data
          ];
        } else {
          die('Something went wrong');
        }
      } else {
        return [
          'success' => false,
          'data' => $data
        ];
      }
    }
  }

  public function login()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $data = [
        'email_usr' => trim($_POST['email_usr']),
        'password' => trim($_POST['password']),
        'email_usr_err' => '',
        'password_err' => ''
      ];

      if (empty($data['email_usr'])) {
        $data['email_usr_err'] = 'Email or username is required';
      }
      if (empty($data['password'])) {
        $data['password_err'] = 'Password is required';
      }

      if (empty($data['password_err']) && empty($data['email_usr_err'])) {
        $emailLogin = $this->User->loginEmail($data);
        $usernameLogin = $this->User->loginUsername($data);
        if ($emailLogin['success']) {
          return [
            'success' => true,
            'id' => $emailLogin['id']
          ];
        } else if ($usernameLogin['success']) {
          return [
            'success' => true,
            'id' => $usernameLogin['id']
          ];
        } else {
          $data['email_usr_err'] = 'Invalid credentials';
          return [
            'success' => false,
            'data' => $data
          ];
        }
      } else {
        return [
          'success' => false,
          'data' => $data
        ];
      }
    }
  }
}
