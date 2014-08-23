<?
if (isset($_POST["cmd"]))
{
	$numero = $_POST["numero"];
	$especial = $_POST["especial"];
	$motivo = $_POST["motivo"];
	$prova = $_POST["prova"];
	$tipo = $_POST["tipo"];
	$tempo = $_POST["tempo"];
	$id = $_POST["id"];
	switch (strtoupper($_POST["cmd"])) 
	{
		case "ATUALIZAR":
			$alert = "alert('ERRO:\\n\\nFalha ao atualizar campo')";
			$sql = "UPDATE t33_ocorrencias SET ";
			$sql .= "c03_codigo = '".$numero[$id]."'";
			$sql .= ", c33_ss = '".$especial[$id]."'";
			$sql .= ", c33_motivo = '".$motivo[$id]."'";
			$sql .= " WHERE c33_codigo = ".$id;
			break;
		case "ADICIONAR":
			$alert = "alert('ERRO:\\n\\nFalha ao adicionar campo')";
			$sql = "INSERT INTO t33_ocorrencias (c03_codigo, c33_ss, c33_motivo) values (";
			$sql .= "'".$numero[$id]."'";
			$sql .= ",'".$especial[$id]."'";
			$sql .= ",'".$motivo[$id]."'";
			$sql .= ")";
			break;
		case "REMOVER":
			$alert = "alert('ERRO:\\n\\nFalha ao remover campo')";
			$sql = "DELETE FROM t33_ocorrencias WHERE c33_codigo = ".$id;
			break;
	}
	if ($obj_controle->executa($sql)) {
	  $alert = "null";
	 }
}
?>

<form name="comando" method="post">
	<table cellpadding="5" cellspacing="5">
		<tr class="linhas">
			<td colspan="5">
				<p>Use o formul&aacute;rio abaixo para adicionar novo registro:</p>
			</td>
		</tr>
		<tr class="linhas">	
			<td>Especial</td>    
			<td>Numero do Carro</td>
			<td></td>
			<td>Motivo</td>
			<td></td>
		</tr>
		<tr class="linhas">  	
			<td><input type="text" name="especial[<?= $ultimo_id + 1 ?>]" size="3" value="" /></td>
			<td><input type="text" name="numero[<?= $ultimo_id + 1 ?>]" size="3" value="" /></td>
			<td></td> 
			<td><input type="text" name="motivo[<?= $ultimo_id + 1 ?>]" size="60" value="" /></td>
			<td valign="bottom">
				<a href="#" onclick="enviaComandoFrame('adicionar', <?= $ultimo_id + 1 ?>)"><img src="imagens/inserir.gif" border="0" alt="inserir" /></a>
			</td>
		</tr>
		<tr class="linhas"></tr>
		<tr class="linhas"></tr>
		<tr class="linhas"></tr>
<?
$sql = "SELECT c33_ss, c03_codigo, getTripulanteNome(c03_codigo) AS trip, c33_motivo FROM t33_ocorrencias ORDER BY c33_ss, c03_codigo";
$obj_res = $obj_controle->executa($sql, true);
while ($vet_linha = $obj_res->getLinha("assoc")) 
{
?>
		<tr class="linhas">
			<td><input type="text" name="especial[<?= $vet_linha["c33_codigo"] ?>]" size="3" value="<?= $vet_linha["c33_ss"] ?>" /></td>
			<td><?= $vet_linha["c03_codigo"] ?></td>
			<td><?= $vet_linha["trip"] ?></td>
			<td><input type="text" name="motivo[<?= $vet_linha["c33_codigo"] ?>]" size="60" value="<?= $vet_linha["c33_motivo"] ?>" /></td>
			<td>
				<a href="#" onclick="enviaComandoFrame('atualizar', <?= $vet_linha["c33_codigo"] ?>)"><img src="imagens/botao_atualizar.gif" border="0" alt="atualizar" /></a>
				<a href="#" onclick="if (confirm('Tem certeza que deseja remover o registro de abandono?')) enviaComandoFrame('remover', <?= $vet_linha["c33_codigo"] ?>);"><img src="imagens/remover.gif" border="0" alt="remover" /></a>
			</td>
		</tr>
<? 
	$ultimo_id = $vet_linha["c33_codigo"];
}
?>
	</table>

	<input type="hidden" name="id" />
	<input type="hidden" name="cmd" />
	<input type="hidden" name="pag" value="<?=$pag?>" />
	<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>