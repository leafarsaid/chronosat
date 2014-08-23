<?
if (isset($_POST["cmd"]))
{
	$codigo = $_POST["codigo"];
	$nome = $_POST["nome"];
	$patrocinio = $_POST["patrocinio"];
	$equipe = $_POST["equipe"];
	$modelo = $_POST["modelo"];
	$origem = $_POST["origem"];
	$id = $_POST["id"];
	switch (strtoupper($_POST["cmd"])) 
	{
		case "ATUALIZAR":
			$alert = "alert('ERRO:\\n\\nFalha ao atualizar campo')";
			$sql = "UPDATE t04_tripulante SET c04_nome = '".$nome[$id]."', c04_patrocinio = '".$patrocinio[$id]."', c04_equipe = '".$equipe[$id]."', c04_origem = '".$origem[$id]."', c04_modelo = '".$modelo[$id]."' WHERE c04_codigo = ".$id;
			break;
		case "ADICIONAR":
			$alert = "alert('ERRO:\\n\\nFalha ao adicionar campo')";
			$sql = "INSERT INTO t04_tripulante (c04_codigo, c04_nome,c04_patrocinio,c04_equipe,c04_origem,c04_modelo) values ('".$codigo[$id]."','".$nome[$id]."','".$patrocinio[$id]."','".$equipe[$id]."','".$origem[$id]."','".$modelo[$id]."')";
			break;
		case "REMOVER":
			$alert = "alert('ERRO:\\n\\nFalha ao remover campo')";
			$sql = "DELETE FROM t04_tripulante WHERE c04_codigo = ".$id;
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
			<td colspan="7">
				<p>Use o formul&aacute;rio abaixo para adicionar novo registro:</p>
			</td>
		</tr>
		<tr class="linhas">	
			<td>Numeral</td>
			<td>Nome</td>    
			<td>Equipe</td>
			<td>Modelo</td>
			<td>Origem</td>
			<td>Patrocínio</td>
			<td></td>
		</tr>
		<tr class="linhas">  	
			<td><input type="text" name="codigo[<?= $ultimo_id + 1 ?>]" size="3" value="" /></td>
			<td><input type="text" name="nome[<?= $ultimo_id + 1 ?>]" size="30" value="" /></td>
			<td><input type="text" name="equipe[<?= $ultimo_id + 1 ?>]" size="30" value="" /></td>
			<td><input type="text" name="modelo[<?= $ultimo_id + 1 ?>]" size="15" value="" /></td>
			<td><input type="text" name="origem[<?= $ultimo_id + 1 ?>]" size="8" value="" /></td>
			<td><input type="text" name="patrocinio[<?= $ultimo_id + 1 ?>]" size="30" value="" /></td>
			<td valign="bottom">
				<a href="#" onclick="enviaComandoFrame('adicionar', <?= $ultimo_id + 1 ?>)"><img src="imagens/inserir.gif" border="0" alt="inserir" /></a>
			</td>
		</tr>
		<tr class="linhas"></tr>
		<tr class="linhas"></tr>
		<tr class="linhas"></tr>
<?
$sql = "SELECT * FROM t04_tripulante ORDER BY C04_CODIGO,c04_nome";
$obj_res = $obj_controle->executa($sql, true);
while ($vet_linha = $obj_res->getLinha("assoc")) 
{
?>
		<tr class="linhas">  	
			<td><?= $vet_linha["c04_codigo"] ?></td>
			<td><input type="text" name="nome[<?= $vet_linha["c04_codigo"] ?>]" size="30" value="<?= $vet_linha["c04_nome"] ?>" /></td>
			<td><input type="text" name="equipe[<?= $vet_linha["c04_codigo"] ?>]" size="30" value="<?= $vet_linha["c04_equipe"] ?>" /></td>
			<td><input type="text" name="modelo[<?= $vet_linha["c04_codigo"] ?>]" size="15" value="<?= $vet_linha["c04_modelo"] ?>" /></td>
			<td><input type="text" name="origem[<?= $vet_linha["c04_codigo"] ?>]" size="8" value="<?= $vet_linha["c04_origem"] ?>" /></td>
			<td><input type="text" name="patrocinio[<?= $vet_linha["c04_codigo"] ?>]" size="30" value="<?= $vet_linha["c04_patrocinio"] ?>" /></td>
			<td valign="bottom">
				<a href="#" onclick="enviaComandoFrame('atualizar', <?= $vet_linha["c04_codigo"] ?>)"><img src="imagens/botao_atualizar.gif" border="0" alt="atualizar" /></a>
				<a href="#" onclick="if (confirm('Tem certeza que deseja remover o tripulante?')) enviaComandoFrame('remover', <?= $vet_linha["c04_codigo"] ?>);"><img src="imagens/remover.gif" border="0" alt="remover" /></a>
			</td>
		</tr>
<?
	$ultimo_id = $vet_linha["c04_codigo"];
}
?>
	</table>
	<input type="hidden" name="id" />
	<input type="hidden" name="cmd" />
	<input type="hidden" name="pag" value="<?=$pag?>" />
	<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>