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


</p>

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td width="327" valign="bottom" class="style2">CBR 2013 - 3a Prova - Etapas 5 e 6</td>

    <td align="right" valign="bottom" class="style2">Resultados Extra-Oficiais</td>
	
	
	
	

	
  </tr>

  <tr bgcolor="#CC9900">

    <td height="3" colspan="2"></td>

  </tr>


 
<tr><td colspan="2"><br />
       
	<!--span class="style6"><a href="resultado_regularidade.pdf">Copa Peugeot - Regularidade - Resultados</a></span><br /><br />
    <span class="style6"><a href="classificacao_blumenau.pdf">Copa Peugeot - Velocidade - Ranking do Campeonato até esta etapa</a></span><br /><br /><br /-->

	<span class="style6"><a href="index.php">Resultados completos - Clique aqui</a></span><br /><br />
	
	<span class="style4">Resultados simplificados para celular</a></span><br/>
	
	
</tr>
      
        <td width="315" valign="top">

		
		
		<br>

        <p><span class="style4"><a href="geral.php?prova=1"> Prova 1</a></span></p>

        <p>

        
        <span class="style6"><a href="ss_geral_m.php?trecho=1&prova=1">SS1</a></span><br />

        <span class="style6"><a href="ss_geral_m.php?trecho=2&prova=1">SS2</a></span><br />

        <span class="style6"><a href="ss_geral_m.php?trecho=3&prova=1">SS3</a></span><br />

        <span class="style6"><a href="ss_geral_m.php?trecho=4&prova=1">SS4</a></span><br />
		
        <span class="style6"><a href="ss_geral_m.php?trecho=5&prova=1">SS5</a></span><br />
		
        <span class="style6"><a href="ss_geral_m.php?trecho=6&prova=1">SS6</a></span><br />
		
        <span class="style6"><a href="ss_geral_m.php?trecho=7&prova=1">SS7</a></span>
        
        <td width="323" valign="top">

<br>

        <p><span class="style4"><a href="geral.php?prova=2">Prova 2</a></span></p>

        <p>

        

                <span class="style6"><a href="ss_geral_m.php?trecho=8&prova=2">SS8</a></span><br />

        <span class="style6"><a href="ss_geral_m.php?trecho=9&prova=2">SS9</a></span><br />

        <span class="style6"><a href="ss_geral_m.php?trecho=10&prova=2">SS10</a></span><br />
		
        <span class="style6"><a href="ss_geral_m.php?trecho=11&prova=2">SS11</a></span><br />
		
        <span class="style6"><a href="ss_geral_m.php?trecho=12&prova=2">SS12</a></span><br />
		
        <span class="style6"><a href="ss_geral_m.php?trecho=13&prova=2">SS13</a></span>

		
		<!--tr>
		<td colspan=2>
		<span class="style6"><a href="ordem1.pdf">Ordem de Largada</a></span><br />
		</td>
		</tr-->
  

  

  

  

         <tr>

        <td align="left" valign="top">

          	<br />

          	<span class="style6"><a href="largada_sabado.pdf">Ordem de Largada - Prova 1</a></span>

          <br />

            <span class="style6"><a href="ocorrencias.php?prova=1&tipo=A">Abandonos - Prova 1</a></span>

            <br />

          <span class="style6"><a href="ocorrencias.php?prova=1&tipo=P">Penalizações - Prova 1</a></span>
          <br /></td>

        <td align="left" valign="top">

          	<br />

          	<span class="style6"><a href="largada_domingo.pdf">Ordem de Largada - Prova 2</a></span>

        <br />

            <span class="style6"><a href="ocorrencias.php?prova=2&tipo=A">Abandonos - Prova 2</a></span>

            <br />

          <span class="style6"><a href="ocorrencias.php?prova=2&tipo=P">Penalizações - Prova 2</a></span></td>

  </tr>



<tr>

        <td colspan="2" align="left" valign="top">

          	<p style="margin-top: 0;">

  <!--span class="style6"><a href="geral.php"><br />

          	Resultados da etapa</a></span-->

  <br />

  <!--span class="style6"><a href="grafico.html">Gráfico</a></span><br>

<span class="style6"><a href="ss_geral.php?trecho=9">Super Prime</a></span-->

  <br />

  <!--span class="style6"><a href="">207 Super - Sábado e Domingo</a></span>

  <br />

  <span class="style6"><a href="">206 Master - Sábado e Domingo</a></span-->

  <br /></td>

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

