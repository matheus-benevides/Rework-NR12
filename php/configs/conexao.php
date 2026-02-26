<?php
// Dados de conexão
$host = 'localhost';
$dbname = 'nr12';
$username = 'root';
$password = '';
$port = '3306';
date_default_timezone_set('America/Sao_Paulo');

$conn = mysqli_connect($host,$username,$password,$dbname,$port);

if(!$conn){
    die("falhou a conexão ae KKKKKKKKJ, arruma isso " . mysqli_connect_error());
}

?>