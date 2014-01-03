<?php
require_once 'data/data.php';
require_once 'views/renderable.php';

$id = strtolower($_GET["id"]);
$stmt = DBO::getDB()->prepare("select type, data from Image where id=?");
$stmt->bind_param("i", $id);
$stmt->bind_result($type, $data);
$stmt->execute();
$stmt->fetch();
$stmt->close();
header("content-type: $type");
echo $data;