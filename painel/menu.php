<?
$db = $_REQUEST['db'];

//-----------------------
//*
function botao($id, $label) {	
	global $bt;		
	global $db;	
	$cor = ($id == $bt) ? "0066FF" : "99CCFF";	
	$retorno = sprintf("<tr class=\"botao\">\n<td width=\"232\" align=\"center\" valign=\"middle\" bgcolor=\"#$cor\" onClick=\"location='?db=%s&bt=%s'\" onMouseOver=\"this.bgColor='#0066FF'\" onMouseOut=\"this.bgColor='#$cor'\"><span>%s</span></td>\n</tr>\n\n", $db, $id, $label );
	return $retorno;
}

//-----------------------
//*
function botao2($id, $label) {	
	global $bt;	
	$cor = ($id==$bt) ? "0066FF" : "99CCFF";	
	$retorno = sprintf("<tr class=\"botao\">\n<td width=\"232\" align=\"center\" valign=\"middle\" bgcolor=\"#$cor\" ><span>%2\$s</span></td>\n</tr>\n\n", $id, $label);	
	return $retorno;
}
?>

<table width="242" border="0" cellspacing="5" cellpadding="5">
<? 
	echo botao("3", "Categorias");
	echo botao("4", "Modalidades");
	echo botao("5", "Trechos");
	echo botao("6", "Atributos dos Trechos");
	echo botao("7", "Editar Tripulantes");
	echo botao("8", "Editar Ve&iacute;culos");
	echo botao("9", "Bonus/Penalidades");	
	echo botao("12", "Inserir Tempos de CSV");	
	echo botao("10", "Limpar tempos");	
	if ($_SESSION['logado'] < 4) echo botao("11", "Alterar Senha");	
    echo botao("13", "Abandonos");	
    echo botao("14", "Importar competidores");	
?>
</table>
Usuário: <?= $_SESSION['usuario'] ?> (<?= $_SESSION[usuario_sigla] ?>)<br />
Nível: <?= $_SESSION['nivel'] ?> 