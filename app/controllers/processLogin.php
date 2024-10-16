<?php
     require_once "../config/conexao.php";
     require "../actions/funcionario.php";

     if($_SERVER["REQUEST_METHOD"]=="POST"){
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];
        $funcionario = verificarUsuario($conn, $cpf, $senha);
    
        if ($funcionario["success"] || !$funcionario["content"]){
            session_start();
            $_SESSION['funcionario'] = $funcionario["content"];
        }else{
            echo $funcionario["message"];
        }
     }

     


?>