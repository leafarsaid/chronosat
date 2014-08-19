<?

//
set_time_limit(0);

//
header("Content-type: text/html; charset=ISO 8859-1",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);


//
$prova=(int)$_REQUEST["prova"];

		if ($prova==2) $col_stat = "c03_status2";
		else $col_stat = "c03_status";

//
require_once"util/jair_gerador_linhas.php";
require_once"util/cabecalho.php";
require_once"util/sql.php";
require_once"util/database/include/config_bd.inc.php";
require_once"util/database/class/ControleBDFactory.class.php";
$obj_ctrl=ControleBDFactory::getControlador(DB_DRIVER);

$rel_geral=1;

?>

<?
if ($_GET["tv"]==1) {
?>
<html>
<?
} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?
}
?>
<head>

<?
if ($_GET["tv"]==1) {

$_GET["print"]=1;
?>
<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
<meta http-equiv="refresh" content="120">
<SCRIPT language=JavaScript1.2>

//change 1 to another integer to alter the scroll speed. Greater is faster
var speed=1
var currentpos=0,alt=1,curpos1=0,curpos2=-1
function initialize(){
startit()
}
function scrollwindow(){
if (document.all &&
!document.getElementById)
temp=document.body.scrollTop
else
temp=window.pageYOffset
if (alt==0)
alt=2
else
alt=1
if (alt==0)
curpos1=temp
else
curpos2=temp
if (curpos1!=curpos2){
if (document.all)
currentpos=document.body.scrollTop+speed
else
currentpos=window.pageYOffset+speed
window.scroll(0,currentpos)
}
else{
currentpos=0
window.scroll(0,currentpos)
}
}
function startit(){
setInterval("scrollwindow()",50)
}
window.onload=initialize
</SCRIPT>
<?
  }
?>

<script>
function CambiarEstilo(id, aspecto1, aspecto2) {
	var elemento = document.getElementById(id);
	if (elemento.className == aspecto1) {
		elemento.className = aspecto2;
	}
	else {
		elemento.className = aspecto1;
	}
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?

//
$flt_inicio=microtime(1);
$int_id_ss=(int)$_REQUEST["trecho"];
$int_id_cat=(int)$_REQUEST["categoria"];
$int_id_mod=(int)$_REQUEST["modalidade"];
$arr_vcl=(array)$_REQUEST["veiculo"];
$str_hdr_rpt=$_REQUEST["txt_cabecalho"];
$campeonato = $_REQUEST["campeonato"];
$mod = $_REQUEST["mod"];
$fim = $_REQUEST["fim"];

////
$init = criaArray ("SELECT * FROM t02_trecho ORDER BY c02_codigo");
for ($j=0;$j<12;$j++) { 
	if ($init[$j]["c02_codigo"]==($j+1) && $init[$j]["c02_status"]!="NI") $int_id_ss=($j+1); 
}
    //Define quais os trechos que vão ser exibidos no relatório, de acordo com o parâmetro informado no
	//if ($mod=="M" || $int_id_mod > 2) {
		if ($int_id_ss==0) $arr_ss=explode(",","0");
    	elseif ($int_id_ss==1) $arr_ss=explode(",","0,1");
		elseif ($int_id_ss==2) $arr_ss=explode(",","0,1,2");
		elseif ($int_id_ss==3) $arr_ss=explode(",","0,1,2,3");
		elseif ($int_id_ss==4) $arr_ss=explode(",","0,1,2,3,4");
		elseif ($int_id_ss==5) $arr_ss=explode(",","0,1,2,3,4,5");
		elseif ($int_id_ss==55) $arr_ss=explode(",","0,1,2,3,4,5,55");
		elseif ($int_id_ss==6) $arr_ss=explode(",","0,1,2,3,4,5,55,6");
		elseif ($int_id_ss==7) $arr_ss=explode(",","0,1,2,3,4,5,55,6,7");
		elseif ($int_id_ss==8) $arr_ss=explode(",","0,1,2,3,4,5,55,6,7,8");
		elseif ($int_id_ss==9) $arr_ss=explode(",","0,1,2,3,4,5,55,6,7,8,9");
		elseif ($int_id_ss==10) $arr_ss=explode(",","0,1,2,3,4,5,55,6,7,8,9,10");
	//}
	/*else {
    	if ($int_id_ss==1) $arr_ss=explode(",","1");
		elseif ($int_id_ss==2) $arr_ss=explode(",","1,2");
		elseif ($int_id_ss==3) $arr_ss=explode(",","1,2,3");
		elseif ($int_id_ss==4) $arr_ss=explode(",","1,2,3,4");
		elseif ($int_id_ss==5) $arr_ss=explode(",","1,2,3,4,5");
		elseif ($int_id_ss==6) $arr_ss=explode(",","1,2,3,4,5,6");
		elseif ($int_id_ss==7) $arr_ss=explode(",","1,2,3,4,5,6,7,");
		elseif ($int_id_ss==8) $arr_ss=explode(",","1,2,3,4,5,6,7,8");
		elseif ($int_id_ss==9) $arr_ss=explode(",","1,2,3,4,5,6,7,8,9");
		elseif ($int_id_ss==10) $arr_ss=explode(",","1,2,3,4,5,6,7,8,9,10");	
	}*/
if (isset($_REQUEST["trechos"])) {
	$arr_ss = explode(",",$_REQUEST["trechos"]);
	//print_r($arr_ss);
}

$ss_geral=(int)$_REQUEST["ss_geral"];


//sqls 		 geraSqlGeral($int_ss_fim, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, $classi, $nc, $desc)
$geral_sql = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 0);
$geral_sql2 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 0, 0, 0);
$geral_sql3 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 1, 0);
$geral_sql4 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 1);
$geral_sql5 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 0, 0, 1);
$arr_classif = criaArray ($geral_sql);
$arr_nao_classif = criaArray ($geral_sql2);
$arr_nc = criaArray ($geral_sql3);
$arr_desclassif = criaArray ($geral_sql4);
$arr_desclassif2 = criaArray ($geral_sql5);
//$array_todos0 = concat ($arr_classif,$arr_nao_classif);
$array_todos = concat ($arr_classif,$arr_nao_classif,$arr_nc,$arr_desclassif,$arr_desclassif2);
$lista = geraDados ($array_todos);

