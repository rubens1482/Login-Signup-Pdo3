<?php
/*
/ FUNÇÃO: RETORNAR OS DADOS DO BALANÇO POR MES E ANO COM ACUMULADO ANUAL ATÉ O MES SELECIONADO
/ DADOS RETORNADOS: idconta, mes, ano, saldo_ano_ant, saldo_anterior_mes, credito_mes, debito_mes, saldo_atual_mes, bal_mes, credito_acum_ano, debito_acum_ano
*/
$bal_pormes = "SELECT idconta, DATE_FORMAT(datamov,'%m') AS mes, DATE_FORMAT(datamov,'%Y') AS ano,(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE DATE_FORMAT(lc_movimento.datamov,'%Y') > DATE_FORMAT(L2.datamov,'%Y%m') and idconta = lc_movimento.idconta) AS saldo_ano_ant,(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE DATE_FORMAT(lc_movimento.datamov,'%Y%m') > DATE_FORMAT(L2.datamov,'%Y%m') and idconta = lc_movimento.idconta) AS saldo_anterior_mes, SUM(IF(lc_movimento.tipo = 1, valor, 0)) AS credito_mes, SUM(IF(lc_movimento.tipo = 0, -1*valor, 0)) AS debito_mes,(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE DATE_FORMAT(lc_movimento.datamov,'%Y%m') >=DATE_FORMAT(L2.datamov,'%Y%m') and idconta = lc_movimento.idconta) AS saldo_atual_mes,(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE DATE_FORMAT(lc_movimento.datamov,'%Y%m') = DATE_FORMAT(L2.datamov,'%Y%m') and idconta = lc_movimento.idconta) AS bal_mes,(SELECT SUM(valor) FROM lc_movimento AS L3 WHERE tipo=1 and year(lc_movimento.datamov) = year(L3.datamov) and month(lc_movimento.datamov) >=month(L3.datamov) and idconta = lc_movimento.idconta) AS credito_acum_ano,(SELECT SUM(valor)*-1 FROM lc_movimento AS L3 WHERE tipo=0 and year(lc_movimento.datamov) = year(L3.datamov) and month(lc_movimento.datamov) >=month(L3.datamov) and idconta = lc_movimento.idconta) AS debito_acum_ano FROM lc_movimento WHERE idconta=:contpd and mes=:mes_hoje and ano=:ano_hoje GROUP BY idconta, mes, ano ORDER BY ano, mes;";
/*
/ FUNÇÃO: BALANÇO POR FOLHA E LIVRO COM ACUMULADO POR ATÉ A FOLHA E LIVRO SELECIONADO
/ DADOS RETORNADOS: idconta, idlivro, folha, saldo_folha_ant, credito, debito, atual, saldo_atual, bal_folha, saldo_livro_ant, credito_acum, debito_acum
*/
$bal_porfolha = "SELECT idconta, idlivro, folha, CASE WHEN lc_movimento.idlivro=1 and lc_movimento.folha=1 THEN 0 WHEN lc_movimento.idlivro=1 and lc_movimento.folha>=2 THEN (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L1 WHERE L1.idlivro = lc_movimento.idlivro and L1.folha < lc_movimento.folha and L1.idconta = lc_movimento.idconta) WHEN lc_movimento.idlivro >=2 and lc_movimento.folha=1 THEN (SELECT SUM(IF(tipo = 1 AND idlivro = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro < lc_movimento.idlivro and L2.idconta = lc_movimento.idconta) WHEN lc_movimento.idlivro >= 2 and lc_movimento.folha>=2 THEN (SELECT SUM(IF(tipo = 1 AND idlivro = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro < lc_movimento.idlivro and L2.idconta = lc_movimento.idconta) + (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L1 WHERE L1.idlivro = lc_movimento.idlivro and L1.folha < lc_movimento.folha and L1.idconta = lc_movimento.idconta) END AS saldo_folha_ant, SUM(IF(lc_movimento.tipo = 1, valor, 0)) AS credito_f, SUM(IF(lc_movimento.tipo = 0, -1*valor, 0)) AS debito_f, CASE WHEN lc_movimento.idlivro=1 and lc_movimento.folha>=1 THEN (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro <= lc_movimento.idlivro and L2.folha <= lc_movimento.folha and L2.idconta = lc_movimento.idconta) WHEN lc_movimento.idlivro>=2 and lc_movimento.folha=1 THEN (SELECT SUM(IF(tipo = 1 AND idlivro = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro < lc_movimento.idlivro and L2.idconta = lc_movimento.idconta) + (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro = lc_movimento.idlivro and L2.folha = lc_movimento.folha and L2.idconta = lc_movimento.idconta) WHEN lc_movimento.idlivro>=2 and lc_movimento.folha>=2 THEN (SELECT SUM(IF(tipo = 1 AND idlivro = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro < lc_movimento.idlivro and L2.idconta = lc_movimento.idconta) + (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro = lc_movimento.idlivro and L2.folha <= lc_movimento.folha and L2.idconta = lc_movimento.idconta) WHEN lc_movimento.idlivro>1 and lc_movimento.folha>1 THEN '2-3 ou acima' END AS saldo_atual_f,(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro = lc_movimento.idlivro and L2.folha = lc_movimento.folha and L2.idconta = lc_movimento.idconta) AS bal_folha, CASE WHEN lc_movimento.idlivro=1 THEN 0.00 WHEN lc_movimento.idlivro>1 THEN (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro < lc_movimento.idlivro and L2.idconta = lc_movimento.idconta) END AS saldo_livro_ant,(SELECT SUM(valor) FROM lc_movimento AS L3 WHERE L3.tipo=1 and L3.idlivro = lc_movimento.idlivro and L3.folha <=lc_movimento.folha and L3.idconta = lc_movimento.idconta)  AS credito_acum,(SELECT IF(SUM(valor) IS NULL , 0, SUM(valor)) FROM lc_movimento AS L3 WHERE L3.tipo=1 and L3.idlivro < lc_movimento.idlivro and L3.idconta = lc_movimento.idconta)  AS cred_la,(SELECT SUM(valor)*-1 FROM lc_movimento AS L3 WHERE L3.tipo=0 and L3.idlivro = lc_movimento.idlivro and L3.folha <=lc_movimento.folha and L3.idconta = lc_movimento.idconta) AS debito_acum,(SELECT IF(SUM(valor) IS NULL , 0, SUM(valor)*-1) FROM lc_movimento AS L3 WHERE L3.tipo=0 and L3.idlivro < lc_movimento.idlivro and L3.idconta = lc_movimento.idconta)  AS deb_la,(SELECT credito_acum) + (SELECT cred_la) + (SELECT debito_acum) + (SELECT deb_la) as bal_cre FROM lc_movimento WHERE idconta=:contapd and idlivro=:idlivro and folha>=:folha_i and folha<=:folha_f GROUP BY idconta, idlivro, folha;";

