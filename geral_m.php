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
require_once"util/especiais.php";

$rel_geral=1;

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
<script language=JavaScript1.2>
//change 1 to another integer to alter the scroll speed. Greater is faster
var speed=1
var currentpos=0,alt=1,curpos1=0,curpos2=-1
function initialize(){
startit()

}



function scrollwindow(){

if (document.all && !document.getElementById)
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

</script>



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

		

if (isset($_REQUEST["trechos"])) {
	$arr_ss = explode(",",$_REQUEST["trechos"]);
}

$ss_geral=(int)$_REQUEST["ss_geral"];

if ($num_linhas) {

	$pag = count($lista)/$num_linhas;
	if (($pag - (int)$pag) == 0) 	$pag = (int)$pag;
	else 							$pag = (int)$pag+1;

} else $pag = 1;

if ($_GET["print"]==1) 	echo "<link href=\"css/relatorio_print.css\" rel=\"stylesheet\" type=\"text/css\" />";
else					echo "<link href=\"css/relatorio_video.css\" rel=\"stylesheet\" type=\"text/css\" />";

//valores
$lista = array();

$xml_src = "http://".$_SERVER[HTTP_HOST]."/2014/cprv/morretes/geralXML.php?".$_SERVER['QUERY_STRING'];

$xml = simplexml_load_file($xml_src);

//phpinfo();//_SERVER[REQUEST_URI]
//var_dump($xml_src);



//xml2array($lista, $lista_array);

//var_dump($lista_array);]



$lista_array = array();



for ($i=0;$i<count($xml);$i++) {

	foreach($xml->veiculo[$i]->attributes() as $key => $value) {

		$lista_array[$i][$key] = (string)$value;

	}

}



$i=0;

foreach ($lista_array as $v) {

	//var_dump($v);

	//echo $v['piloto']."<br />";

	

	$lista[$i] = array();

	 

    array_push($lista[$i], $v['colocacao']);

    array_push($lista[$i], $v['numeral']);

	

	$piloto = nomeComp($v['piloto']);

	$navegador = nomeComp($v['navegador']);

	$navegador2 = nomeComp($v['navegador2']);

	

	$tripulacao = '<div class="trip" id="div">';

	if ($piloto!="") $tripulacao .= "<b>".$piloto."</b><br>";

	if ($navegador!="") $tripulacao .= "<b>".$navegador."</b><br>";

	if ($navegador2!="") $tripulacao .= "<b>".$navegador2."</b>";


	$tripulacao .= '</div>';

	array_push($lista[$i], $tripulacao);
	//array_push($lista[$i], utf8_decode($v['modelo']));
	//array_push($lista[$i], utf8_decode($v['equipe']));

	

	if ($piloto!="") $origem = $v['origem_piloto'].'<br />';

	if ($navegador!="") $origem .= $v['origem_navegador'].'<br />';

	if ($navegador2!="") $origem .= $v['origem_navegador2'];		

    //array_push($lista[$i], $origem);

    array_push($lista[$i], $v['categoria']);	

	for ($x=0;$x<50;$x++) {
		if ($x==0) {
			$txt_ss = "prologo";
		} else {
			$txt_ss = "ss$x";
		}
		if (in_array("$x",$arr_ss)) array_push($lista[$i], substr($v["$txt_ss"],3,10));
	}

	array_push($lista[$i], substr($v['tempo'],1,10));

	array_push($lista[$i], substr($v['penalidade'],1,7));

	//array_push($lista[$i], substr($v['bonus'],1,7));
	
	array_push($lista[$i], substr($v['total'],1,10));

	//array_push($lista[$i], substr($v['diferenca_anterior'],3,10));

	array_push($lista[$i], substr($v['diferenca_lider'],1,10));

	$i++;

}



//var_dump($lista);



?>



<title></title>



</head>



<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#000000">



<table border="0" cellpadding="0" cellspacing="0" bgcolor="#000000" align="center" width="100%">



<?






$cat = criaArray ("SELECT * FROM t13_categoria WHERE c13_codigo=".$int_id_cat);

$cat_txt = $cat[0]["c13_descricao"];

if ($cat_txt=="") {
	if ($mod=="C") 	$cat_txt = "Carros/Caminh&otilde;es";
	elseif ($mod=="M") $cat_txt = "Motos/Quadric&iacute;clos - Bikes and Quads";
	elseif ($modalidade==1) $cat_txt = "Carros";
	elseif ($modalidade==2) $cat_txt = "Caminh&otilde;es";
	elseif ($modalidade==3) $cat_txt = "Motos - Bikes";
	elseif ($modalidade==4) $cat_txt = "Quadric&iacute;clos - Quads";
	elseif ($modalidade==5) $cat_txt = "UTVs";
	else $cat_txt = "Todos/Overall";
}


if ($int_id_ss) $numero_trecho = $int_id_ss;

//else $numero_trecho = 2;

if ($sss) $numero_trecho = $sss;

if ($prova==1) $numero_trecho = 4;

if ($prova==2) $numero_trecho = 9;

if ($_REQUEST['trecho']==0) $numero_trecho = 0;



$tre = criaArray ("SELECT * FROM t02_trecho WHERE c02_codigo=".$numero_trecho);

$dist_esp_tot = $tre[0]["c02_distancia"] + $tre[0]["c02_desl_ini"] + $tre[0]["c02_desl_fin"];

//$trecho_txt1 = $tre[0]["c02_origem"]." - ".$tre[0]["c02_destino"]." - ".$dist_esp_tot."km";

if (isset($trecho)) $trecho_txt1 = "ACUMULADO AT&Eacute; A ESPECIAL: ".$tre[0]["c02_nome"];//." - ".$dist_esp_tot."km";



$dist_esp = $tre[0]["c02_distancia"];

$desloc1 = $tre[0]["c02_desl_ini"];

$desloc2 = $tre[0]["c02_desl_fin"];

if ($_REQUEST["oficial"]==1) 	$status = "<br>Resultados Oficiais";

else 								$status .= "<br>Resultados Extra-Oficiais";



//print_r($tre[0]["c02_status"]);



$txt_especifico = date("j/M/Y - G:i:s (T)");

//$txt_especifico .= "<br><br>Resultados Acumulados/Overall Results - Motos/Bikes";

$txt_especifico .= "".$status;

$txt_especifico .= "<br><font size='4'><b>Categoria: ".$cat_txt."</b></font>";

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
//array_push($campos_header_ss,"Modelo");
//array_push($campos_header_ss,"Equipe");

//array_push($campos_header_ss,"Nat");

array_push($campos_header_ss,"(Pos)Cat");


	for ($x=0;$x<50;$x++) {
		if ($x==0) {
			$txt_ss = "Pról.";
		} else {
			$txt_ss = "SS$x";
		}
		if (in_array("$x", $arr_ss)) array_push($campos_header_ss,"$txt_ss");
	}



array_push($campos_header_ss,"Tempo");

array_push($campos_header_ss,"Penal.");

//array_push($campos_header_ss,"Bonus");
array_push($campos_header_ss,"Tempo Total");

//array_push($campos_header_ss,"Dif.Ant.");

array_push($campos_header_ss,"Dif.L&iacute;der");



echo printTableHeader($campos_header_ss);



echo geraLinhaHtml ($lista, 1, $_GET["num_linhas"], $campos_header_ss, $print, $campeonato, $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, $pag, $status);



      

?>



</table>

  </td>

</tr>



<?= $footer ?>



</table>



</table>



</body>



</html>







