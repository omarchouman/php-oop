<?php

namespace App\Models;

use App\Database\Database as DB;

class User
{
  private $db;

  public function __construct()
  {
    $this->db = new DB();
  }

  // register user
  public function register($data)
  {
    $this->db->query('INSERT INTO user (email, username, password) VALUES(:email, :username, :password)');

    $this->db->bind(':email', $data['email']);
    $this->db->bind(':username', $data['username']);
    $this->db->bind(':password', $data['password']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // login user by email
  public function loginEmail($data)
  {
    $this->db->query('SELECT * FROM user WHERE email = :email');

    $this->db->bind(':email', $data['email_usr']);

    $row = $this->db->single();
    if (!$row) return false;
    $hashed_password = $row->password;

    if (password_verify($data['password'], $hashed_password)) {
      return [
        'success' => true,
        'id' => $row->id
      ];
    } else {
      return [
        'success' => false
      ];
    }
  }

  // login user by username
  public function loginUsername($data)
  {
    $this->db->query('SELECT * FROM user WHERE username = :username');

    $this->db->bind(':username', $data['email_usr']);

    $row = $this->db->single();
    if (!$row) return false;
    $hashed_password = $row->password;

    if (password_verify($data['password'], $hashed_password)) {
      return [
        'success' => true,
        'id' => $row->id
      ];
    } else {
      return [
        'success' => false
      ];
    }
  }




  // Find user by email
  public function findUserByEmail($email)
  {
    $this->db->query('SELECT * FROM user WHERE email = :email');
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    if ($this->db->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  // Find user by username
  public function findUserByUsername($username)
  {
    $this->db->query('SELECT * FROM user WHERE username = :username');
    $this->db->bind(':username', $username);

    $row = $this->db->single();

    if ($this->db->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
}
