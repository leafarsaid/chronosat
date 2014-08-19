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
$int_id_cat=(int)$_REQUEST["categoria"];
///

$arr_classif = criaArray(geraSqlGeral($trecho_final, $arr_ss, $int_id_cat, $int_id_mod, $mod, 1, 0, 0));
$arr_nao_classif = criaArray(geraSqlGeral($trecho_final, $arr_ss, $int_id_cat, $int_id_mod, $mod, 0, 0, 0));
$arr_nc = criaArray(geraSqlGeral($trecho_final, $arr_ss, $int_id_cat, $int_id_mod, $mod, 1, 1, 0));
$arr_nc2 = criaArray(geraSqlGeral($trecho_final, $arr_ss, $int_id_cat, $int_id_mod, $mod, 0, 1, 0));
$arr_desclassif = criaArray(geraSqlGeral($trecho_final, $arr_ss, $int_id_cat, $int_id_mod, $mod, 1, 0, 1));
$array_todos = concat($arr_classif, $arr_nao_classif, $arr_nc, $arr_nc2, $arr_desclassif);

$lista = geraDados($array_todos);

printf("<?xml version=\"1.0\" encoding=\"utf-8\"?>\n\r");
$texto = sprintf("<geral>\n\r");

// campos do cabecalho
$campos_header_ss = array();
array_push($campos_header_ss,"colocacao");
array_push($campos_header_ss,"numeral");
array_push($campos_header_ss,"piloto");
array_push($campos_header_ss,"origem_piloto");
array_push($campos_header_ss,"navegador");
array_push($campos_header_ss,"origem_navegador");
array_push($campos_header_ss,"navegador2");
array_push($campos_header_ss,"origem_navegador2");
array_push($campos_header_ss,"modelo");
array_push($campos_header_ss,"equipe");
array_push($campos_header_ss,"modalidade");
array_push($campos_header_ss,"categoria");

foreach ($arr_ss as $x) array_push($campos_header_ss,"ss".$x);

array_push($campos_header_ss,"tempo");
array_push($campos_header_ss,"penalidade");
array_push($campos_header_ss,"bonus");
array_push($campos_header_ss,"total");
array_push($campos_header_ss,"diferenca_anterior");
array_push($campos_header_ss,"diferenca_lider");

$texto .= geraLinhaXml ("veiculo", $lista, $campos_header_ss);
$texto .= sprintf("</geral>\n\r");
$texto = str_replace("\" \"","\"\"",$texto);
$texto = str_replace(" \"","\"",$texto);

echo $texto;
?>