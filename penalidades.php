<?
//
set_time_limit(0);
header("Content-type: text/html; charset=utf-8",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

require_once"util/gerador_linhas.php";
require_once"util/sql.php";
require_once"util/especiais.php";

//sqls
$penais_sql = geraSqlPenal($_REQUEST["trecho"], $_REQUEST["categoria"], $int_id_mod);
$arr_penais = criaArray ($penais_sql);
$lista = geraDados ($arr_penais);

function geraDados ($arr_comp) {
	$arr_retorno = array();

	for ($i = 0; $i < count($arr_comp); $i++) {
		
		$arr_retorno[$i] = array();
		//
		array_push($arr_retorno[$i],$arr_comp[$i]["c03_numero"]);

		$piloto = nomeComp($arr_comp[$i]['piloto']);
		$navegador = nomeComp($arr_comp[$i]['navegador']);
		$tripulacao = '<div class="trip" id="div">';
		if (strlen($piloto) > 0) $tripulacao .= "<b>".$piloto."</b><br>";
		if (strlen($navegador) > 0) $tripulacao .= "<b>".$navegador."</b><br>";
		if (strlen($arr_comp[$i]['modelo']) > 0) $tripulacao .= $arr_comp[$i]['modelo']."<br>";
		$tripulacao .= '</div>';
		array_push($arr_retorno[$i],$tripulacao);
		
		//
		/*
		if ($arr_comp[$i]["c01_tipo"]=="P") $tipo="Manual";
		if ($arr_comp[$i]["c01_tipo"]=="PT") $tipo="GPS";
		array_push($arr_retorno[$i], $tipo);
		*/

		//Especial
		array_push($arr_retorno[$i],"SS".$arr_comp[$i]["trecho"]);

		//tempo de penal
		array_push($arr_retorno[$i],substr($arr_comp[$i]["P"],0,8));

		//motivo
		array_push($arr_retorno[$i],'<div class="trip" id="div">'.$arr_comp[$i]["motivo"].'</div>');
	}
	return $arr_retorno;
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// Definindo o que vai no header da página
$tre = criaArray ("SELECT * FROM t02_trecho WHERE c02_codigo=".$trecho_final);
$dist_esp_tot = $tre[0]["c02_distancia"] + $tre[0]["c02_desl_ini"] + $tre[0]["c02_desl_fin"];

$trecho_txt1 = "RELATORIO DE PENALIDADES - ";
if (!$_REQUEST["trecho"]) $trecho_txt1 .= "AT&Eacute; A";
$trecho_txt1 .= " ESPECIAL: SS ".$trecho_final."   -   ".$tre[0]["c02_nome"]." (".$dist_esp_tot."km)";

$txt_especifico = date("d/m/Y  -  H:i:s");
$txt_especifico .= (($_REQUEST["oficial"] == 1)) ? "<br>Resultados Oficiais" : "<br>Resultados Extra-Oficiais";

if ($_REQUEST["categoria"]) {
	$cat = criaArray ("SELECT * FROM t13_categoria WHERE c13_codigo=".$_REQUEST["categoria"]);
	$txt_especifico .= "<br><font size='4'><b>Categoria: ".$cat[0]["c13_descricao"]."</b></font>";
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// Definindo cabeçalho da tabela
$campos_header_ss = array();

array_push($campos_header_ss,"NO");
array_push($campos_header_ss,'<div class="trip" id="div">PILOTO/NAVEGADOR</div>');
array_push($campos_header_ss,"SS");
array_push($campos_header_ss,"PENAL");
array_push($campos_header_ss,'<div class="trip" id="div">MOTIVO</div>');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="css/relatorio_print.css" rel="stylesheet" type="text/css" />
		<title></title>
	</head>
	
	<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#000000">
		<? echo printHeader($trecho_final, $trecho_txt1, $txt_especifico); ?>
		<table border="0" cellpadding="0" cellspacing="0" bgcolor="#000000" align="center" width="100%">
			<tr>
				<td height="60" colspan="2" valign="top">
				<!-- ////////////////////////////////////////////////////////////////////////////// //-->
					<table cellpadding="5" cellspacing="0" class="tb1">
						<?
							echo printTableHeader($campos_header_ss);
							echo geraLinhaHtml2($lista);
						?>
					</table> 
				</td>
			</tr>
		</table>
		<? echo geraFooter(); ?>
	</body>
</html>