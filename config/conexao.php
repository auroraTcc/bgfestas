<?php
class Conexao {
    public static $instance;

    private function __construct() {
        //
    }

    public static function getConexao() {
        if (!isset(self::$instance)) {
            $dsn = "mysql:host=localhost;dbname=hostdeprojetos_bgfestas";
            $usuario = "hostdeprojetos_bgfestas";
            $senha = "ifspgru@2022";

            try {
                self::$instance = new PDO($dsn, $usuario, $senha, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            } catch (PDOException $e) {
                echo "Erro na conexão: " . $e->getMessage();
            }
        }

        return self::$instance;
    }
}
