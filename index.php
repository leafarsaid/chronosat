<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<?

$trecho = $_GET["trecho"];

if (!$trecho) $trecho = 1;



function sel($text, $event, $nom) {



global $trecho;

$sel = "<form name=\"sel".$nom."\" method=\"get\"> ";

$sel .= " <select name=\"trecho\" id=\"trecho\" onchange=\"form.submit();\"> ";

//$sel .= " <select name=\"trecho\" id=\"trecho\" onchange=\"document.sel".$nom.".submit();\"> ";



//$sel = $text." <select name=\"trecho\" id=\"trecho\" onchange=\"document.location('".$event."+this.value');\"> ";



for ($i=1;$i<=3;$i++) {

     if ($i==$trecho) $txt = " selected";

     else $txt = "";

	

	  	if ($i==1)  $sel .= "<option value=\"".$i."\" ".$txt.">SS".$i."</option>";

		if ($i==3)	$sel .= "<option value=\"3\" ".$txt.">SS2</option>";

}

$sel .= "</select> ".$text;

//$sel .= "<input type='hidden' name='campeonato' value='".$value."'> ";

$sel .= "</form> ";



return $sel;

}







?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title></title>

<style type="text/css">

<!--

body {

	background-image: url(imagens/fundo.jpg);

	background-repeat: no-repeat;

	margin-left: 0px;

	margin-top: 0px;

	margin-right: 0px;

	margin-bottom: 0px;

	background-position: center top;

}

a {

	color: #CC9900;

	text-decoration: none;

}

a:hover {

	color: #FFFFFF;

	text-decoration: underline;

}

.style2 {

	color: #CC9900;

	font-family: Arial, Helvetica, sans-serif;

}

.style4 {

        color: #CC9900;

        font-family: Arial, Helvetica, sans-serif;

        font-weight: bold;

        font-size: 18px;

}

.style6 {color: #CC9900; font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; }

-->

</style>

</head>



<body marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" topmargin="0" bgcolor="#000000">

<p align="right"><br />

</p>

<p align="right">&nbsp;</p>

<p align="right">&nbsp;</p>

<p align="center"><img src="imagens/tijucas-logo.png" /><br>

</p>

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td width="327" valign="bottom" class="style2">CBR 2014 - Tijucas/SC</td>

    <td align="right" valign="bottom" class="style2">Resultados Extra-Oficiais</td>
  </tr>

  <tr bgcolor="#CC9900">

    <td height="3" colspan="2"></td>
  </tr>

  
tr>
  <td>
    <p>&nbsp;</p>
    <p><span class="style6"><a href="geral.php">Resultados completos</a></span><br />
        <br />
        <span class="style6"><a href="geral.php?categoria=1">CBR 1</a></span><br />
        <span class="style6"><a href="geral.php?categoria=2">CBR 2</a></span><br />				
		<span class="style6"><a href="geral.php?categoria=3">CBR 3</a></span><br />
    <span class="style6"><a href="geral.php?categoria=4">Convidados</a></span>    </p></td>
  <td valign="top">
  

  

</tr>
      
        <td width="315" valign="top"><p><br />

          <span class="style6"><a href="ss_geral.php?trecho=1&prova=1">SS1</a></span><br />
          <span class="style6"><a href="ss_geral.php?trecho=2&prova=1">SS2</a></span><br />
          <span class="style6"><a href="ss_geral.php?trecho=3&prova=1">SS3</a></span><br />
          <span class="style6"><a href="ss_geral.php?trecho=4&prova=1">SS4</a></span><br />
          <span class="style6"><a href="ss_geral.php?trecho=5&prova=1">SS5</a></span><br />
          <span class="style6"><a href="ss_geral.php?trecho=6&prova=1">SS6</a></span></p>          </td>

  <td width="323" valign="top"><p><br />

        <span class="style6"><a href="ss_geral.php?trecho=7&prova=2">SS7</a></span><br />
        <span class="style6"><a href="ss_geral.php?trecho=8&prova=2">SS8</a></span><br />        </td>

  </tr>

  

  

  

  

         <tr>

        <td align="left" valign="top">

          	<br />

   	    <!--span class="style6"><a href="largada.pdf">Ordem de Largada </a></span><br /-->

            <span class="style6"><a href="largada_sabado.pdf">Ordem de Largada Sábado </a></span><br />
            <span class="style6"><a href=""> </a></span><br />
            <span class="style6"><a href="ocorrencias.php?prova=1&tipo=A">Abandonos </a></span><br />


        <td align="left" valign="top"><br />
            <span class="style6"><a href="largada_domingo.pdf">Ordem de Largada Domingo </a></span><br />
            <span class="style6"><a href=""> </a></span><br />
			<span class="style6"><a href="ocorrencias.php?prova=1&tipo=P">Penalizações </a></span><br /></td>
  </tr>





<tr>

  <td valign="top">&nbsp;</td>

  <td width="323" valign="top">&nbsp;</td>
</tr>

  <tr bgcolor="#CC9900">

    <td height="3" colspan="2"></td>
  </tr>
</table>

</p>

</body>

</html>

