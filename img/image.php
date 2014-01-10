<?php
require_once __DIR__.'/../lib/data.php';
include __DIR__.'/../config.php';

$engine = 'mysql';
$database = 'webshop';

$dns = $engine.':dbname='.$database.';host='.$mysql_server;
$db = new PDO( $dns, $mysql_user, $mysql_password );

$id = strtolower($_GET["id"]);

$stmt = $db->prepare("select type, data from Image where id=?");
$stmt->execute(array($id));
$stmt->bindColumn(1, $type, PDO::PARAM_STR, 256);
$stmt->bindColumn(2, $data, PDO::PARAM_LOB);
$stmt->fetchAll(PDO::FETCH_BOUND);

header("Cache-Control: public, max-age=31536000"); // I give it a year
header("Content-Type: $type");
echo($data);