/* 
/ FUNÇÃO: DADOS POR MES / ANO SALDO LINHA A LINHA
/ Dados: idconta, id, datamov, descricao, idlivro, folha, mes, ano, saldo_anterior, credito, debito, saldo_atual
/ telas adicionadas: 
*/

$dados_pormes = "SELECT *, (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE IF(L2.datamov < lc_movimento.datamov, L2.datamov < lc_movimento.datamov and L2.idconta = lc_movimento.idconta, L2.datamov = lc_movimento.datamov and L2.idconta = lc_movimento.idconta and L2.id < lc_movimento.id)) AS saldo_anterior,(SELECT IF( lc_movimento.tipo=1, SUM(valor), 0 ) FROM lc_movimento as L2 WHERE L2.id = lc_movimento.id and idconta=1 and L2.datamov = lc_movimento.datamov) as credito, (SELECT IF( lc_movimento.tipo=0, SUM(valor), 0 ) FROM lc_movimento as L2 WHERE L2.datamov = lc_movimento.datamov and idconta=1 and L2.id = lc_movimento.id) as debito, (IF((SELECT Saldo_anterior) IS NULL, 0, (SELECT Saldo_anterior) ) + (SELECT credito) - (SELECT debito)) as saldo_atual FROM lc_movimento WHERE idconta=:contapd and month(datamov)=:mes_hoje and year(datamov)=:ano_hoje ORDER BY datamov ASC;";

