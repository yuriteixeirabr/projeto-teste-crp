<?php

require 'db_config.php';

$post = $_POST;

$sql = sprintf("INSERT INTO cliente() VALUES(null, %s, '%s', '%s', '%s', %s)", $post['estado'], $post['nome'],
    $post['data_nascimento'], $post['sexo'], $post['situacao']);

$result = $mysqli->query($sql);
$sql = "SELECT * FROM cliente Order by id_cliente desc LIMIT 1";
$result = $mysqli->query($sql);
$data = $result->fetch_assoc();

echo json_encode($data);
?>