if ($num_linhas) {
	$pag = count($lista)/$num_linhas;
	if (($pag - (int)$pag) == 0) 	$pag = (int)$pag;
	else 							$pag = (int)$pag+1;
} else $pag = 1;

//print_r($geral_sql);
$pos_cat = array(array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1));
$pos_cat_fim_class = array(array(1),array(1),array(1),array(1));
$pos_cat_fim_trophy = array(array(1),array(1),array(1),array(1));

function geraDados ($arr_comp) {
	$retorno = '';
	$arr_retorno = array();
	
	global $pos_cat;
	global $pos_cat_fim_class;
	global $pos_cat_fim_trophy;
	global $fim;
	global $int_id_ss;
	global $arr_ss;
	global $campeonato;
	global $col_stat;
	global $cbm;

	for ($i=0;$i<count($arr_comp);$i++) {
		$arr_retorno[$i] = array();
		
		if ($cbm==1) $cat_num = $arr_comp[$i]["c13_codigo2"];
		else $cat_num = $arr_comp[$i]["c13_codigo"];

		/////////////////////////////
		$stat = $arr_comp[$i][$col_stat];
		//
		if ($arr_comp[$i]["total_geral"]!="* * *") { 
			if ($stat=="N") $txt_pos = ( $i+1 );	
				
		}
		else {
			$txt_pos = "NC";
		}
		if ($stat=="NC") {
			$txt_pos = "NC";
		}
		// tirar os NC
		$txt_pos = ( $i+1 );
		
		
		if ($stat=="D") $txt_pos = "D";
		if ($txt_pos == "NC" && $_REQUEST['fim']==1) $txt_pos = "DNF";
		//			
		array_push($arr_retorno[$i],$txt_pos);
		////////////////////////////
		//
		array_push($arr_retorno[$i],$arr_comp[$i]["c03_numero"]);

		// TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE
		$piloto = nomeComp($arr_comp[$i]["piloto_geral"]);
		$navegador = nomeComp($arr_comp[$i]["navegador_geral"]);
		$navegador2 = nomeComp($arr_comp[$i]["navegador2_geral"]);
		
		$tripulacao = '<div class="trip" id="div">';
		if ($arr_comp[$i]["piloto_geral"]!="") $tripulacao .= "<b>".$piloto."</b><br>";
		if ($arr_comp[$i]["navegador_geral"]!="") $tripulacao .= "<b>".$navegador."</b><br>";
		if ($arr_comp[$i]["navegador2_geral"]!="") $tripulacao .= "<b>".$navegador2."</b><br>";
		$tripulacao .= $arr_comp[$i]["equipe_geral"];
		$tripulacao .= '</div>';
		array_push($arr_retorno[$i],$tripulacao);
		// TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE
		
		//patrocnio
		//array_push($arr_retorno[$i],'<div style="width:150px;" >'.$arr_comp[$i]["patrocinio_geral"].'</div>');
		if ($_REQUEST["simplificado"]) array_push($arr_retorno[$i],strtoupper(wordwrap($arr_comp[$i]["patrocinio_geral"], 25, "<br />\n")));
		//
		$tripulacao_origem = $arr_comp[$i]["piloto_origem"];
		if ($arr_comp[$i]["navegador_origem"]!="") $tripulacao_origem .= "<br>".$arr_comp[$i]["navegador_origem"];
		if ($arr_comp[$i]["navegador2_origem"]!="") $tripulacao_origem .= "<br>".$arr_comp[$i]["navegador2_origem"];		
		array_push($arr_retorno[$i],$tripulacao_origem);
		
		
		
		//modelo
		array_push($arr_retorno[$i],$arr_comp[$i]["modelo_geral"]);
		
		
		// se não é desclassificado
		//if ($arr_comp[$i][$col_stat]!='D') {
		
		//categoria
		// se nao for fim
		if ($fim!=1) {
			if ($arr_comp[$i]["total_geral"]!="* * *") 
			$txt_pos = $pos_cat[$cat_num][0]+1;
			else 
			$txt_pos = 'NC';			
			$pos_cat[$cat_num][0] ++;			
			if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],"(".$txt_pos.")".$arr_comp[$i]["categoria"]);
			else array_push($arr_retorno[$i],"* * *");
		}
		//se for fim
		if ($fim==1) {
			if ($arr_comp[$i]["c13_codigo"]==10 || $arr_comp[$i]["c13_codigo"]==12) {
				$cat_num2=0;
				$cat_fim_txt = "450";
			}
			elseif ($arr_comp[$i]["c13_codigo"]==11 || $arr_comp[$i]["c13_codigo"]==13) {
				$cat_num2=1;
				$cat_fim_txt = "OPEN";
			}
			else {
				$cat_num2=2;
				$cat_fim_txt = $arr_comp[$i]["categoria"];
			}
			if ($arr_comp[$i]["total_geral"]!="* * *") 
			$txt_pos_fim = $pos_cat_fim_class[$cat_num2][0]+1;
			else 
			$txt_pos_fim = 'DNF';			
			$pos_cat_fim_class[$cat_num2][0] ++;
			
			if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],"(".$txt_pos_fim.")".$cat_fim_txt);
			else array_push($arr_retorno[$i],"* * *");
			
			//trophy
			if ($arr_comp[$i]["c13_codigo"]<12) {
				$cat_num3=0;
			} else $cat_num3=1;
			if ($arr_comp[$i]["total_geral"]!="* * *" && $arr_comp[$i]["c13_codigo"]<12) {
				$txt_pos_trophy = $pos_cat_fim_trophy[$cat_num3][0]+1;
			} else {
				$txt_pos_trophy = '* * *';			
			}
			$pos_cat_fim_trophy[$cat_num3][0] ++;
			
			if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],$txt_pos_trophy);
			else array_push($arr_retorno[$i],"* * *");
			
		}
		
		$status = $arr_comp[$i][$col_stat];
		//
		if (!$_REQUEST["simplificado"]) {
			for ($k=0;$k<=5;$k++) {
				$txt_ss = "ss".$k;
				if (in_array($k, $arr_ss)) {
					if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],$arr_comp[$i][$txt_ss]);
					else array_push($arr_retorno[$i],"* * *");
				}
			}
			if (in_array(55, $arr_ss)) {
				if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],$arr_comp[$i]['ss55']);
				else array_push($arr_retorno[$i],"* * *");
			}
			for ($k=6;$k<=10;$k++) {
				$txt_ss = "ss".$k;
				if (in_array($k, $arr_ss)) {
					if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],$arr_comp[$i][$txt_ss]);
					else array_push($arr_retorno[$i],"* * *");
				}
			}
		}
		
		
		if ($arr_comp[$i]["c03_numero"]<300) {		
			//
			if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],$arr_comp[$i]["tempo"]);
			else array_push($arr_retorno[$i],"* * *");
			
			//
			if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],$arr_comp[$i]["P_geral"]);
			else array_push($arr_retorno[$i],"* * *");
	
			//
			if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],$arr_comp[$i]["total_geral"]);
			else array_push($arr_retorno[$i],"* * *");
		} else {		
			//
			if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],$arr_comp[$i]["tempo_carros"]);
			else array_push($arr_retorno[$i],"* * *");
			
			//
			if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],$arr_comp[$i]["P_geral_carros"]);
			else array_push($arr_retorno[$i],"* * *");
	
			//
			if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],$arr_comp[$i]["total_geral_carros"]);
			else array_push($arr_retorno[$i],"* * *");
		}

		//
		$l = $i-1;
		if ($l<0) $l=0;
		if ($arr_comp[$i]["total_geral"]!="* * *" && $arr_comp[$i][$col_stat]!='NC') {
			if ($status == 'D') {
				if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],"");
				else array_push($arr_retorno[$i],"* * *");
			}
			else {
				if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],secToTime($arr_comp[$i]["total_num"]-$arr_comp[$l]["total_num"]));
				else array_push($arr_retorno[$i],"* * *");
			}
		}
		else {
			if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],' ');
			else array_push($arr_retorno[$i],"* * *");
		}
		//
		if ($arr_comp[$i]["total_geral"]!="* * *" && $arr_comp[$i][$col_stat]!='NC') {
			if ($status == 'D') {
				if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],"");
				else array_push($arr_retorno[$i],"* * *");
			}
			else {
				if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],secToTime($arr_comp[$i]["total_num"]-$arr_comp[0]["total_num"]));
				else array_push($arr_retorno[$i],"* * *");
			}
		}
		else {
			if ($arr_comp[$i][$col_stat]!='D') array_push($arr_retorno[$i],' ');
			else array_push($arr_retorno[$i],"* * *");
		}
		
		/*} // se não é desclassificado
		else { // se é desclassificado
			array_push($arr_retorno[$i],$arr_comp[$i]["categoria"]);
			for ($k=1;$k<=12;$k++) {
				if (in_array($k, $arr_ss)) array_push($arr_retorno[$i],"* * *");
			}
			//array_push($arr_retorno[$i],"* * *");
			//array_push($arr_retorno[$i],"* * *");
			//array_push($arr_retorno[$i],"* * *");
			//array_push($arr_retorno[$i],"* * *");
			if (!$_REQUEST["simplificado"]) {
				for ($k=0;$k<count($arr_ss);$k++) array_push($arr_retorno[$i],"* * *");
			}
		}*/
	}
	return $arr_retorno;
}

