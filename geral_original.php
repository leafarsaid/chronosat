<?

//

set_time_limit(0);



//

header("Content-type: text/html; charset=iso-8859-1",true);

header("Cache-Control: no-cache, must-revalidate",true);

header("Pragma: no-cache",true);



//

$prova=(int)$_REQUEST["prova"];



	if ($prova==2) $col_stat = "c03_status2";

	else $col_stat = "c03_status";



//

require_once"util/gerador_linhas.php";

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

<meta http-equiv="refresh" content="45">

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



////

$init = criaArray ("SELECT * FROM t02_trecho ORDER BY c02_codigo");

for ($j=0;$j<12;$j++) { 

	if ($init[$j]["c02_codigo"]==($j+1) && $init[$j]["c02_status"]!="NI") $int_id_ss=($j+1); 

}





	//if ($int_id_ss=="") $int_id_ss=5;

	$arr_ss=explode(",","1,2,3,4,5,6,7,8,9,10");



		if ($int_id_ss==0) $arr_ss=explode(",","0");

		elseif ($int_id_ss==1) $arr_ss=explode(",","1");

		elseif ($int_id_ss==2) $arr_ss=explode(",","1,2");

		elseif ($int_id_ss==3) $arr_ss=explode(",","1,2,3");

		elseif ($int_id_ss==4) $arr_ss=explode(",","1,2,3,4");

		elseif ($int_id_ss==5) $arr_ss=explode(",","1,2,3,4,5");

		elseif ($int_id_ss==6) $arr_ss=explode(",","1,2,3,4,5,6");

		elseif ($int_id_ss==7) $arr_ss=explode(",","1,2,3,4,5,6,7");

		elseif ($int_id_ss==8) $arr_ss=explode(",","1,2,3,4,5,6,7,8");

		elseif ($int_id_ss==9) $arr_ss=explode(",","1,2,3,4,5,6,7,8,9");

		elseif ($int_id_ss==10) $arr_ss=explode(",","1,2,3,4,5,6,7,8,9,10");

		

if (isset($_REQUEST["trechos"])) {

	$arr_ss = explode(",",$_REQUEST["trechos"]);

	print_r($arr_ss);

}

$ss_geral=(int)$_REQUEST["ss_geral"];



//sqls geraSqlGeral($int_ss_fim, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $classi)

$geral_sql = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 0);

$geral_sql2 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 0, 0, 0);

$geral_sql3 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 1, 0);

$geral_sql4 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 1);

$arr_classif = criaArray ($geral_sql);



$arr_nao_classif = criaArray ($geral_sql2);

$arr_nc = criaArray ($geral_sql3);

$arr_desclassif = criaArray ($geral_sql4);

//$array_todos0 = concat ($arr_classif,$arr_nao_classif);

$array_todos = concat ($arr_classif,$arr_nao_classif,$arr_nc,$arr_desclassif);



$lista = geraDados ($array_todos);

//var_dump($lista);

if ($num_linhas) {

	$pag = count($lista)/$num_linhas;

	if (($pag - (int)$pag) == 0) 	$pag = (int)$pag;

	else 							$pag = (int)$pag+1;

} else $pag = 1;

//print_r($geral_sql);

$pos_cat = array(array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1));



