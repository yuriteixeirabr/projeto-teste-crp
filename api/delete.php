<?php
require 'db_config.php';

$id = $_POST["id"];

$sql = sprintf("DELETE FROM cliente WHERE id_cliente = %s", $id);
$result = $mysqli->query($sql);

echo json_encode([$id]);
?>