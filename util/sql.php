<?
$col_status = ($_REQUEST['prova'] == 2) ? "c03_status2": "c03_status";
$col_categoria = ($_REQUEST['campeonato'] == "P") ? "c13_codigo2" : "c13_codigo";

/**
*
*
*/
function geraSqlGeral($int_ss_fim, $arr_ss, $int_id_cat, $int_id_mod, $mod, $classi, $nc, $desc) {
	global $col_status;
	global $col_categoria;
	$ss_max = 50;
	
	$str_sql = "SELECT ";
	$str_sql .= "DISTINCT c03_numero,";
	$str_sql .= "c03_codigo,";
	$str_sql .= "c10_codigo,";
	$str_sql .= "$col_categoria,";
	$str_sql .= "$col_status,";
	$str_sql .= "getCategoriaNome($col_categoria) AS categoria, ";
	$str_sql .= 'getModalidadeNome(c10_codigo) AS modalidade, ';
	$str_sql .= 'getTripulanteNome(c03_piloto) AS piloto_geral, ';
	$str_sql .= 'getTripulanteNome(c03_navegador) AS navegador_geral, ';
	$str_sql .= 'getTripulanteNome(c03_navegador2) AS navegador2_geral, ';
	$str_sql .= 'getEquipeNome(c03_piloto) AS equipe_geral, ';
	$str_sql .= 'getModeloNome(c03_piloto) AS modelo_geral, ';
	$str_sql .= "getTripulanteOrigem(c03_piloto) AS tripulacao_origem, ";
	$str_sql .= "getTripulanteOrigem(c03_piloto) AS piloto_origem, ";
	$str_sql .= "getTripulanteOrigem(c03_navegador) AS navegador_origem, ";

	//tempo de cada SS
	for ($f = 0; $f < count($arr_ss); $f++) {
		$str_sql .= "castTempo(calcTempoSemPena(c03_codigo,".$arr_ss[$f].",c10_codigo,6)) AS ss".$arr_ss[$f].", ";
	}

	//total de penais
	$str_sql .= "castTempo(0";
		for ($f = 0; $f < count($arr_ss); $f++)
			if ($arr_ss[$f] <= $ss_max) $str_sql .= "+calcPenalidade(c03_codigo,".$arr_ss[$f].", c10_codigo) ";
	$str_sql .= ") AS P_geral, ";
	
	//tempo total sem penais
	$str_sql .= "castTempo(0";
	for ($f = 0; $f < count($arr_ss); $f++)
		if ($arr_ss[$f]<=$ss_max) $str_sql .= "+calcTempo(c03_codigo,".$arr_ss[$f].",c10_codigo,6)-calcPenalidade(c03_codigo,".$arr_ss[$f].", c10_codigo)";
	$str_sql .= ") AS tempo_old, ";

	//tempo total 
	$str_sql .= "castTempo(";
	$str_sql .= "concat(substring_index(0";
	for ($f = 0; $f < count($arr_ss); $f++)
		if ($arr_ss[$f]<=$ss_max) $str_sql .= "+calcTempo(c03_codigo,".$arr_ss[$f].",c10_codigo,6)-calcPenalidade(c03_codigo,".$arr_ss[$f].", c10_codigo)";
	for ($f=0;$f<count($arr_ss);$f++)
		if ($arr_ss[$f]<=$ss_max) $str_sql .= "+IFNULL(substring_index(getTempo(c03_codigo,".$arr_ss[$f].",10),'.',1),0) ";
	$str_sql .= ",'.',2) ";
	$str_sql .= ") ";
	$str_sql .= ") AS tempo, ";

	//total de bonus
	$str_sql .= "castTempo(0";
	for ($f=0;$f<count($arr_ss);$f++)
		if ($arr_ss[$f] <= $ss_max) $str_sql .= "+IFNULL(getTempo(c03_codigo,".$arr_ss[$f].",10),0) ";
	$str_sql .= ") AS bonus_geral, ";

	//tempo total?
	$str_sql .= "castTempo(0";
	for ($f = 0; $f < count($arr_ss); $f++)
		if ($arr_ss[$f] <= $ss_max) $str_sql .= "+calcTempo(c03_codigo,".$arr_ss[$f].",c10_codigo,6) ";
	$str_sql .= ") AS total_geral, ";

	//??????????????????
	$str_sql .= "(0";
	for ($f = 0; $f < count($arr_ss); $f++)
		if ($arr_ss[$f] <= $ss_max) $str_sql .= "+IFNULL(calcTempo(c03_codigo,".$arr_ss[$f].",c10_codigo,6),999999) ";
	$str_sql .= ") AS total_num ";

	$str_sql .= "FROM ";
	$str_sql .= "t03_veiculo ";
	$str_sql .= "WHERE 1 ";
	$str_sql .= "AND ".$col_status."<>'O' ";
	
	///////////////////////////

	//consultar apenas os desclassificados?
	$str_sql .= ($desc == 0) ? "AND ".$col_status."<>'D' " : "AND ".$col_status."='D' ";
	
	//consultar apenas os Não Completados?
	$str_sql .= ($nc == 0) ? "AND ".$col_status."<>'NC' " : "AND ".$col_status."='NC' ";
	
	if ($desc != 1) {
		if ($classi == 1) {
			$str_sql .= "AND castTempo(0";
			for ($f = 0; $f < count($arr_ss); $f++) 
				if ($arr_ss[$f] <= $ss_max) $str_sql .= "+calcTempo(c03_codigo,".$arr_ss[$f].",c10_codigo,6) ";
			$str_sql .= ") != \"* * *\" ";
		}
		else {
			$str_sql .= "AND castTempo(0";
			for ($f=0;$f<count($arr_ss);$f++) {
				if ($arr_ss[$f]<=$ss_max) $str_sql .= "+calcTempo(c03_codigo,".$arr_ss[$f].",c10_codigo,6) ";
			}
			$str_sql .= ") = \"* * *\" ";
		}
	}
	
	///////////////////////////

	if($int_id_cat) $str_sql.="AND $col_categoria=$int_id_cat ";
	if($int_id_mod) $str_sql.="AND c10_codigo=$int_id_mod ";
	if($mod=="C") $str_sql.="AND (c10_codigo=1 OR c10_codigo=2) ";
	if($mod=="M") $str_sql.="AND (c10_codigo=3 OR c10_codigo=4) ";
	
	$str_sql.="ORDER BY total_num,";
	$str_sql.="c03_ordem,calcTFGeral(c03_codigo,c10_codigo,$int_ss_fim),";
	$str_sql.="c03_ordem,c03_numero";
	
	return  $str_sql;
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
*
*
*/
function geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod,  $classi, $nc, $desc, $cheg, $veic) {
	global $col_categoria;
	global $col_status;
	if (!$int_id_ss) $int_id_ss = 0;
	
	$ss_sql = 'SELECT ';
	$ss_sql .= "DISTINCT c03_numero,";
	$ss_sql .= "c03_codigo,";
	$ss_sql .= $col_status.",";
	$ss_sql .= 'getTrechoNome('.$int_id_ss.') AS nome_trecho, ';
	$ss_sql .= "getCategoriaNome($col_categoria) AS categoria, ";
	$ss_sql .= 'getModalidadeNome(c10_codigo) AS modalidade, ';
	$ss_sql .= 'getTripulanteNome(c03_piloto) AS piloto, ';
	$ss_sql .= 'getTripulanteNome(c03_navegador) AS navegador, ';
	$ss_sql .= 'getTripulanteNome(c03_navegador2) AS navegador2, ';
	$ss_sql .= 'getTripulanteOrigem(c03_piloto) AS tripulacao_origem, ';
	$ss_sql .= 'getModeloNome(c03_piloto) AS modelo, ';
	$ss_sql .= 'getEquipeNome(c03_piloto) AS equipe, ';
	$ss_sql .= 'getModalidadeNome(c10_codigo) AS modalidade, ';
	$ss_sql .= "penalizar($col_categoria,$int_id_ss,c10_codigo) AS forfete, ";
	$ss_sql .= "$col_categoria, ";
	$ss_sql .= 'c10_codigo, ';
	$ss_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',1)) AS L, ';
	$ss_sql .= 'getTempo(c03_codigo,'.$int_id_ss.',9) AS R, ';
	$ss_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',8)) AS CH, ';
	$ss_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',2)) AS I1, ';
	$ss_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',3)) AS I2, ';
	$ss_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',4)) AS I3, ';
	$ss_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',5)) AS I4, ';
	$ss_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',6)) AS C, ';
	$ss_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',10)) AS A, ';
	$ss_sql .= 'castTempo(calcPenalidade(c03_codigo,'.$int_id_ss.', c10_codigo)) AS P, ';
	$ss_sql .= "castTempo(calcTempo(c03_codigo,$int_id_ss,c10_codigo,6)) AS total, ";
	$ss_sql .= "calcTempo(c03_codigo,$int_id_ss,c10_codigo,6) AS total_num, ";
	$ss_sql .= "castTempo(IFNULL(calcTempo(c03_codigo,$int_id_ss,c10_codigo,6),0) + IFNULL(getTempo(c03_codigo,$int_id_ss,10),0) - IFNULL(calcPenalidade(c03_codigo,$int_id_ss, c10_codigo),0)) AS tempo, ";
	$ss_sql .= "(CASE WHEN (calcTempo(c03_codigo,$int_id_ss,c10_codigo,6) > 0) THEN calcTempo(c03_codigo,$int_id_ss,c10_codigo,6) ELSE 99999999999999 END) AS total_c, ";
	$ss_sql .= "castTempo(calcTempoGeral(c03_codigo,c10_codigo,$int_id_ss)) AS geral, ";
	$ss_sql .= "calcTempoGeral(c03_codigo,c10_codigo,$int_id_ss) AS geral_num, ";
	$ss_sql .= "(CASE WHEN (calcTempoGeral(c03_codigo,c10_codigo,$int_id_ss) > 0) THEN calcTempoGeral(c03_codigo,c10_codigo,$int_id_ss) ELSE 99999999999999 END) AS geral_c, ";
	$ss_sql .= "(SELECT c02_distancia FROM t02_trecho where c02_codigo=".$int_id_ss.") / ((calcTempo(c03_codigo,$int_id_ss,c10_codigo,6))/3600) AS velocidade, ";

	///////////// dif -- pega o tempo do primeiro e diminui o tempo do atual
	$ss_sql .= "castTempo((SELECT calcTempo(c03_codigo,".$int_id_ss.",c10_codigo,6) AS total_cat FROM t03_veiculo WHERE 1 ";
	$ss_sql .= "AND calcTempo(c03_codigo,".$int_id_ss.",c10_codigo,6)!=1 ";
	if($int_id_cat) $ss_sql .= "AND $col_categoria=$int_id_cat ";
	if($int_id_mod) $ss_sql .= "AND c10_codigo=$int_id_mod ";
	if($campeonato) $ss_sql.="AND getModalidadeNome(c10_codigo) LIKE '%".$campeonato."%' ";
	$ss_sql .= "ORDER BY total_cat LIMIT 1) - calcTempo(c03_codigo,$int_id_ss,c10_codigo,6)) AS dif1 ";
	///////////// dif

	$ss_sql.="FROM ";
	$ss_sql.="t03_veiculo ";
	$ss_sql .= "WHERE 1 ";
	if ($veic!="") $ss_sql .= "AND c03_codigo=".$veic." ";

	// caso tenha chegada
	if ($cheg == 0) {
		$ss_sql .= "AND castTempo(getTempo(c03_codigo,$int_id_ss,6)) = \"* * *\" ";
	} else {
		$ss_sql .= "AND castTempo(getTempo(c03_codigo,$int_id_ss,6)) <> \"* * *\" ";
	}
	
	// caso desc
	if ($desc==0) {
		$ss_sql .= "AND ".$col_status."<>'D' ";
	} else {
		$ss_sql .= "AND ".$col_status."='D' ";
	}
	
	// caso nc
	if ($nc==0) {
		$ss_sql .= "AND ".$col_status."<>'NC' ";
	} else {
		$ss_sql .= "AND ".$col_status."='NC' ";
	}

	$ss_sql .= "AND ".$col_status."<>'O' ";
	if($int_id_cat) $ss_sql.="AND $col_categoria=$int_id_cat ";
	if($int_id_mod) $ss_sql.="AND c10_codigo=$int_id_mod ";
	if($mod=="C") $ss_sql.="AND (c10_codigo=1 OR c10_codigo=2) ";
	if($mod=="M") $ss_sql.="AND (c10_codigo=3 OR c10_codigo=4) ";

	if ($classi==1) {
		$ss_sql .= 'AND castTempo(calcTempo(c03_codigo,'.$int_id_ss.',c10_codigo,6)) != "* * *" ';
	}
	else {
		$ss_sql .= 'AND castTempo(calcTempo(c03_codigo,'.$int_id_ss.',c10_codigo,6)) = "* * *" ';
	}

	$ss_sql .= 'ORDER BY total_c,c03_ordem,c03_codigo,geral_c,geral,total,L';

	return $ss_sql;
}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
*
*
*/
function geraSqlPenal($int_id_ss, $int_id_cat, $int_id_mod) {
	
	if ($int_id_ss)  $w_penal.=" AND (t.c02_codigo=$int_id_ss)";
	if ($int_id_cat) $w_penal.=" AND (v.c13_codigo=$int_id_cat)";
	if ($int_id_mod) $w_penal.=" AND (v.c10_codigo=$int_id_mod)";

	$ss_penal = "SELECT
	 DISTINCT v.c03_numero
	 ,v.c03_codigo
	 ,getTripulanteNome(v.c03_piloto) AS piloto
	 ,getTripulanteNome(v.c03_navegador) AS navegador
	 ,getTripulanteNome(v.c03_navegador2) AS navegador2
	 ,castTempo(t.c01_valor) AS P
	 ,t.c02_codigo AS trecho
	 ,t.c01_tipo AS tipo
	 ,getModeloNome(v.c03_piloto) AS modelo
	 ,t.c01_obs AS motivo
	 FROM t03_veiculo as v, t01_tempos AS t 
	 WHERE (t.c03_codigo=v.c03_codigo)
	 $w_penal
	 AND (t.c01_tipo='P' OR t.c01_tipo='PT')
	 AND v.c03_status <> 'O' 
	 ORDER BY v.c03_codigo, t.c02_codigo";
	return $ss_penal;
}

