<?php
error_reporting(0);
define(DB_USER, "root");
define(DB_PASSWORD, "root");
define(DB_DATABASE, "teste_crp");
define(DB_HOST, "localhost");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
?>