/* 
/ FUNÇÃO: DADOS POR FOLHA E LIVRO
/ Dados: idconta, id, datamov, descricao, lc_cat.nome, idlivro, folha, mes, ano, saldo_anterior, credito, debito, saldo_atual
*/
$dados_porfolha = "SELECT *, (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE IF(L2.datamov < lc_movimento.datamov, L2.datamov < lc_movimento.datamov and L2.idconta = lc_movimento.idconta, L2.datamov = lc_movimento.datamov and L2.idconta = lc_movimento.idconta and L2.id < lc_movimento.id)) AS saldo_anterior,(SELECT IF( lc_movimento.tipo=1, SUM(valor), 0 ) FROM lc_movimento as L2 WHERE L2.id = lc_movimento.id and idconta=1 and L2.datamov = lc_movimento.datamov) as credito, (SELECT IF( lc_movimento.tipo=0, SUM(valor), 0 ) FROM lc_movimento as L2 WHERE L2.datamov = lc_movimento.datamov and idconta=1 and L2.id = lc_movimento.id) as debito, ((SELECT Saldo_anterior) + (SELECT credito) - (SELECT debito)) as saldo_atual FROM lc_movimento WHERE idconta=:contapd and descricao LIKE :busca and idlivro=:idlivro and folha_i>=:folha_i and folha_f<=:folha_f ORDER by datamov;";
/* 
/ FUNÇÃO: DADOS POR FOLHA E LIVRO
/ Dados: idconta, id, datamov, descricao, lc_cat.nome, idlivro, folha, mes, ano, saldo_anterior, credito, debito, saldo_atual
*/
$dados_mes_ano_cat = "SELECT lc_movimento.idconta, lc_movimento.tipo, month(lc_movimento.datamov) as mes, year(lc_movimento.datamov) as ano , lc_movimento.cat AS cat, if(lc_movimento.tipo=1, sum(lc_movimento.valor), sum(lc_movimento.valor)*-1) as soma, lc_cat.nome FROM lc_movimento INNER JOIN lc_cat on lc_movimento.cat=lc_cat.id WHERE idconta=:contapd GROUP BY ano, mes, tipo, cat ORDER BY ano, mes, tipo, cat ASC;";

/* 
/ FUNÇÃO: DADOS POR INTERVALO DE DATAS COM CARACTER CORINGA PARA PESQUISA DE TEXTO ESPECIFICO
/ Dados: *, saldo_anterior, credito, debito, saldo_atual
*/
$dados_data_a_data = "SELECT *, (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE IF(L2.datamov < lc_movimento.datamov, L2.datamov < lc_movimento.datamov and L2.idconta = lc_movimento.idconta, L2.datamov = lc_movimento.datamov and L2.idconta = lc_movimento.idconta and L2.id < lc_movimento.id)) AS saldo_anterior,(SELECT IF(lc_movimento.tipo=1, SUM(valor), 0 ) FROM lc_movimento as L2 WHERE L2.id = lc_movimento.id and idconta=1 and L2.datamov = lc_movimento.datamov) as credito, (SELECT IF( lc_movimento.tipo=0, SUM(valor), 0 ) FROM lc_movimento as L2 WHERE L2.datamov = lc_movimento.datamov and idconta=1 and L2.id = lc_movimento.id) as debito, (SELECT IF((Saldo_anterior) > 0, Saldo_anterior , 0 ) + (SELECT credito) - (SELECT debito)) as saldo_atual FROM lc_movimento WHERE idconta=:contapd and descricao LIKE busca and datamov>=:data_i and datamov<=:data_f ORDER BY datamov ASC;";

/* 
/ FUNÇÃO: DADOS POR INTERVALO DE DATAS COM CARACTER CORINGA PARA PESQUISA DE TEXTO ESPECIFICO
/ Dados: idconta, id, datamov, descricao, lc_cat.nome, idlivro, folha, mes, ano, saldo_anterior, credito, debito, saldo_atual
*/