/*
*
*
*/
function geraSqlTempo($veiculo, $trecho, $tipo) {
	$ss_sql = 'SELECT ';
	$ss_sql .= "DISTINCT c01_valor ";
	$ss_sql .= "FROM t01_tempos ";
	$ss_sql .= "WHERE c02_codigo = ".$trecho." ";
	$ss_sql .= "AND c01_tipo = '".$tipo."' ";
	$ss_sql .= "AND c03_codigo = ".$veiculo." ";
	$ss_sql .= "ORDER BY c01_valor ";
	return $ss_sql;
}

/*
*
*
*/
function geraSqlTripulante($veiculo, $tipo) {
	$ss_sql = 'SELECT ';
	if ($tipo=='P') $ss_sql .= "getTripulanteNome(c03_piloto) AS valor ";
	if ($tipo=='N') $ss_sql .= "getTripulanteNome(c03_navegador) AS valor ";
	$ss_sql .= "FROM t03_veiculo ";
	$ss_sql .= "WHERE c03_codigo = ".$veiculo." ";
	return $ss_sql;
} 

/*
*
*
*/
function geraSqlModelo($veiculo) {
	$ss_sql = 'SELECT ';
	$ss_sql .= "getModelo(c21_codigo) AS valor ";
	$ss_sql .= "FROM t03_veiculo ";
	$ss_sql .= "WHERE c03_codigo = ".$veiculo." ";
	return $ss_sql;
} 

