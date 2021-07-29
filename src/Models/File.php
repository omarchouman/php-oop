<?php

namespace App\Models;

use App\Database\Database as DB;

class File
{
  private $db;

  public function __construct()
  {
    $this->db = new DB();
  }

  public function addFile($name, $size, $format, $path, $id)
  {
    $this->db->query('INSERT INTO file (name, size, format, path, user_id) VALUES(:name, :size, :format, :path, :user_id)');

    $this->db->bind(':name', $name);
    $this->db->bind(':size', $size);
    $this->db->bind(':format', $format);
    $this->db->bind(':path', $path);
    $this->db->bind(':user_id', $id);
    try {
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    } catch (\Throwable $th) {
      return false;
    }
  }

  public function getAllFiles($start, $limit, $id)
  {
    $this->db->query('SELECT id, name, size, format, path FROM file WHERE user_id = :id LIMIT :start, :limit');
    $this->db->bind(':id', $id);
    $this->db->bind(':start', $start);
    $this->db->bind(':limit', $limit);
    $row = $this->db->resultSet();
    return $row;
  }

  public function getFileName($id)
  {
    $this->db->query('SELECT name FROM file WHERE id = :id');
    $this->db->bind(':id', $id);
    $row = $this->db->single();
    return $row;
  }

  public function updateFile($name, $id)
  {
    $this->db->query('UPDATE file SET name=:name WHERE id=:file_id');
    $this->db->bind(':name', $name);
    $this->db->bind(':file_id', $id);

    try {
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    } catch (\Throwable $th) {
      return false;
    }
  }

  public function countFiles()
  {
    $this->db->query('SELECT COUNT(id) AS total FROM file');
    $row = $this->db->single();
    return $row;
  }

  public function deleteFile($id)
  {
    $this->db->query('DELETE FROM file WHERE id=:file_id');
    $this->db->bind(':file_id', $id);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
