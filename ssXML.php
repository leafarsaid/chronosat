<?
header("Content-type: text/xml; charset=utf-8",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

require_once"util/gerador_linhas.php";
require_once"util/sql.php";
require_once"util/especiais.php";
require_once"util/geraDados.php";

//
$int_id_ss=(int)$_REQUEST["trecho"]; 
$int_id_cat= ($_REQUEST["subcategoria"]) ? (int)$_REQUEST["subcategoria"] : (int)$_REQUEST["categoria"];
$int_id_mod=(int)$_REQUEST["modalidade"];
$mod = $_REQUEST["mod"];
$strFIM = ($_REQUEST["db"] == 2) ? $_REQUEST["campeonato"] : "";
///

$array_ss = criaArray(geraSqlSS2($int_id_ss, $int_id_cat, $int_id_mod, $mod, $strFIM));
$lista = geraDadosSS($array_ss, $_REQUEST["fim"]);

printf("<?xml version=\"1.0\" encoding=\"utf-8\"?>\n\r");
$texto = sprintf("<especial dia=\"%s\">\n\r",$int_id_ss);

// campos do cabecalho
$campos_header_ss = array();
array_push($campos_header_ss,"pos");
array_push($campos_header_ss,"numeral");
array_push($campos_header_ss,"tripulacao");
array_push($campos_header_ss,"modelo");
array_push($campos_header_ss,"licenca");
array_push($campos_header_ss,"equipe");
array_push($campos_header_ss,"categoria");
array_push($campos_header_ss,"L");
array_push($campos_header_ss,"C");
array_push($campos_header_ss,"tempo");
array_push($campos_header_ss,"penalidade");
array_push($campos_header_ss,"bonus");
array_push($campos_header_ss,"total");
array_push($campos_header_ss,"diferenca_lider");
array_push($campos_header_ss,"diferenca_lider_bruto");

$texto .= geraLinhaXml ("veiculo", $lista, $campos_header_ss);
$texto .= sprintf("</especial>\n\r");
$texto = str_replace("\" \"","\"\"",$texto);
$texto = str_replace(" \"","\"",$texto);

echo $texto;
?>

