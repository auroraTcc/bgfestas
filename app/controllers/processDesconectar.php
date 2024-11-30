<?php
    header('Content-Type: application/json');

    $response = ['success' => false];
    function desconectar() {
        if(isset($_SESSION["funcionario"])) {
            unset($_SESSION["funcionario"]);
            return true;
        }

        return false;
    }

    if (desconectar()) {
        $response['success'] = true;
    } 

    echo json_encode($response);