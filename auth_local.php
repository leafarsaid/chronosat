<?

//
session_start();

set_time_limit(0);

//
header("Content-type: text/html; charset=ISO-8859-1",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

//
require_once"util/gerador_linhas.php";
require_once"util/database/include/config_bd.inc.php";
require_once"util/database/class/ControleBDFactory.class.php";
$obj_ctrl=ControleBDFactory::getControlador(DB_DRIVER);

if ($_GET['sair'] && !$_POST['login']) {
	session_destroy();
	$_SESSION['logado']=null;
}
if ($_POST['login']) {
	
	$_SESSION['nivel']=0;
	$_SESSION['usuario']=$_POST['login'];
	$_SESSION['usuario_sigla']=strtoupper(substr($_POST['login'],0,2));
}
if (true)
{
	$_SESSION['logado']=$_SESSION['nivel'];
	exit("<script>document.location=\"".$_REQUEST['uri']."\"</script>");
}
else {
	$_SESSION['logado']=null;
	if ($_POST['login']) echo "<h1 align='center' style='color:white;'>Login ou senha inválidos.</h1>";
	//echo $sql;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link href="css/chronosat.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
</head>
<body bgcolor="black">
<center>
<form method="post">
<br />
<br />
<br />
<br />
<img src="logo-site_b.png" /><br />
<br />
<br />
<br />
<br />
<span class="style1"><strong>Sistema de Apura&ccedil;&atilde;o do Rally de Velocidade</strong><br />
<br />
Login<br>
<input type="text" name="login" />
<br>
<br>
Senha</span><br>
<input type="password" name="senha" /><br><br>
<input type="hidden" name="uri" value="<?= $_REQUEST['uri'] ?>" />
<input type="submit" />
</form>
</center>

</body>
</html>