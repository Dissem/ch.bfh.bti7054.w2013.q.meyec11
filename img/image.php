<?php
require_once __DIR__.'/../lib/data.php';
require_once __DIR__.'/../views/renderable.php';

$id = strtolower($_GET["id"]);
$stmt = DBO::getDB()->prepare("select type, data from Image where id=?");
$stmt->bind_param("i", $id);
$stmt->bind_result($type, $data);
$stmt->execute();
$stmt->fetch();
$stmt->close();
header("Cache-Control: public, max-age=31536000"); // I give it a year
header("content-type: $type");
echo $data;