if ($_GET["print"]==1) 	echo "<link href=\"css/relatorio_print.css\" rel=\"stylesheet\" type=\"text/css\" />";
else					echo "<link href=\"css/relatorio_video.css\" rel=\"stylesheet\" type=\"text/css\" />";

?>
<title></title>
<!--script defer type="text/javascript" src="js/pngfix.js"></script//-->


</head>
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#000000">
<table border="0" cellpadding="0" cellspacing="0" bgcolor="#000000" align="center" width="100%">
<?
/*
$cat = criaArray ("SELECT * FROM t13_categoria WHERE c13_codigo=".$categoria);
$cat_txt = $cat[0]["c13_descricao"];

$tre = criaArray ("SELECT * FROM t02_trecho WHERE c02_codigo=".$int_id_ss);

$trecho_txt1 = $tre[0]["c02_origem"]." - ".$tre[0]["c02_destino"]." - ".$tre[0]["c02_distancia"]."km";
$desloc1 = $tre[0]["c02_desl_ini"];
$dist_esp = $tre[0]["c02_distancia"] + $tre[0]["c02_desl_ini"] + $tre[0]["c02_desl_fin"];
$desloc2 = $tre[0]["c02_desl_fin"];
$txt_especifico = date("D M j G:i:s T Y");
$txt_especifico .= "<br><br>Resultados Acumulados/Overall Results";
$txt_especifico .= "<br>Categoria/Category: ".$cat_txt;
echo printHeader($trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, '', $campeonato);
*/


