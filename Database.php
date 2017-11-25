<?php
  declare(strict_types=1);

  /**
  * Wrapper class for mysql db operations
  */

  class Database {
    private string $db_host;
    private string $db_user;
    private string $db_password;
    private string $database;

    public function __construct(string $db_host, string $db_user, string $db_password, string $database) {
      this->db_host = $db_host;
      this->db_user = $db_user;
      this->db_password = $db_password;
      this->database = $database;
    }

    public function connect() {
      $db = mysqli_connect(this->db_host, this->db_user, this->db_password, this->database);
      if (mysqli_connect_errno()) {
        echo "Connect failed.\n".mysqli_connect_error();
        exit();
      }
      return $db;
    }
  }
?>