function geraDados ($arr_comp) {

	$retorno = '';

	$arr_retorno = array();



	global $pos_cat;

	global $int_id_ss;

	global $arr_ss;

	global $campeonato;

	global $col_stat;



	for ($i=0;$i<count($arr_comp);$i++) {

		$arr_retorno[$i] = array();

		$cat_num = $arr_comp[$i]["c13_codigo"];

		/////////////////////////////

		$stat = $arr_comp[$i][$col_stat];

		//

		if ($arr_comp[$i]["total_geral"]!="* * *") { 

			if ($stat=="N") $txt_pos = ( $i+1 );	

		}

		else {

			$txt_pos = "NC";

		}

		if ($stat=="NC") $txt_pos = "NC";

		if ($stat=="D") $txt_pos = "D";

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

		//

		$tripulacao_origem = $arr_comp[$i]["piloto_origem"];

		if ($arr_comp[$i]["navegador_origem"]!="") $tripulacao_origem .= "<br>".$arr_comp[$i]["navegador_origem"];

		if ($arr_comp[$i]["navegador2_origem"]!="") $tripulacao_origem .= "<br>".$arr_comp[$i]["navegador2_origem"];		

		array_push($arr_retorno[$i],$tripulacao_origem);



		// se não é desclassificado

		if ($arr_comp[$i][$col_stat]!='D') {



		//

		if ($arr_comp[$i]["total_geral"]!="* * *") 

		$txt_pos = $pos_cat[$cat_num][0]+1;

		else 

		$txt_pos = 'NC';			

		$pos_cat[$cat_num][0] ++;

		array_push($arr_retorno[$i],"(".$txt_pos.")".$arr_comp[$i]["categoria"]);



		$status = $arr_comp[$i][$col_stat];



		//

		for ($k=0;$k<=12;$k++) {

			$txt_ss = "ss".$k;

			if (in_array($k, $arr_ss)) {

				array_push($arr_retorno[$i],$arr_comp[$i][$txt_ss]);

			}

		}

				

		//

		array_push($arr_retorno[$i],$arr_comp[$i]["tempo"]);

		

		//

		array_push($arr_retorno[$i],$arr_comp[$i]["P_geral"]);



		//

		array_push($arr_retorno[$i],$arr_comp[$i]["total_geral"]);



		//

		$l = $i-1;

		if ($l<0) $l=0;

		if ($arr_comp[$i]["total_geral"]!="* * *" && $arr_comp[$i][$col_stat]!='NC') {

			if ($status == 'D') array_push($arr_retorno[$i],"");

			else array_push($arr_retorno[$i],substr(secToTime($arr_comp[$i]["total_num"]-$arr_comp[$l]["total_num"]),3));

		}

		else {

			array_push($arr_retorno[$i],' ');

		}



		//

		if ($arr_comp[$i]["total_geral"]!="* * *" && $arr_comp[$i][$col_stat]!='NC') {

			if ($status == 'D') array_push($arr_retorno[$i],"");

			else array_push($arr_retorno[$i],substr(secToTime($arr_comp[$i]["total_num"]-$arr_comp[0]["total_num"]),3));

		}

		else {

			array_push($arr_retorno[$i],' ');

		}



		} // se não é desclassificado



		else { // se é desclassificado

			array_push($arr_retorno[$i],$arr_comp[$i]["categoria"]);

			for ($k=0;$k<=10;$k++) {

				if (in_array($k, $arr_ss)) array_push($arr_retorno[$i],"* * *");

			}

			array_push($arr_retorno[$i],"* * *");

			array_push($arr_retorno[$i],"* * *");

			array_push($arr_retorno[$i],"* * *");

			array_push($arr_retorno[$i],"* * *");

			array_push($arr_retorno[$i],"* * *");



			if ($status == 'D' && !$prova) {

				array_push($arr_retorno[$i],"* * *");

				array_push($arr_retorno[$i],"* * *");			

			}

		}

	}

	return $arr_retorno;

}



if ($_GET["print"]==1) 	echo "<link href=\"css/relatorio_print.css\" rel=\"stylesheet\" type=\"text/css\" />";

else					echo "<link href=\"css/relatorio_video.css\" rel=\"stylesheet\" type=\"text/css\" />";



?>

<title></title>

</head>

<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#000000">

<table border="0" cellpadding="0" cellspacing="0" bgcolor="#000000" align="center" width="900">

<?



$cat = criaArray ("SELECT * FROM t13_categoria WHERE c13_codigo=".$int_id_cat);

$cat_txt = $cat[0]["c13_descricao"];

if ($cat_txt=="") {

	if ($mod=="C") 	$cat_txt = "Carros/Caminh&otilde;es";

	elseif ($mod=="M") $cat_txt = "Motos/Quadric&iacute;clos";

	elseif ($modalidade==1) $cat_txt = "Carros";

	elseif ($modalidade==2) $cat_txt = "Caminh&otilde;es";

	elseif ($modalidade==3) $cat_txt = "Motos";

	elseif ($modalidade==4) $cat_txt = "Quadric&iacute;clos";

	else $cat_txt = "Todos/Overall";

}



if ($int_id_ss) $numero_trecho = $int_id_ss;

