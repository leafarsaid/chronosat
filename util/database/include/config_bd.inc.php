<?php
# ------------------------------------------------

// BANCO DE DADOS
define("DB_DRIVER", "mysql");

$sUserBanco = "";
$sServer = "";

if ($_REQUEST["db"] == 2) {
	$sUserBanco = "chronosat2";
	$sServer = "mysql03.chronosat.com.br";
} elseif ($_REQUEST["db"] == 3){
	$sUserBanco = "chronosat3";
	$sServer = "mysql04.chronosat.com.br";
} else {
	$sUserBanco = "chronosat1";
	$sServer = "mysql02.chronosat.com.br";
}

if($_SERVER[HTTP_HOST]=="www.chronosat.com.br" || $_SERVER[HTTP_HOST]=="www.chronosat.com") {
    define("DB_HOST", $sServer);
    define("DB_USER", $sUserBanco);
    define("DB_PASS", "chrono2002");
    define("DB_BANCO", $sUserBanco);
} else {
   define("DB_HOST", "localhost");
   define("DB_USER", "root");
   define("DB_PASS", "");
   define("DB_BANCO", $sUserBanco);
}

define("DB_DML", "^(INSERT|UPDATE|DELETE)"); // comandos DML permitidos
define("DB_QUERY", "^(\(?SELECT|CALL|SHOW)"); // queries permitidas
define("DB_UNBUFFERED", true); // suporta resultsets "unbuffereds"?
define("DB_PAG_LIMITE", 10); // resultados por pсgina (paginaчуo de resultados)

# ------------------------------------------------

?>