$cat = criaArray ("SELECT * FROM t13_categoria WHERE c13_codigo=".$int_id_cat);
$cat_txt = $cat[0]["c13_descricao"];
if ($cat_txt=="") {
	if ($mod=="C") 	$cat_txt = "CARROS/CAMINH&Otilde;ES";
	elseif ($mod=="M") $cat_txt = "MOTOS E QUADRIS/<i>BIKES AND QUADS</i>";
	elseif ($modalidade==1) $cat_txt = "CARROS";
	elseif ($modalidade==2) $cat_txt = "CAMINH&Otilde;ES";
	elseif ($modalidade==3) $cat_txt = "MOTOS//<i>BIKES</i>";
	elseif ($modalidade==4) $cat_txt = "QUADRIS//<i>QUADS</i>";
	else $cat_txt = "TODOS/ALL";
	 $cat_txt .= "<br><br>".$_REQUEST["titulo"];
}

$numero_trecho = $int_id_ss;
if ($sss) $numero_trecho = $sss;

$tre = criaArray ("SELECT * FROM t02_trecho WHERE c02_codigo=".$numero_trecho);

$dist_esp_tot = $tre[0]["c02_distancia"] + $tre[0]["c02_desl_ini"] + $tre[0]["c02_desl_fin"];
//$trecho_txt1 = $tre[0]["c02_origem"]." - ".$tre[0]["c02_destino"]." - ".$dist_esp_tot."km";
if (isset($trecho)) $trecho_txt1 = "RESULTADOS ACUMULADOS AT&Eacute; A ETAPA ".$tre[0]["c02_nome"].": ".$tre[0]["c02_origem"]." - ".$tre[0]["c02_destino"]." (".$dist_esp_tot." Km)";

