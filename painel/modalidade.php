<?
if (isset($_POST["cmd"]))
{
	$nome = $_POST["nome"];
	$descricao = $_POST["descricao"];
	$codigo = $_POST["codigo"];
	$id = $_POST["id"];
	switch (strtoupper($_POST["cmd"])) 
	{
		case "ATUALIZAR":
			$alert = "alert('ERRO:\\n\\nFalha ao atualizar campo')";
			$sql =  "UPDATE t10_modalidade SET c10_nome = '".$nome[$id]."'";
			$sql .= ", c10_descricao = '".$descricao[$id]."'";
			$sql .= " WHERE c10_codigo = ".$id;
			break;
		case "ADICIONAR":
			$alert = "alert('ERRO:\\n\\nFalha ao adicionar campo')";
			$sql = "INSERT INTO t10_modalidade (c10_codigo, c10_nome, c10_descricao) values ('".$codigo[$id]."','".$nome[$id]."','".$descricao[$id]."')";
			break;
		case "REMOVER":
			$alert = "alert('ERRO:\\n\\nFalha ao remover campo')";
			$sql = "DELETE FROM t10_modalidade WHERE c10_codigo = ".$id;
			break;
	}
	//echo $sql.'<br><br>';
	if ($obj_controle->executa($sql)) {
	  $alert = "null";
	}
}
?>
<form name="comando" method="post">
	<table cellpadding="5" cellspacing="5">
	<tr class="linhas">
			<td colspan="4">
				<p>Use o formul&aacute;rio abaixo para adicionar novo registro:</p>
			</td>
		</tr>
		<tr class="linhas">	
			<td>Codigo</td>
			<td>Sigla</td>    
			<td>Descri��o</td>
			<td></td>
		</tr>
		<tr class="linhas">  	
			<td><input type="text" name="codigo[<?= $ultimo_id + 1 ?>]" size="3" value="" /></td>
			<td><input type="text" name="nome[<?= $ultimo_id + 1 ?>]" size="10" value="" /></td>
			<td><input type="text" name="descricao[<?= $ultimo_id + 1 ?>]" size="30" value="" /></td>
			<td valign="bottom">
				<a href="#" onclick="enviaComandoFrame('adicionar', <?= $ultimo_id + 1 ?>)"><img src="imagens/inserir.gif" border="0" alt="inserir" /></a>
			</td>
		</tr>
		<tr class="linhas"></tr>
		<tr class="linhas"></tr>
		<tr class="linhas"></tr>
<?
$obj_res = $obj_controle->executa("SELECT * FROM t10_modalidade ORDER BY c10_codigo", true);
while ($vet_linha = $obj_res->getLinha("assoc"))
{
?>
		<tr class="linhas">  	
			<td><?= $vet_linha["c10_codigo"] ?></td>
			<td><input type="text" name="nome[<?= $vet_linha["c10_codigo"] ?>]" size="10" value="<?= $vet_linha["c10_nome"] ?>" /></td>
			<td><input type="text" name="descricao[<?= $vet_linha["c10_codigo"] ?>]" size="30" value="<?= $vet_linha["C10_descricao"] ?>" /></td>
			<td valign="bottom">
				<a href="#" onclick="enviaComandoFrame('atualizar', <?= $vet_linha["c10_codigo"] ?>)"><img src="imagens/botao_atualizar.gif" border="0" alt="atualizar" /></a>
			</td>
		</tr>
<?
	$ultimo_id = $vet_linha["c10_codigo"];
}
?>
	</table>
	<input type="hidden" name="id" />
	<input type="hidden" name="cmd" />
	<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>