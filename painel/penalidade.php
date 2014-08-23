<script>
function formatar(src, mask){
  var i = src.value.length;
  var saida = mask.substring(0,1);
  var texto = mask.substring(i);
if (texto.substring(0,1) != saida)
  {
	src.value += texto.substring(0,1);
  }
}
</script>
<?

if ($_REQUEST['trecho']==0) $trecho = 0;
elseif (!$_REQUEST['trecho']) $trecho = 1;
else  $trecho = $_REQUEST['trecho'];
	
if (isset($_POST["cmd"]))
{
	$numero = $_POST["numero"];
	$motivo = $_POST["motivo"];
	$tempo = $_POST["tempo"];
	$tipo = $_POST["tipo"];
	$id = $_POST["id"];
	
	$valor_tempo = substr($tempo[$id],0,2)*3600;
	$valor_tempo += substr($tempo[$id],3,2)*60;
	$valor_tempo += substr($tempo[$id],6,2);
	
	switch (strtoupper($_POST["cmd"])) 
	{
		case "ADICIONAR":
			$alert = "alert('ERRO:\\n\\nFalha ao adicionar campo')";
			$sql = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c03_codigo, c02_codigo, c01_obs) values (";
			$sql .= "'".$valor_tempo."'";
			$sql .= ",'".$tipo[$id]."'"; ///
			$sql .= ",'O'";
			$sql .= ",getCodigoVeiculo(".$numero[$id].")";
			$sql .= ",'".$trecho."'";
			$sql .= ",'".$motivo[$id]."'";
			$sql .= ")";
			break;
			
		case "ATUALIZAR":
			$alert = "alert('ERRO:\\n\\nFalha ao atualizar campo')";
			$sql = "UPDATE t01_tempos SET ";
			$sql .= "c01_valor = '".$valor_tempo."'";
			$sql .= ",c01_tipo = '".$tipo[$id]."'";
			$sql .= ",c01_obs = '".$motivo[$id]."'";
			$sql .= " WHERE c01_codigo = ".$id;
			break;
		
		case "REMOVER":
			$alert = "alert('ERRO:\\n\\nFalha ao remover campo')";
			$sql = "DELETE FROM t01_tempos WHERE c01_codigo = ".$id;
			break;
	}
	//
	echo $sql."<br>";
	if ($obj_controle->executa($sql)) {
	  $alert = "null";
	}
}
?>

<style>
a {
	text-decoration:none;	
}
</style>

<a href="?trecho=0&db=<?= $_REQUEST['db'] ?>&bt=<?= $_REQUEST['bt'] ?>"><font color="<?= ($trecho==0) ? "red" : "grey" ?>">Prólogo</font></a>
 | <a href="?trecho=1&db=<?= $_REQUEST['db'] ?>&bt=<?= $_REQUEST['bt'] ?>"><font color="<?= ($trecho==1) ? "red" : "grey" ?>">SS1</font></a>
 | <a href="?trecho=2&db=<?= $_REQUEST['db'] ?>&bt=<?= $_REQUEST['bt'] ?>"><font color="<?= ($trecho==2) ? "red" : "grey" ?>">SS2</font></a>
 | <a href="?trecho=3&db=<?= $_REQUEST['db'] ?>&bt=<?= $_REQUEST['bt'] ?>"><font color="<?= ($trecho==3) ? "red" : "grey" ?>">SS3</font></a>
 | <a href="?trecho=4&db=<?= $_REQUEST['db'] ?>&bt=<?= $_REQUEST['bt'] ?>"><font color="<?= ($trecho==4) ? "red" : "grey" ?>">SS4</font></a>
 | <a href="?trecho=5&db=<?= $_REQUEST['db'] ?>&bt=<?= $_REQUEST['bt'] ?>"><font color="<?= ($trecho==5) ? "red" : "grey" ?>">SS5</font></a>
 | <a href="?trecho=6&db=<?= $_REQUEST['db'] ?>&bt=<?= $_REQUEST['bt'] ?>"><font color="<?= ($trecho==6) ? "red" : "grey" ?>">SS6</font></a>
 | <a href="?trecho=7&db=<?= $_REQUEST['db'] ?>&bt=<?= $_REQUEST['bt'] ?>"><font color="<?= ($trecho==7) ? "red" : "grey" ?>">SS7</font></a>
 | <a href="?trecho=8&db=<?= $_REQUEST['db'] ?>&bt=<?= $_REQUEST['bt'] ?>"><font color="<?= ($trecho==8) ? "red" : "grey" ?>">SS8</font></a>
 | <a href="?trecho=9&db=<?= $_REQUEST['db'] ?>&bt=<?= $_REQUEST['bt'] ?>"><font color="<?= ($trecho==9) ? "red" : "grey" ?>">SS9</font></a>
 | <a href="?trecho=10&db=<?= $_REQUEST['db'] ?>&bt=<?= $_REQUEST['bt'] ?>"><font color="<?= ($trecho==10) ? "red" : "grey" ?>">SS10</font></a>
 | <a href="?trecho=11&db=<?= $_REQUEST['db'] ?>&bt=<?= $_REQUEST['bt'] ?>"><font color="<?= ($trecho==11) ? "red" : "grey" ?>">SS11</font></a>
 | <a href="?trecho=12&db=<?= $_REQUEST['db'] ?>&bt=<?= $_REQUEST['bt'] ?>"><font color="<?= ($trecho==12) ? "red" : "grey" ?>">SS12</font></a>
 | <a href="?trecho=13&db=<?= $_REQUEST['db'] ?>&bt=<?= $_REQUEST['bt'] ?>"><font color="<?= ($trecho==13) ? "red" : "grey" ?>">SS13</font></a>