$dados_folha_folha = "SELECT *, (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE IF(L2.datamov < lc_movimento.datamov, L2.datamov < lc_movimento.datamov and L2.idconta = lc_movimento.idconta, L2.datamov = lc_movimento.datamov and L2.idconta = lc_movimento.idconta and L2.id < lc_movimento.id)) AS saldo_anterior,(SELECT IF(lc_movimento.tipo=1, SUM(valor), 0 ) FROM lc_movimento as L2 WHERE L2.id = lc_movimento.id and idconta=1 and L2.datamov = lc_movimento.datamov) as credito,(SELECT IF( lc_movimento.tipo=0, SUM(valor), 0 ) FROM lc_movimento as L2 WHERE L2.datamov = lc_movimento.datamov and idconta=1 and L2.id = lc_movimento.id) as debito, (SELECT IF((Saldo_anterior) > 0, Saldo_anterior , 0 ) + (SELECT credito) - (SELECT debito)) as saldo_atual FROM lc_movimento WHERE idconta=:contapd and descricao LIKE busca and idlivro=:idlivro and folha>=:folha_i and folha<=:folha_f ORDER BY datamov ASC;";

$bal_dia = "SELECT idconta, datamov, (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.datamov < lc_movimento.datamov and L2.idconta = lc_movimento.idconta) AS saldo_dia_ant,(SELECT IF(SUM(valor) IS NULL, 0, SUM(valor)) FROM lc_movimento as L2 WHERE L2.tipo=1 and idconta=1 and L2.datamov = lc_movimento.datamov) as credito_dia, (SELECT IF(sum(valor) IS NULL, 0 , sum(valor)) FROM lc_movimento as L2 WHERE L2.tipo=0 and idconta=1 and L2.datamov = lc_movimento.datamov) as debito_dia,((SELECT saldo_dia_ant) + (SELECT credito_dia) - (SELECT debito_dia)) as saldo_dia_atual,(SELECT SUM(valor) FROM lc_movimento AS L3 WHERE tipo=1 and year(L3.datamov) = year(lc_movimento.datamov) and month(L3.datamov) = month(lc_movimento.datamov) and L3.datamov <=lc_movimento.datamov and idconta = lc_movimento.idconta) AS cred_acum_dia,(SELECT SUM(valor) FROM lc_movimento AS L3 WHERE tipo=0 and year(L3.datamov) = year(lc_movimento.datamov) and month(L3.datamov) = month(lc_movimento.datamov) and L3.datamov <=lc_movimento.datamov and idconta = lc_movimento.idconta) AS deb_acum_dia FROM lc_movimento WHERE idconta=1 and month(datamov)=1 and year(datamov)=2015 GROUP by day(datamov) ORDER BY datamov ASC;";

$bal_geral = "SELECT idconta, DATE_FORMAT(datamov,'%m') AS mes, DATE_FORMAT(datamov,'%Y') AS ano,(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2WHERE DATE_FORMAT(lc_movimento.datamov,'%Y') >DATE_FORMAT(L2.datamov,'%Y%m') and idconta = lc_movimento.idconta) AS anoAnt,(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE DATE_FORMAT(lc_movimento.datamov,'%Y%m') >=DATE_FORMAT(L2.datamov,'%Y%m') and idconta = lc_movimento.idconta) AS mesAnt,SUM(IF(lc_movimento.tipo = 1, valor, 0)) AS credito,SUM(IF(lc_movimento.tipo = 0, -1*valor, 0)) AS debito,(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE DATE_FORMAT(lc_movimento.datamov,'%Y%m') >=DATE_FORMAT(L2.datamov,'%Y%m') and idconta = lc_movimento.idconta) AS saldo,(SELECT SUM(valor) FROM lc_movimento AS L3 WHERE tipo=1 and year(lc_movimento.datamov) = year(L3.datamov) and month(lc_movimento.datamov) >=month(L3.datamov) and idconta = lc_movimento.idconta) AS credito_acum_ano,(SELECT SUM(valor)*-1 FROM lc_movimento AS L3 WHERE tipo=0 and year(lc_movimento.datamov) = year(L3.datamov) and month(lc_movimento.datamov) >=month(L3.datamov) and idconta = lc_movimento.idconta) AS debito_acum_ano FROM lc_movimento WHERE idconta =:contapd GROUP BY idconta, mes, ano ORDER BY ano, mes;";

?>