//else $numero_trecho = 2;

if ($sss) $numero_trecho = $sss;

if ($prova==1) $numero_trecho = 4;

if ($prova==2) $numero_trecho = 8;



$tre = criaArray ("SELECT * FROM t02_trecho WHERE c02_codigo=".$numero_trecho);

$dist_esp_tot = $tre[0]["c02_distancia"] + $tre[0]["c02_desl_ini"] + $tre[0]["c02_desl_fin"];

//$trecho_txt1 = $tre[0]["c02_origem"]." - ".$tre[0]["c02_destino"]." - ".$dist_esp_tot."km";

if (isset($trecho)) $trecho_txt1 = "Acumulado at&eacute; a especial: ".$tre[0]["c02_nome"]." - ".$dist_esp_tot."km";



$dist_esp = $tre[0]["c02_distancia"];

$desloc1 = $tre[0]["c02_desl_ini"];

$desloc2 = $tre[0]["c02_desl_fin"];

if ($tre[0]["c02_status"]=="F") 	$status = "<br>Resultados Oficiais";

else 								$status .= "<br>Resultados Extra-Oficiais";



//print_r($tre[0]["c02_status"]);



$txt_especifico = date("j/M/Y - G:i:s (T)");

//$txt_especifico .= "<br><br>Resultados Acumulados/Overall Results - Motos/Bikes";

$txt_especifico .= "".$status;

$txt_especifico .= "<br>Categoria: ".$cat_txt;

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

array_push($campos_header_ss,"Piloto/Navegador");

array_push($campos_header_ss,"Nat");

array_push($campos_header_ss,"(Pos)Cat");



if (in_array("0", $arr_ss)) array_push($campos_header_ss,"Prol.");

if (in_array("1", $arr_ss)) array_push($campos_header_ss,"SS1<br><br>");

if (in_array("2", $arr_ss)) array_push($campos_header_ss,"SS2");

if (in_array("3", $arr_ss)) array_push($campos_header_ss,"SS3");

if (in_array("4", $arr_ss)) array_push($campos_header_ss,"SS4");

if (in_array("5", $arr_ss)) array_push($campos_header_ss,"SS5");

if (in_array("6", $arr_ss)) array_push($campos_header_ss,"SS1");

if (in_array("7", $arr_ss)) array_push($campos_header_ss,"SS2");

if (in_array("8", $arr_ss)) array_push($campos_header_ss,"SS3");

if (in_array("9", $arr_ss)) array_push($campos_header_ss,"SS4");

if (in_array("10", $arr_ss)) array_push($campos_header_ss,"SS4");

if (in_array("11", $arr_ss)) array_push($campos_header_ss,"SS5");

if (in_array("12", $arr_ss)) array_push($campos_header_ss,"SS6");



array_push($campos_header_ss,"Tempo");

array_push($campos_header_ss,"Penal.");

array_push($campos_header_ss,"Tempo Total");

array_push($campos_header_ss,"Dif.Ant.");

array_push($campos_header_ss,"Dif.L&iacute;der");



echo printTableHeader($campos_header_ss);

//print_r("campeonato=".$campeonato);

//echo geraLinhaHtml ($lista, 1, $_GET["num_linhas"], $campos_header_ss, $header_txt, $report_date, $print, $campeonato);

//ho geraLinhaHtml ($lista, 1, $_GET["num_linhas"], $campos_header_ss, $print, $campeonato, $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico)



echo geraLinhaHtml ($lista, 1, $_GET["num_linhas"], $campos_header_ss, $print, $campeonato, $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, $pag, $status);

      



?>

</table>

       <!-- ///////////////////////////

    <?= $geral_sql ?>

    /////////////////////////////////////////////////// //-->



   



           <!-- ///////////////////////////



    <?= $geral_sql2 ?>



    /////////////////////////////////////////////////// //-->   



   



           <!-- ///////////////////////////



    <?= $geral_sql3 ?>



    /////////////////////////////////////////////////// //-->

   



           <!-- ///////////////////////////



    <?= $geral_sql4 ?>



    /////////////////////////////////////////////////// //-->





  </td>

</tr>



<?= $footer ?>

</table>



</table>

</body>

</html>



