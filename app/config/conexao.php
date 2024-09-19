<?
function getMysqlConnParamenters( $serverType ){
	
    $_MysqlConnParamenters["homologacao"]["host"] 	    = "localhost";
    $_MysqlConnParamenters["homologacao"]["user"] 	    = "hostdeprojetos";
    $_MysqlConnParamenters["homologacao"]["pass"] 	    = "ifspgru@2022";	
    $_MysqlConnParamenters["homologacao"]["schema"] 	= "hostdeprojetos_bgfestas";


    $_MysqlConnParamenters["deploy"]["host"] 	= "localhost";
    $_MysqlConnParamenters["deploy"]["user"] 	= "ifhostgru";
    $_MysqlConnParamenters["deploy"]["pass"] 	= "ifspgru@2024";	
    $_MysqlConnParamenters["deploy"]["schema"] 	= "ifhostgru_bgfestas";


    $_MysqlConnParamenters["local"]["host"] 	= "localhost";
    $_MysqlConnParamenters["local"]["user"] 	= "root";
    $_MysqlConnParamenters["local"]["pass"] 	= "";	
    $_MysqlConnParamenters["local"]["schema"] 	= "bgfestas";

    
    if( $serverType  === "deploy"){
        return $_MysqlConnParamenters["deploy"];
    }else if($serverType === "homologacao"){
        return $_MysqlConnParamenters["homologacao"];
    } else {
        return $_MysqlConnParamenters["local"];
    }

}

$mysql_parameter = getMysqlConnParamenters( "deploy" );

$conn = new mysqli(
    $mysql_parameter["host"],
    $mysql_parameter["user"],
    $mysql_parameter["pass"],
    $mysql_parameter["schema"]
);

if (!$conn){
    die("conexão falhou".mysqli_connect_error());
};

