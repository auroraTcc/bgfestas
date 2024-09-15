<?php
$servername = "localhost";
$username = "hostdeprojetos_bgfestas";
$password = "ifspgru@2022";
$databasename = "hostdeprojetos_bgfestas";

//criação da conexão
$conn = new mysqli($servername, $username, $password, $databasename);

// verificando a conexão
if (!$conn){
    //die("conexão falhou".mysqli_connect_error());
    echo "não foi possível conectar ao banco de dados";
};