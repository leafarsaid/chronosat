<?
//
set_time_limit(0);

//
header("Content-type: text/html; charset=iso-8859-1",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

ini_set("simplexml_load_file", 1);
ini_set("user_agent","Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
ini_set("max_execution_time", 0);
ini_set("allow_url_fopen", 1);
ini_set("memory_limit", "10000M");

//
require_once "util/gerador_linhas.php";
require_once "util/sql.php";
require_once "util/especiais.php";

// obtendo parametros da querystring
$int_id_ss=(int)$_REQUEST["trecho"];
$int_id_cat=(int)$_REQUEST["categoria"];

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// populando a lista de valores
$lista = array();
$xml_src = "http://".$_SERVER[HTTP_HOST]."/chronosat/geralXML.php?".$_SERVER['QUERY_STRING'];
$xml = simplexml_load_file($xml_src);
$lista_array = array();

for ($i = 0; $i < count($xml); $i++) {
	foreach($xml->veiculo[$i]->attributes() as $key => $value) {
		$lista_array[$i][$key] = (string)$value;
	}
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// Tabelão de dados a serem exibidos
$i = 0;
foreach ($lista_array as $v) {
	$lista[$i] = array();
	
    array_push($lista[$i], "<b>".$v['colocacao']."</b>");
	$str_numeral = $v['numeral'];
    array_push($lista[$i], $str_numeral);

	$piloto = nomeComp($v['piloto']);
	$navegador = nomeComp($v['navegador']);
	$tripulacao = '<div class="trip" id="div">';

	if (strlen($piloto) > 0) $tripulacao .= "<b>".$piloto."</b><br>";
	if (strlen($navegador) > 0) $tripulacao .= "<b>".$navegador."</b><br>";
	if (strlen($v['modelo']) > 0) $tripulacao .= $v['modelo']."<br>";
	$tripulacao .= '</div>';
	array_push($lista[$i], $tripulacao);
	
	//array_push($lista[$i], '<div class="trip" id="div">'.$v['equipe'].'</div>');
	
	if (!isset($_REQUEST["categoria"])) array_push($lista[$i], $v['categoria']);
	
	foreach ($arr_ss as $x) array_push($lista[$i],substr($v['ss'.$x],3,10));
		
	$str_tempo = '<b>'.substr($v['tempo'],1,10)."</b>";
	$str_tempo .='<div style="color:red"><br>'.substr($v['penalidade'],0,8)."</div>";
	array_push($lista[$i], $str_tempo );
	
	$str_tempo_total = '<div style="font-size:14px"><b>'.substr($v['total'],1,10)."</b></div>";
	$str_tempo_total .='<br>'.substr($v['diferenca_lider'],3,10)."</div>";
	array_push($lista[$i], $str_tempo_total);
	$i++;
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// Definindo o que vai no header da página
if (isset($trecho_final)) $numero_trecho = $trecho_final;
else if ($int_id_ss) $numero_trecho = $int_id_ss;

$tre = criaArray ("SELECT * FROM t02_trecho WHERE c02_codigo=".$numero_trecho);
$dist_esp_tot = $tre[0]["c02_distancia"] + $tre[0]["c02_desl_ini"] + $tre[0]["c02_desl_fin"];

$trecho_txt1 = ($_REQUEST["trechos"]) ? "RESULTADOS ACUMULADOS ": "ACUMULADO AT&Eacute; A ESPECIAL: SS ".$numero_trecho."   -   ".$tre[0]["c02_nome"]." (".$dist_esp_tot."km)";

$txt_especifico = date("d/m/Y  -  H:i:s");
$txt_especifico .= (($_REQUEST["oficial"] == 1)) ? "<br>Resultados Oficiais" : "<br>Resultados Extra-Oficiais";

if ($_REQUEST["categoria"]) {
	$cat = criaArray ("SELECT * FROM t13_categoria WHERE c13_codigo=".$_REQUEST["categoria"]);
	$txt_especifico .= "<br><font size='4'><b>Categoria: ".$cat[0]["c13_descricao"]."</b></font>";
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// campos do cabecalho da tabela

$campos_header_ss = array();

array_push($campos_header_ss,"POS");
array_push($campos_header_ss,"NO");
array_push($campos_header_ss,'<div class="trip" id="div">PILOTO/NAVEGADOR</div>');
//array_push($campos_header_ss,'<div class="trip" id="div">EQUIPE</div>');
if (!isset($_REQUEST["categoria"])) array_push($campos_header_ss,"(POS)CAT");

foreach ($arr_ss as $x) array_push($campos_header_ss,($x == "0") ? "QS" : "SS".$x);

array_push($campos_header_ss,'Tempo<div style="font-size:10px;color:red"><br>Penal</div>');
array_push($campos_header_ss,'TOTAL<div style="font-size:10px"><br>Dif. Lider</div>');

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="css/relatorio_print.css" rel="stylesheet" type="text/css" />
		<title></title>
	</head>

	<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#000000">
		<? echo printHeader($numero_trecho, $trecho_txt1, $txt_especifico); ?>
		<table border="0" cellpadding="0" cellspacing="0" bgcolor="#000000" align="center" width="100%">
			<tr>
				<td height="60" colspan="0" valign="top">
					<!-- ////////////////////////////////////////////////////////////////////////////// //-->
					<table cellpadding="2" cellspacing="0" class="tb1">
					<?
						echo printTableHeader($campos_header_ss);
						echo geraLinhaHtml ($lista);
					?>
					</table>
				</td>
			</tr>
		</table>
		<? echo geraFooter(); ?>
	</body>
</html>