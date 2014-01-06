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
    $stmt->close();
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
    mysqli_report(MYSQLI_REPORT_ERROR);

    include __DIR__.'/../config.php';
    self::$mysql =  new mysqli($mysql_server, $mysql_user, $mysql_password);
    self::$mysql->select_db("webshop");
    self::$mysql->set_charset('utf8');
  }

  public static function getDB() {
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
    self::getDB()->multi_query("
    CREATE TABLE IF NOT EXISTS User (
        email VARCHAR(255) NOT NULL PRIMARY KEY,
        name VARCHAR(255),
        password VARCHAR(255),
        roles VARCHAR(255)
    );
    CREATE TABLE IF NOT EXISTS Image (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        type VARCHAR(31),
        data LONGBLOB
    );
    CREATE TABLE IF NOT EXISTS Product (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        price DECIMAL(10,8) NOT NULL,
        imageId INT,
        FOREIGN KEY (imageId) REFERENCES Image(id)
    );
    CREATE TABLE IF NOT EXISTS ProductTexts (
        id INT NOT NULL,
        lang CHAR(2) NOT NULL,
        name VARCHAR(255) NOT NULL,
        summary VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        PRIMARY KEY (id, lang),
        FOREIGN KEY (id) REFERENCES Product(id),
        INDEX id
    );
    CREATE TABLE IF NOT EXISTS Item (
    	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    	user VARCHAR(255) NOT NULL,
        productId INT NOT NULL,
        artist VARCHAR(255) NOT NULL,
        invoiceId INT,
        paid BOOLEAN NOT NULL
    );
    CREATE TABLE IF NOT EXISTS Invoice (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        user VARCHAR(255) NOT NULL,
        amount DECIMAL(10,8) NOT NULL,
        btcAddress VARCHAR(255),
        confirmations INT NOT NULL DEFAULT 0
    );
    ");
    while (self::getDB()->next_result());
  }
}