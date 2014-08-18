<?

//
set_time_limit(0);
//
header("Content-type: text/html; charset=ISO-8859-1",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

require_once"util/gerador_linhas.php";
require_once"util/sql.php";
require_once"util/especiais.php";

//
$int_id_ss=(int)$_REQUEST["trecho"];
$int_id_cat=(int)$_REQUEST["categoria"];

$ss_sql = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 0, 1, '');
$ss_sql2 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 0, 0, 0, 1, '');
$ss_sql3 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 1, 0, 1, '');
$ss_sql4 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 1, 1, '');
$ss_sql5 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 0, 0, '');
$ss_sql6 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 0, 0, 0, 0, '');
$ss_sql7 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 1, 0, 0, '');
$ss_sql8 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 1, 0, '');

$arr_1 = criaArray ($ss_sql);
$arr_2 = criaArray ($ss_sql2);
$arr_3 = criaArray ($ss_sql3);
$arr_4 = criaArray ($ss_sql4);
$arr_5 = criaArray ($ss_sql5);
$arr_6 = criaArray ($ss_sql6);
$arr_7 = criaArray ($ss_sql7);
$arr_8 = criaArray ($ss_sql8);
$array_todos_ss = concat ($arr_1, $arr_2, $arr_3, $arr_4, $arr_5, $arr_6, $arr_7, $arr_8);
$lista_ss = geraDados ($array_todos_ss);

$pos_cat = array(array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1));
function geraDados ($arr_comp) {
	$retorno = '';
	$arr_retorno = array();
	
	global $pos_cat;
	global $int_id_ss;
	$col_stat = "c03_status";

	for ($i = 0; $i < count($arr_comp);$i++) {
		$arr_retorno[$i] = array();
		$cat_num = $arr_comp[$i]["c13_codigo"];

		/////////////////////////////
		$stat = $arr_comp[$i][$col_stat];
		//
		if ($arr_comp[$i]["total_geral"]!="* * *") { 
			$txt_pos = ( $i+1 );
		}
		else {
			$txt_pos = "NC";
		}
		if ($stat=="NC") $txt_pos = "NC";
		if ($stat=="D") $txt_pos = "D";
		array_push($arr_retorno[$i],'<b>'.$txt_pos.'</b>');
		////////////////////////////

		//
		array_push($arr_retorno[$i],$arr_comp[$i]["c03_numero"]);

		// TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE
		$piloto = nomeComp($arr_comp[$i]["piloto"]);
		$navegador = nomeComp($arr_comp[$i]["navegador"]);
		$modelo = $arr_comp[$i]["modelo"];
		$tripulacao = '<div class="trip" id="div">';
		if (strlen($piloto) > 0) $tripulacao .= "<b>".$piloto."</b>";
		if (strlen($navegador) > 0)  $tripulacao .= "<br><b>".$navegador."</b>";
		if (strlen($modelo) > 0)  $tripulacao .= "<br>".$modelo;
		$tripulacao .= '</div>';
		array_push($arr_retorno[$i],$tripulacao);
		// TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE
	
		//
		if ($stat == "N") {
			if ($arr_comp[$i]["total_geral"]!="* * *") $txt_pos = $pos_cat[$cat_num][0]+1;
			else $txt_pos = 'NC';			
			$pos_cat[$cat_num][0] ++;		
			if (!isset($_REQUEST["categoria"])) array_push($arr_retorno[$i],"(".$txt_pos.")".$arr_comp[$i]["categoria"]);

			//
			$str_tempo = '<b>'.substr($arr_comp[$i]["total"],3,8).'</b>';
			$str_tempo .='<div style="color:blue"><br>'.substr($arr_comp[$i]['dif1'],4,8)."</div>";
			array_push($arr_retorno[$i],$str_tempo);		
		}
		else {
			if (!isset($_REQUEST["categoria"])) array_push($arr_retorno[$i],"* * *");	
			array_push($arr_retorno[$i],"* * *");
		}
	}
	return $arr_retorno;
}

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
$geral_sql = geraSqlGeral($int_id_ss, $arr_ss, $int_id_cat, $int_id_mod, $mod, 1,0,0);
$geral_sql2 = geraSqlGeral($int_id_ss, $arr_ss, $int_id_cat, $int_id_mod, $mod, 0,0,0);
$geral_sql3 = geraSqlGeral($int_id_ss, $arr_ss, $int_id_cat, $int_id_mod, $mod, 1,1,0);
$geral_sql4 = geraSqlGeral($int_id_ss, $arr_ss, $int_id_cat, $int_id_mod, $mod, 1,0,1);
$arr_classif_geral = criaArray ($geral_sql);
$arr_nao_classif_geral = criaArray ($geral_sql2);
$arr_nc_geral = criaArray ($geral_sql3);
$arr_desclassif_geral = criaArray ($geral_sql4);
$array_todos_geral = concat ($arr_classif_geral,$arr_nao_classif_geral,$arr_nc_geral,$arr_desclassif_geral);
$lista_geral = geraDadosGeral ($array_todos_geral);
$pos_cat2 = array(array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1));

