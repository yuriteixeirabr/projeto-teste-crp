<?php
require 'db_config.php';

$id = $_POST["id"];
$post = $_POST;

$sql = sprintf("UPDATE cliente SET id_estado = %s, nome = '%s', data_nascimento = '%s', sexo = '%s', situacao = %s WHERE 
  id_cliente = %s", $post['estado'], $post['nome'], $post['data_nascimento'], $post['sexo'], $post['situacao'], $id);

$result = $mysqli->query($sql);
$sql = sprintf("SELECT * FROM cliente WHERE id_cliente = %s", $id);
$result = $mysqli->query($sql);
$data = $result->fetch_assoc();

echo json_encode($data);
?>