/*
*
*
*/
function geraSqlCategoria($veiculo) {
	$ss_sql = 'SELECT ';
	$ss_sql .= "getCategoriaNome(c03_piloto) AS valor ";
	$ss_sql .= "FROM t03_veiculo ";
	$ss_sql .= "WHERE c03_codigo = ".$veiculo." ";
	return $ss_sql;
} 

/*
*
*
*/
function geraSqlOrigem($veiculo) {
	$ss_sql = 'SELECT ';
	$ss_sql .= "getTripulanteOrigem(c03_piloto) AS valor ";
	$ss_sql .= "FROM t03_veiculo ";
	$ss_sql .= "WHERE c03_codigo = ".$veiculo." ";
	return $ss_sql;
} 

/*
*
*
*/
function geraSqlAbandonos() {
	$ab_sql = "SELECT a.c03_codigo AS numero, ";
	$ab_sql .= "getTripulanteNome(a.c03_piloto) AS piloto, ";
	$ab_sql .= "getTripulanteNome(a.c03_navegador) AS navegador, ";
	$ab_sql .= "b.c02_codigo AS trecho, ";
	$ab_sql .= "b.motivo AS motivo ";
	$ab_sql .= "FROM t03_veiculo AS a, t31_abandonos AS b ";
	$ab_sql .= "WHERE a.c03_codigo = b.c03_codigo ";
	$ab_sql .= "ORDER BY b.c31_codigo ";
	return $ab_sql;
}

?>