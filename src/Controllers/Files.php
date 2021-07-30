<?php

namespace App\Controllers;

use App\Models\File as File;

class Files
{
  public function __construct()
  {
    $this->File = new File();
  }

  public function addFile($user)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $name = $_POST['name'];
      if ($name == '') {
        return [
          'data' => [
            'msg' => 'Filename is required'
          ]
        ];
      }

      $target_dir = "uploads/$user/";
      if (!file_exists($target_dir)) {
        mkdir($target_dir, 0345, true);
      }
      $format = strtolower(pathinfo($_FILES['fileUpload']["name"], PATHINFO_EXTENSION));
      $target_file = $target_dir . $_POST['name'] . ".$format";
      $size = $_FILES["fileUpload"]["size"];
      if ($size == 0) {
        return [
          'data' => [
            'msg' => 'File is required'
          ]
        ];
      }
      if ($size > 500000) {
        return [
          'data' => [
            'msg' => 'File too big'
          ]
        ];
      }
      if ($this->File->addFile($name, $size, $format, $target_dir, $user)) {
        move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file);
        return [
          'data' => [
            'msg' => 'File uploaded'
          ]
        ];
      } else {
        return [
          'data' => [
            'msg' => 'File name already exists'
          ]
        ];
      }
    }
  }

  public function getAllFiles($page, $limit, $id)
  {
    $start = ($page - 1) * $limit;

    return $this->File->getAllFiles($start, $limit, $id);
  }

  public function getFileName($id)
  {
    return $this->File->getFileName($id);
  }

  public function updateFile($name, $id)
  {
    if (empty($name)) {
      return [
        'data' => [
          'msg' => 'Filename is required'
        ]
      ];
    }
    if ($this->File->updateFile($name, $id)) {
      return [
        'data' => [
          'name' => $name,
          'msg' => 'Filename updated'
        ]
      ];
    } else {
      return [
        'data' => [
          'msg' => 'Filename exists'
        ]
      ];
    }
  }

  public function getTotalFiles()
  {
    return $this->File->countFiles();
  }

  public function deleteFile($file)
  {
    return $this->File->deletefile($file);
  }
}
