<?php
class User extends DBO {
  private $originalEmail;
  public $email;
  public $name;
  private $hashedPassword;
  private $roles;

  static function findAll() {
    $res = parent::findAll(get_class());

    $users;

    foreach ($res as $entry) {
      $users[] = getUser($entry);
    }
    return users;
  }

  static function find($email) {
    $stmt = parent::getDB()->prepare("select email, name, password, roles from User where email=?");
    $stmt->bind_param("s", $email);
    $stmt->bind_result($email, $name, $passwd, $roles);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
    return self::getUser($email, $name, $passwd, $roles);
  }

  private static function getUser($email, $name, $password, $roles) {
    $user = new User();
    $user->originalEmail = $email;
    $user->email = $email;
    $user->name = $name;
    $user->hashedPassword = $password;
    $user->roles = $roles;
    return $user;
  }

  function save() {
    $stmt = DBO::getDB()->prepare("insert into User values (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $this->email, $this->name, $this->hashedPassword, $this->roles);
    $stmt->execute();
    $this->originalEmail = $this->email;
  }

  function update() {
    $stmt = DBO::getDB()->prepare("update User set email=?, name=?, password=?, salt=?, roles=? where email=?");
    $stmt->bind_param("sssss", $this->email, $this->name, $this->hashedPassword, $this->roles, $this->originalEmail);
    $stmt->execute();
    if ($this->originalEmail != $this->email) {
      // at a later point, it might be necessary to update other tables if this changed.
      $this->originalEmail = $this->email;
    }
    $stmt->close();
  }

  function updatePassword($old, $new) {
    if (!isset($this->hashedPassword) || check($old)) {
      $this->hashedPassword = password_hash($new, PASSWORD_DEFAULT);
      return true;
    }
    return false;
  }

  function check($password) {
    return password_verify($password, $this->hashedPassword);
  }
}

class DBO {
  private static $mysql;

  private static function init() {
    self::$mysql =  new mysqli("localhost", "root", "");
    self::$mysql->select_db("webshop");
    self::$mysql->set_charset('utf8');
  }

  protected static function getDB() {
    if (!isset(self::$mysql)) {
      self::init();
    }
    return self::$mysql;
  }

  protected static function findAll($table){
    $stmt = self::getDB()->prepare("select * from $table");
    return $stmt->execute();
  }

  public static function createTables() {
    self::getDB()->query("CREATE TABLE User(email VARCHAR(255) NOT NULL PRIMARY KEY, name VARCHAR(255), password VARCHAR(255), roles VARCHAR(255))");
  }
}