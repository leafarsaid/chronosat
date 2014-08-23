<?

session_start();

set_time_limit(0);

header("Content-type: text/html; charset=ISO-8859-1",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

require_once "../util/database/include/config_bd.inc.php";
require_once"../util/database/class/ControleBDFactory.class.php";
$obj_controle=ControleBDFactory::getControlador(DB_DRIVER);

$bt=(int)$_REQUEST["bt"];
//
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">	
		<title>Painel de Cadastro - Chronosat</title>	
		<style type="text/css">	
			.tabelas_resultados {
				font-size: 15px;
				font-family: Arial, Helvetica, sans-serif;
				color: #333333;
				background-color: #eeeeee;
				text-align: center;
				display: table-row-group;
				border: 5px solid #ffffff;
			}
			.linhas {
				border: 1px solid #000000;
				font-size: 15px;
				font-family: Arial, Helvetica, sans-serif;
				color: #333333;
				background-color: #eeeeee;
				text-align: center;
			}
			.botao {
				font-family:Arial, Helvetica, sans-serif;
				size: 20px;
				font-weight: bolder;
				cursor: pointer;
			}
		</style>
		<script language="javascript">
			function enviaComando(cmd,id) {
				document.comando.id.value=id;
				document.comando.cmd.value=cmd;
				document.comando.submit();
			}
		
			function enviaComandoFrame(cmd,id) {
				document.comando.id.value=id;
				document.comando.cmd.value=cmd;
				document.comando.submit();
			}
		</script>
	</head>

	<body>
		<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td width="242" align="center" valign="middle"><img src="../imagens/logo-site.png" width="180" height="66" /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="left" valign="top"><?include "menu.php"?></td>
				<td align="left" valign="top">
				<?
					switch($bt){
						case 1: include "montadora.php"; break;
						case 2: include "modelo.php"; break;
						case 3: include "categoria.php"; break;
						case 4: include"modalidade.php"; break;
						case 5: include"trecho.php"; break;
						case 6: include"atribtrecho.php"; break;
						case 7: include"tripulante.php"; break;
						case 8: include"veiculo.php"; break;
						case 9: include"penalidade.php"; break;			
						case 10: include"limpa_tempos.php"; break;					
						case 11: include"senhas.php"; break;
						case 12: include"import.php"; break;
						case 13: include"ocorrencia.php"; break;
						case 14: include"import_comp.php"; break;
					}
				?>
				</td>
			</tr>
		</table>
		<iframe name="oculto" width="1" height="1" frameborder="0"></iframe>
	</body>
</html>