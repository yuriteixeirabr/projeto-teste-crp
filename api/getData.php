<?php
require 'db_config.php';

$operacao = 0;
$num_rec_per_page = 5;

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
};

if (isset($_GET["op"]))
    $operacao = $_GET["op"];

if ($operacao == 1) {
    $start_from = ($page - 1) * $num_rec_per_page;

    $sqlTotal = sprintf("SELECT * FROM cliente");
    $sql = sprintf("SELECT c.id_cliente, c.nome, c.data_nascimento, c.sexo, c.situacao, e.id_estado, e.descricao FROM 
      cliente c INNER JOIN estado e ON c.id_estado = e.id_estado Order By c.id_cliente desc LIMIT %s, %s",
        $start_from, $num_rec_per_page);

    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $json[] = $row;
    }

    $data['data'] = $json;
    $result = mysqli_query($mysqli, $sqlTotal);
    $data['total'] = mysqli_num_rows($result);

    echo json_encode($data);
} else if ($operacao == 2) {
    $sql = "SELECT * FROM estado Order By descricao";

    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $json[] = $row;
    }

    $data['data'] = $json;
    echo json_encode($data);
}
?>