$dist_esp = $tre[0]["c02_distancia"];
$desloc1 = $tre[0]["c02_desl_ini"];
$desloc2 = $tre[0]["c02_desl_fin"];

$parcial = $_REQUEST["parcial"];

if ($tre[0]["c02_status"]=="F") {
  if (isset($cbm))	$status .= "<br/>RESULTADOS OFICIAIS/OFFICIAL RESULTS - CAMPEONATO BRASILEIRO";
  elseif (isset($fim))	$status .= "<br/>RESULTADOS OFICIAIS/OFFICIAL RESULTS - MUNDIAL FIM"; 
  else $status .= "<br/>RESULTADOS OFICIAIS/OFFICIAL RESULTS";
}
else {
  if (isset($parcial))	{
    if (isset($cbm)) $status .= "<br/>RESULTADOS PARCIAIS/PROVISIONAL RESULTS - CAMPEONATO BRASILEIRO";
    elseif (isset($fim))	$status .= "<br/>RESULTADOS PARCIAIS/PROVISIONAL RESULTS - MUNDIAL FIM";
    else $status .= "<br/>RESULTADOS PARCIAIS/PROVISIONAL RESULTS";
  }
  else {
    if (isset($cbm))	$status .= "<br/>RESULTADOS EXTRA-OFICIAIS/UNOFFICIAL RESULTS - CAMPEONATO BRASILEIRO";
    elseif (isset($fim))	$status .= "<br/>RESULTADOS EXTRA-OFICIAIS/UNOFFICIAL RESULTS - MUNDIAL FIM"; 
    else $status .= "<br/>RESULTADOS EXTRA-OFICIAIS/UNOFFICIAL RESULTS";
  }
}
  
$trecho_txt1 .= "<br/>".$status;
$txt_especifico = date("j/M/Y - G:i:s (T)");
//$txt_especifico .= "<br><br>Resultados Acumulados/Overall Results - Motos/Bikes";
//$txt_especifico .= "".$status;
if (isset($mod) || isset($modalidade)) $txt_especifico .= "<br><br>".$cat_txt;
else $txt_especifico .= "<br><br>Categoria: ".$cat_txt;
 
