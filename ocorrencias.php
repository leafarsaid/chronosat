<?
//
set_time_limit(0);

//
header("Content-type: text/html; charset=iso-8859-1",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

//
//
require_once"util/gerador_linhas.php";
require_once"util/sql.php";

$query = "SELECT o.c33_motivo AS motivo";
$query .= " ,o.c03_codigo AS numero ";
$query .= " ,o.c33_ss AS especial";
$query .= " ,o.c33_tipo AS tipo";
$query .= " ,getTripulanteNome(v.c03_piloto) AS piloto ";
$query .= " ,getTripulanteNome(v.c03_navegador) AS navegador ";
$query .= " ,getTripulanteNome(v.c03_navegador2) AS navegador2 ";
$query .= " ,getModeloNome(v.c03_piloto) AS modelo ";
$query .= " FROM t33_ocorrencias AS o";
$query .= " ,t03_veiculo AS v";
$query .= " WHERE v.c03_codigo=o.c03_codigo ";
if ($_REQUEST["prova"]) $query .= " AND o.c33_prova=".$_GET['prova'];
$query .= " ORDER BY o.c03_codigo";
$linha = criaArray ($query);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="css/relatorio_print.css" rel="stylesheet" type="text/css" />
		<title></title>
	</head>
	<body marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" topmargin="0">
		<p align="right">&nbsp;</p>
		<p align="right">&nbsp;</p>
		<p align="center"><img src="imagens/logo_erechim_2014.png" height="100"/></p> <!-- colocar aqui o logo da prova -->
		<p align="right">&nbsp;</p>
		<p align="right">&nbsp;</p>
		<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr valign="bottom" class="style5">
				<td align="left">
					<!-- colocar aqui o nome da prova -->
					<strong>RALLY INTERNACIONAL DE ERECHIM 2014</strong><br>
					<? if ($_REQUEST["prova"]) echo 'PROVA '.$_REQUEST["prova"].'<br>'; ?>
				</td>
				<td align="right"><strong>ABANDONOS</strong></td>
			</tr>
			<tr bgcolor="#CC9900">
				<td height="3" colspan="2"></td>
			</tr>
			<tr>
				<td valign="top" colspan="2">
					<table width="100%" cellpadding="5" cellspacing="0" class="tb1">
						<tr class="td1">
							<td width="9%" class="cells">NO</td>
							<td width="30%" class="cells"><div class="trip">PILOTO/NAVEGADOR</div></td>
							<td width="9%" class="cells">SS</td>
							<td width="52%" class="cells"><div class="trip">MOTIVO</div></td>
						</tr>
						<?	for ($f = 0;$f < count($linha); $f++) {	
							if ($linha[$f][tipo] == "A") { ?>		
						<tr class="tr1_alt">
							<td class="cells"><?= $linha[$f]["numero"] ?></td>
							<td class="cells">
								<div class="trip" id="div2">
								<strong><?= nomeComp($linha[$f]["piloto"]) ?></strong><br> 
								<? if (strlen($linha[$f]["navegador"]) > 0) echo '<strong>'.nomeComp($linha[$f]["navegador"]).'</strong><br>'; ?>
								<? if (strlen($linha[$f]["navegador2"]) > 0) echo '<strong>'.nomeComp($linha[$f]["navegador2"]).'</strong><br>'; ?>
								<?= $linha[$f]["modelo"]; ?><br> 
								</div>
							</td>
							<td class="cells">SS<?= $linha[$f]["especial"] ?></td> 
							<td class="cells"><div class="trip"><?= $linha[$f]["motivo"] ?></div></td>
						</tr>
						<?
							}
						}
						?>
		  			</table>    
					<p><span class="style2"><br><br></span></p>
				</td>
			</tr>
			<tr bgcolor="#CC9900">
				<td height="3" colspan="2"></td>
			</tr>
		</table>
	</body>
</html>