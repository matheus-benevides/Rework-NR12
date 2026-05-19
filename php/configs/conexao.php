<?php
// Dados de conexão
$host = 'localhost';
$dbname = 'nr12';
$username = 'root';
$password = '';
date_default_timezone_set('America/Sao_Paulo');

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    error_log("Erro de conexão com nr12: " . mysqli_connect_error());
    die("Erro ao conectar ao banco de dados.");
}

// Conexão com o banco de dados do projeto Manutenção
$db_manutencao = 'manutencao_tds2026';
$conn_manutencao = mysqli_connect($host, $username, $password, $db_manutencao);

if (!$conn_manutencao) {
    error_log("Erro de conexão com manutencao_tds2026: " . mysqli_connect_error());
    die("Erro ao conectar ao banco de manutenção.");
}