function geraDadosGeral ($arr_comp) {
	$retorno = '';
	$arr_retorno = array();
		
	global $pos_cat2;	
	global $int_id_ss;
	$col_stat = "c03_status";

	for ($i=0;$i<count($arr_comp);$i++) {
		$arr_retorno[$i] = array();

		$cat_num = $arr_comp[$i]["c13_codigo"];

		/////////////////////////////
		$stat = $arr_comp[$i][$col_stat];
		//
		if ($arr_comp[$i]["total_geral"]!="* * *") { 
			$txt_pos = ( $i+1 );
		}
		else {
			$txt_pos = "NC";
		}
		if ($stat=="NC") $txt_pos = "NC";
		if ($stat=="D") $txt_pos = "D";
		array_push($arr_retorno[$i],'<b>'.$txt_pos.'</b>');
		////////////////////////////

		//
		array_push($arr_retorno[$i],'<b>'.$arr_comp[$i]["c03_numero"].'</b>');

		// TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE
		$piloto = nomeComp($arr_comp[$i]["piloto_geral"]);
		$navegador = nomeComp($arr_comp[$i]["navegador_geral"]);
		$modelo = $arr_comp[$i]["modelo_geral"];
		$tripulacao = '<div class="trip" id="div">';
		if (strlen($piloto) > 0) $tripulacao .= "<b>".$piloto."</b>";
		if (strlen($navegador) > 0) $tripulacao .= "<br><b>".$navegador."</b>";
		if (strlen($modelo) > 0)  $tripulacao .= "<br>".$modelo;
		$tripulacao .= '</div>';
		array_push($arr_retorno[$i],$tripulacao);
		// TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE
			
		// se não é desclassificado
		if ($arr_comp[$i]["c03_status"] != 'D') {
			//
			if ($arr_comp[$i]["total_geral"] != "* * *") $txt_pos = $pos_cat2[$cat_num][0] + 1;
			else $txt_pos = "NC";
			$pos_cat2[$cat_num][0]++;		
			
			if (!isset($_REQUEST["categoria"])) array_push($arr_retorno[$i],"(".$txt_pos.")".$arr_comp[$i]["categoria"]);	
			
			//
			$status = $arr_comp[$i]["c03_status"];	
			
			if ($txt_pos == "NC") {
				array_push($arr_retorno[$i],'* * *<div style="color:red"><br>* * *</div>');
				array_push($arr_retorno[$i],'<b>* * *</b><div style="color:blue"><br>* * *</div>');
			}
			else {
				$str_tempo = substr($arr_comp[$i]["tempo"],1,9);
				$str_tempo .= '<div style="color:red"><br>'.substr($arr_comp[$i]["P_geral"],1,9).'</div>';
				array_push($arr_retorno[$i],$str_tempo);
				
				$str_tempototal = '<b>'.substr($arr_comp[$i]["total_geral"],1,9).'</b>';
				$str_tempototal .= '<div style="color:blue"><br>'.substr(secToTime($arr_comp[$i]["total_num"]-$arr_comp[0]["total_num"]),3,7).'</div>';
				array_push($arr_retorno[$i],$str_tempototal);
			}
		} 
		else { // se é desclassificado
			array_push($arr_retorno[$i],$arr_comp[$i]["categoria"]);
			if (!isset($_REQUEST["categoria"])) array_push($arr_retorno[$i],"* * *");
			array_push($arr_retorno[$i],"* * *");
			array_push($arr_retorno[$i],"* * *");
		}
	}
	return $arr_retorno;
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// Definindo o que vai no header da página
if (isset($trecho_final)) $numero_trecho = $trecho_final;
else if ($int_id_ss) $numero_trecho = $int_id_ss;

$tre = criaArray ("SELECT * FROM t02_trecho WHERE c02_codigo=".$numero_trecho);
$dist_esp_tot = $tre[0]["c02_distancia"] + $tre[0]["c02_desl_ini"] + $tre[0]["c02_desl_fin"];

$trecho_txt1 = "SS ".$numero_trecho."   -   ".$tre[0]["c02_nome"]." (".$dist_esp_tot."km)";

$txt_especifico = date("d/m/Y  -  H:i:s");
$txt_especifico .= (($_REQUEST["oficial"] == 1)) ? "<br>Resultados Oficiais" : "<br>Resultados Extra-Oficiais";
if ($_REQUEST["categoria"]) {
	$cat = criaArray ("SELECT * FROM t13_categoria WHERE c13_codigo=".$_REQUEST["categoria"]);
	$txt_especifico .= "<br><font size='4'><b>Categoria: ".$cat[0]["c13_descricao"]."</b></font>";
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL  
$campos_header_ss = array();
array_push($campos_header_ss,"POS");
array_push($campos_header_ss,"NO");
array_push($campos_header_ss,'<div class="trip" id="div">PILOTO/NAVEGADOR</div>');
if (!isset($_REQUEST["categoria"])) array_push($campos_header_ss,"(POS)CAT");
array_push($campos_header_ss,'TEMPO<div style="font-size:10px;color:blue"><br>Dif. Lider</div>');
// ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL  

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL 
$campos_header_geral = array();
array_push($campos_header_geral,"POS");
array_push($campos_header_geral,"NO");
array_push($campos_header_geral,'<div class="trip" id="div">PILOTO/NAVEGADOR</div>');
if (!isset($_REQUEST["categoria"])) array_push($campos_header_geral,"(POS)CAT");
array_push($campos_header_geral,'TEMPO<div style="font-size:10px;color:red"><br>Penal</div>');
array_push($campos_header_geral,'TOTAL<div style="font-size:10px;color:blue"><br>Dif. Lider</div>');
//GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="css/relatorio_print.css" rel="stylesheet" type="text/css" />
		<title></title>
	</head>

	<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#000000">
		<? echo printHeader($numero_trecho, "RESULTADOS PARCIAIS", $txt_especifico); ?>
		<table border="0" cellpadding="5" cellspacing="0" bgcolor="#ffffff" align="center" valign="top" width="100%">
			<tr valign="top">
				<td>
					<span class="td1">  <? echo $trecho_txt1; ?>  </span>
					<table cellpadding="5" cellspacing="0" class="tb1">
						<? 
							echo printTableHeader($campos_header_ss); 
							echo geraLinhaHtml($lista_ss); 
						?>
					</table>
				</td>
				<td>
					<span class="td1">  ACUMULADO AT&Eacute; A ESPECIAL <? echo $trecho_txt1; ?>  </span>
					<table cellpadding="5" cellspacing="0" class="tb1">
						<? 
							echo printTableHeader($campos_header_geral);
							echo geraLinhaHtml($lista_geral);
						?>
					</table>
				</td>
			</tr>
		</table>
		<? echo geraFooter(); ?>
	</body>
</html>