<form name="comando" method="post">
	<table cellpadding="5" cellspacing="5">
		<tr class="linhas">
			<td colspan="6">
				<p>Use o formul&aacute;rio abaixo para adicionar novo registro: <input type="button" value="Atualizar Formulário" onclick="document.comando.submit();" /></p>
			</td>
		</tr>
		<tr class="linhas">	
			<td>Numeral</td>  
			<td></td>
			<td>Tipo</td>  
			<td>Motivo</td>
			<td>Tempo</td>
			<td></td>
		</tr> 
		<tr class="linhas">  	
			<td><input type="text" name="numero[<?= $ultimo_id + 1 ?>]" size="3" value="" /></td>
			<td></td>
			<td>
				<select name="tipo[<?= $ultimo_id + 1 ?>]">
					<option value="A">BON</option>
					<option value="P">PEN</option>
				</select>
			</td>
			<td><input type="text" name="motivo[<?= $ultimo_id + 1 ?>]" size="60" value="" /></td>
			<td><input type="text" name="tempo[<?= $ultimo_id + 1 ?>]" size="8" maxlength="8" value="" onKeypress="formatar(this, '##:##:##');" /></td>
			<td valign="bottom">
				<a href="#" onclick="enviaComandoFrame('adicionar', <?= $ultimo_id + 1 ?>)"><img src="imagens/inserir.gif" border="0" alt="inserir" /></a>
			</td>
		</tr>
		<tr class="linhas"></tr>
		<tr class="linhas"></tr>
		<tr class="linhas"></tr>

<?
$sql = "SELECT c01_codigo, c03_codigo, c01_obs, castTempo(c01_valor) AS c01_valor, c01_tipo, getTripulanteNome(c03_codigo) AS trip FROM t01_tempos WHERE (c01_tipo='P' OR c01_tipo='PT' OR c01_tipo='A') AND c02_codigo=$trecho ORDER BY c03_codigo";
$obj_res = $obj_controle->executa($sql, true);

while ($vet_linha = $obj_res->getLinha("assoc")) 
{
?>
		<tr class="linhas">
			<td><?= $vet_linha["c03_codigo"] ?></td>
			<td><?= $vet_linha["trip"] ?></td>
			<td>
				<select name="tipo[<?= $vet_linha["c01_codigo"] ?>]">
					<option value="A"<?= ($vet_linha["c01_tipo"]=="A") ? " selected" : "" ?>>BON</option>
					<option value="P"<?= ($vet_linha["c01_tipo"]=="P") ? " selected" : "" ?>>PEN</option>
				</select>
			</td>
			<td><input type="text" name="motivo[<?= $vet_linha["c01_codigo"] ?>]" size="60" value="<?= $vet_linha["c01_obs"] ?>" /></td>
			<td><input type="text" name="tempo[<?= $vet_linha["c01_codigo"] ?>]" size="8" value="<?= $vet_linha["c01_valor"] ?>" /></td>
			<td>
				<a href="#" onclick="enviaComandoFrame('atualizar', <?= $vet_linha["c01_codigo"] ?>)"><img src="imagens/botao_atualizar.gif" border="0" alt="atualizar" />
				<a href="#" onclick="if (confirm('Tem certeza que deseja remover o registro?')) enviaComandoFrame('remover', <?= $vet_linha["c01_codigo"] ?>);"><img src="imagens/remover.gif" border="0" alt="remover" /></a>
			</td>
		</tr>
<?
$ultimo_id = $vet_linha["c01_codigo"];
}
?>
	</table>

	<input type="hidden" name="id" />
	<input type="hidden" name="cmd" />
	<input type="hidden" name="pag" value="<?=$pag?>" />
	<input type="hidden" name="trecho" value="<?=$trecho?>" />
	<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>