echo printHeader($numero_trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, '', $campeonato, "1/".$pag, $status);

?>
<tr>
  <td height="60" colspan="2" valign="top">


	<!-- ////////////////////////////////////////////////////////////////////////////// //-->
<table cellpadding="5" cellspacing="0" class="tb1">
<?

// campos do cabecalho
$campos_header_ss = array();

array_push($campos_header_ss,"Pos");
array_push($campos_header_ss,"No");
array_push($campos_header_ss,"Piloto/Navegador<br><i>Driver/Co-Driver</i>");
if ($_REQUEST["simplificado"]) array_push($campos_header_ss,"Patroc&iacute;nio<br><i>Sponsor</i>");
array_push($campos_header_ss,"Nat<br><i>Nat</i>");
array_push($campos_header_ss,"Fab./Mod.<br><i>Make/Model</i>");
//se nao for fim
if ($fim!=1) {
	array_push($campos_header_ss,"(Pos)Cat");
}
//se for fim
if ($fim==1) {
	array_push($campos_header_ss,"(Pos)<br>Cls");
	array_push($campos_header_ss,"Pos<br>Trophy");
}

if (!$_REQUEST["simplificado"]) {
	if (in_array("0", $arr_ss)) array_push($campos_header_ss,"Prol.");
	if (in_array("1", $arr_ss)) array_push($campos_header_ss,"SS1");
	if (in_array("2", $arr_ss)) array_push($campos_header_ss,"SS2");
	if (in_array("3", $arr_ss)) array_push($campos_header_ss,"SS3");
	if (in_array("4", $arr_ss)) array_push($campos_header_ss,"SS4");
	if (in_array("5", $arr_ss)) array_push($campos_header_ss,"SS5");
	if (in_array("55", $arr_ss)) array_push($campos_header_ss,"Prime");
	if (in_array("6", $arr_ss)) array_push($campos_header_ss,"SS6");
	if (in_array("7", $arr_ss)) array_push($campos_header_ss,"SS7");
	if (in_array("8", $arr_ss)) array_push($campos_header_ss,"SS8");
	if (in_array("9", $arr_ss)) array_push($campos_header_ss,"SS9");
	if (in_array("10", $arr_ss)) array_push($campos_header_ss,"SS10");
}
array_push($campos_header_ss,"Tempo<br><i>Scratch</i>");
array_push($campos_header_ss,"Penal.<br><i>Penalty</i>");
array_push($campos_header_ss,"Tempo Total<br><i>Total Time</i>");
array_push($campos_header_ss,"Dif.Ant.<br><i>Diff Prev</i>");
array_push($campos_header_ss,"Dif.L&iacute;der<br><i>Diff 1st</i>");
/*
array_push($campos_header_ss,"Tempo");
array_push($campos_header_ss,"Penal.");
array_push($campos_header_ss,"Tempo Total");
array_push($campos_header_ss,"Dif.Ant.");
array_push($campos_header_ss,"Dif.L&iacute;der");
*/

echo printTableHeader($campos_header_ss);
//print_r("campeonato=".$campeonato);
//echo geraLinhaHtml ($lista, 1, $_GET["num_linhas"], $campos_header_ss, $header_txt, $report_date, $print, $campeonato);
//ho geraLinhaHtml ($lista, 1, $_GET["num_linhas"], $campos_header_ss, $print, $campeonato, $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico)
echo geraLinhaHtml ($lista, 1, $_GET["num_linhas"], $campos_header_ss, $print, $campeonato, $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, $pag, $status);
            
?>
</table>
       <!-- ///////////////////////////
    <? print_r($geral_sql) ?>
    /////////////////////////////////////////////////// //-->
    
    
    
    
           <!-- ///////////////////////////
    <?= print_r($geral_sql2) ?>
    /////////////////////////////////////////////////// //-->   
    
    
    
           <!-- ///////////////////////////
    <?= print_r($geral_sql3) ?>
    /////////////////////////////////////////////////// //-->


  </td>
</tr>

<?= $footer ?>
</table>


</table>
</body>
</html>
