<?



$arr = criaArray ("SELECT MAX(c02_codigo) AS maxtrecho FROM t02_trecho WHERE c02_status='I'");

$maxtrecho = $arr[0]["maxtrecho"];



if (!$_REQUEST["trecho"]) {
	$trecho = $maxtrecho;
	$int_id_ss = $maxtrecho;
} else {
	$trecho = $_REQUEST["trecho"];
}

if ($_REQUEST["prova"]==1) {
	$arr_ss=explode(",","1,2,3,4,5,6");
	if ($trecho==1) $arr_ss=explode(",","1");	
	elseif ($trecho==2) $arr_ss=explode(",","1,2");
	elseif ($trecho==3) $arr_ss=explode(",","1,2,3");
	elseif ($trecho==4) $arr_ss=explode(",","1,2,3,4");
	elseif ($trecho==5) $arr_ss=explode(",","1,2,3,4,5");
	elseif ($trecho==6) $arr_ss=explode(",","1,2,3,4,5,6");	
	else $arr_ss=explode(",","1,2,3,4,5,6");
} elseif ($_REQUEST["prova"]==2) {	
	$arr_ss=explode(",","7,8,9,10");
	if ($trecho==7) $arr_ss=explode(",","7");	
	elseif ($trecho==8) $arr_ss=explode(",","7,8");	
	elseif ($trecho==9) $arr_ss=explode(",","7,8,9");	
	elseif ($trecho==10) $arr_ss=explode(",","7,8,9,10");	
	else $arr_ss=explode(",","7,8,9,10");		
} else {
	if ($trecho==1) $arr_ss=explode(",","1");	
	elseif ($trecho==2) $arr_ss=explode(",","1,2");	
	elseif ($trecho==3) $arr_ss=explode(",","1,2,3");	
	elseif ($trecho==4) $arr_ss=explode(",","1,2,3,4");	
	elseif ($trecho==5) $arr_ss=explode(",","1,2,3,4,5");	
	elseif ($trecho==6) $arr_ss=explode(",","1,2,3,4,5,6");	
	elseif ($trecho==7) $arr_ss=explode(",","1,2,3,4,5,6,7");	
	elseif ($trecho==8) $arr_ss=explode(",","1,2,3,4,5,6,7,8");
	elseif ($trecho==9) $arr_ss=explode(",","1,2,3,4,5,6,7,8,9");
	elseif ($trecho==10) $arr_ss=explode(",","1,2,3,4,5,6,7,8,9,10");	
	else {	
		$arr_ss=explode(",","1,2,3,4,5,6,7,8,9,10");	
	}	
}
	
if (isset($_REQUEST["trechos"])) {

	$arr_ss = explode(",",$_REQUEST["trechos"]);

}







?>