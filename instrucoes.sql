=== SELEC AGRUPADO POR DATA, CATEGORIA, TIPO E SOMA DAS CATEGORIAS POR DIA ==========================================================

SELECT datamov, tipo, cat, if(lc_movimento.tipo=1, sum(lc_movimento.valor), sum(lc_movimento.valor)*-1) as soma FROM lc_movimento 
WHERE idconta=1 
GROUP BY datamov,cat   
ORDER by  datamov, tipo, cat ASC;

======================================================================================================================================
======================================================================================================================================
/*
/ FUNÇÃO: AGRUPAMENTO POR CODIGO DA CONTA, MES, ANO, CATEGORIAS E NOME DAS CATEGORIAS
/ DADOS RETORNADOS: idconta, mes, ano, anoAnt, mesAnt, credito, debito, saldo
*/

SELECT lc_movimento.idconta, lc_movimento.tipo, month(lc_movimento.datamov) as mes, year(lc_movimento.datamov) as ano , lc_movimento.cat AS cat, if(lc_movimento.tipo=1, sum(lc_movimento.valor), sum(lc_movimento.valor)*-1) as soma, lc_cat.nome 
FROM lc_movimento INNER JOIN lc_cat on lc_movimento.cat=lc_cat.id 
WHERE idconta=1
GROUP BY ano, mes, tipo, cat 
ORDER BY ano, mes, tipo, cat ASC;

======================================================================================================================================

AGRUPAMENTO POR CONTA COM SOMA DAS ENTRADAS POR MES E ANO SOMA GERAL
SELECT lc_movimento.idconta, lc_movimento.idlivro, lc_movimento.folha, lc_movimento.tipo, if(lc_movimento.tipo=1, sum(lc_movimento.valor), sum(lc_movimento.valor)*-1) as operacao
FROM lc_movimento
WHERE idconta=1
GROUP BY idlivro, folha, tipo
ORDER BY idlivro, folha, tipo ASC;

======================================================================================================================================



AGRUPAMENTO SOMA DOS VALORES POR MES, ANO, CATEGORIA, NOME DAS CATEGORIAS E TOTAL POR CATEGORIA

SELECT lc_movimento.idconta, month(datamov) as mes,year(datamov) as ano,lc_movimento.tipo, lc_movimento.cat, lc_cat.nome, (SELECT IF(tipo=0, SUM(valor)*-1, 0) FROM lc_movimento as L2 WHERE L2.tipo=lc_movimento.tipo and L2.cat=lc_movimento.cat and month(L2.datamov)=month(lc_movimento.datamov) and year(L2.datamov)=year(lc_movimento.datamov )) as vr_cat_deb,(SELECT IF(tipo=1, SUM(valor), 0) FROM lc_movimento as L2 WHERE L2.tipo=lc_movimento.tipo and L2.cat=lc_movimento.cat and month(L2.datamov)=month(lc_movimento.datamov) and year(L2.datamov)=year(lc_movimento.datamov) and L2.idconta=lc_movimento.idconta) as vr_cat_cred,(SELECT IF((SELECT vr_cat_cred) >0 , SUM(valor), 0 ) FROM lc_movimento as L3 WHERE tipo=1 and L3.idconta=lc_movimento.idconta and month(L3.datamov)=month(lc_movimento.datamov) and year(L3.datamov)=year(lc_movimento.datamov) and L3.cat<=lc_movimento.cat as acum_cat_cred,(SELECT IF((SELECT vr_cat_deb) <0 , SUM(valor)*-1, 0 ) FROM lc_movimento as L3 WHERE tipo=0 and L3.idconta=lc_movimento.idconta and month(L3.datamov)=month(lc_movimento.datamov) and year(L3.datamov)=year(lc_movimento.datamov) and L3.cat<=lc_movimento.cat) as acum_cat_deb FROM lc_movimento INNER JOIN lc_cat ON lc_movimento.cat=lc_cat.id WHERE idconta=1 and month(datamov)=1 and year(datamov)=2015 GROUP BY  cat, tipo ORDER BY idlivro,  tipo, cat ASC;

======================================================================================================================================
AGRUPAMENTO SOMA DOS VALORES POR MES, ANO, CATEGORIA, NOME DAS CATEGORIAS E TOTAL POR CATEGORIA

SELECT lc_movimento.idconta,idlivro,folha,lc_movimento.tipo, lc_movimento.cat, lc_cat.nome, (SELECT IF(tipo=0, SUM(valor)*-1, 0) FROM lc_movimento as L2 WHERE L2.tipo=lc_movimento.tipo and L2.cat=lc_movimento.cat and L2.idlivro=lc_movimento.idlivro and L2.folha=lc_movimento.folha) as vr_cat_deb,(SELECT IF(tipo=1, SUM(valor), 0) FROM lc_movimento as L2 WHERE L2.tipo=lc_movimento.tipo and L2.cat=lc_movimento.cat and L2.idlivro=lc_movimento.idlivro and L2.folha=lc_movimento.folha and L2.idconta=lc_movimento.idconta) as vr_cat_cred,(SELECT IF((SELECT vr_cat_cred) >0 , SUM(valor), 0 ) FROM lc_movimento as L3 WHERE tipo=1 and L3.idconta=lc_movimento.idconta and L3.idlivro=lc_movimento.idlivro and L3.folha=lc_movimento.folha and L3.cat<=lc_movimento.cat) as acum_cat_cred,(SELECT IF((SELECT vr_cat_deb) <0 , SUM(valor)*-1, 0 ) FROM lc_movimento as L3 WHERE tipo=0 and L3.idconta=lc_movimento.idconta and L3.idlivro=lc_movimento.idlivro and L3.folha=lc_movimento.folha and L3.cat<=lc_movimento.cat) as acum_cat_deb FROM lc_movimento INNER JOIN lc_cat ON lc_movimento.cat=lc_cat.id WHERE idconta=1 and idlivro=2 and folha>=2 and folha<=2 GROUP BY  cat, tipo ORDER BY idlivro,  tipo, cat ASC;


======================================================================================================================================

SELECT idconta, DATE_FORMAT(datamov,'%d/%m/%Y') AS data,
SUM(IF(tipo = 1, valor, 0)) AS credito,
SUM(IF(tipo = 0, -1*valor, 0)) AS debito,
(SELECT SUM(IF(tipo = 1, valor, -valor)) FROM lc_movimento AS L2
      WHERE DATE_FORMAT(lc_movimento.datamov,'%Y%m') >=
          DATE_FORMAT(L2.datamov,'%Y%m') and
          idconta = lc_movimento.idconta) AS saldo
FROM lc_movimento WHERE idconta = 1 
GROUP BY idconta, MONTH(datamov), YEAR(datamov) ORDER BY YEAR(datamov), MONTH(datamov);

=======================================================================================================================================


=======================================================================================================================================
SALDO ENTRADAS E SAIDA POR LIVRO E FOLHA
SELECT lc_movimento.idconta, lc_movimento.idlivro, lc_movimento.folha, 
SUM(IF(tipo = 1, valor, 0)) AS credito,
SUM(IF(tipo = 0, -1*valor, 0)) AS debito
FROM lc_movimento
WHERE idconta=1
GROUP BY idlivro, folha
ORDER BY idlivro, folha, tipo ASC;

=======================================================================================================================================
/*
/ FUNÇÃO: BALANÇO GERAL DA CONTA EM TODO O PERIODO - ANO E MES TODOS
/ DADOS RETORNADOS: idconta, mes, ano, anoAnt, mesAnt, credito, debito, saldo
*/

SELECT idconta, DATE_FORMAT(datamov,'%m') AS mes, DATE_FORMAT(datamov,'%Y') AS ano,
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE DATE_FORMAT(lc_movimento.datamov,'%Y') >
DATE_FORMAT(L2.datamov,'%Y%m') and
idconta = lc_movimento.idconta) AS anoAnt,
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE DATE_FORMAT(lc_movimento.datamov,'%Y%m') >=
DATE_FORMAT(L2.datamov,'%Y%m') and
idconta = lc_movimento.idconta) AS mesAnt,
SUM(IF(lc_movimento.tipo = 1, valor, 0)) AS credito,
SUM(IF(lc_movimento.tipo = 0, -1*valor, 0)) AS debito,
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE DATE_FORMAT(lc_movimento.datamov,'%Y%m') >=
DATE_FORMAT(L2.datamov,'%Y%m') and
idconta = lc_movimento.idconta) AS saldo,
(SELECT SUM(valor) FROM lc_movimento AS L3
WHERE tipo=1 and year(lc_movimento.datamov) = year(L3.datamov) and month(lc_movimento.datamov) >=
month(L3.datamov) and 
idconta = lc_movimento.idconta) AS credito_acum_ano,
(SELECT SUM(valor)*-1 FROM lc_movimento AS L3
WHERE tipo=0 and year(lc_movimento.datamov) = year(L3.datamov) and month(lc_movimento.datamov) >=
month(L3.datamov) and 
idconta = lc_movimento.idconta) AS debito_acum_ano
FROM lc_movimento WHERE idconta = 1
GROUP BY idconta, mes, ano ORDER BY ano, mes;

==================================================================================================================================
/*
/ FUNÇÃO: BALANÇO DO ANO ATÉ O MES SELECIONADO OU SOMENTE O MES SELECIONADO
/ DADOS RETORNADOS: idconta, mes, ano, saldo_ano_ant, saldo_anterior_mes, credito_mes, debito_mes, saldo_atual_mes, bal_mes, credito_acum_ano, debito_acum_ano
*/
SELECT idconta, DATE_FORMAT(datamov,'%m') AS mes, DATE_FORMAT(datamov,'%Y') AS ano,
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE DATE_FORMAT(lc_movimento.datamov,'%Y') >
DATE_FORMAT(L2.datamov,'%Y%m') and
idconta = lc_movimento.idconta) AS saldo_ano_ant,

(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE DATE_FORMAT(lc_movimento.datamov,'%Y%m') >
DATE_FORMAT(L2.datamov,'%Y%m') and
idconta = lc_movimento.idconta) AS saldo_anterior_mes,
SUM(IF(lc_movimento.tipo = 1, valor, 0)) AS credito_mes,
SUM(IF(lc_movimento.tipo = 0, -1*valor, 0)) AS debito_mes,
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE DATE_FORMAT(lc_movimento.datamov,'%Y%m') >=
DATE_FORMAT(L2.datamov,'%Y%m') and
idconta = lc_movimento.idconta) AS saldo_atual_mes,
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE DATE_FORMAT(lc_movimento.datamov,'%Y%m') =
DATE_FORMAT(L2.datamov,'%Y%m') and
idconta = lc_movimento.idconta) AS bal_mes,
(SELECT SUM(valor) FROM lc_movimento AS L3
WHERE tipo=1 and year(lc_movimento.datamov) = year(L3.datamov) and month(lc_movimento.datamov) >=
month(L3.datamov) and 
idconta = lc_movimento.idconta) AS credito_acum_ano,
(SELECT SUM(valor)*-1 FROM lc_movimento AS L3
WHERE tipo=0 and year(lc_movimento.datamov) = year(L3.datamov) and month(lc_movimento.datamov) >=
month(L3.datamov) and 
idconta = lc_movimento.idconta) AS debito_acum_ano
FROM lc_movimento WHERE idconta = 1 and mes<=12 and ano=2016
GROUP BY idconta, mes, ano ORDER BY ano, mes;


=============================================================================================================
/* 
/ FUNÇÃO: BALANÇO DO ANO ATÉ O MES SELECIONADO
/ Dados: idconta, mes, ano, credito, debito, bal_mes, saldo_atual, saldo_aa, credito_acum, debito_acum
*/
DADOS RETORNADOS: idconta, mes, ano, credito, debito, bal_mes, saldo_atual, saldo_aa, credito_sum, debito_sum

SELECT idconta, month(datamov) AS mes, year(datamov) AS ano,
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE lc_movimento.datamov >
L2.datamov and
idconta = lc_movimento.idconta) AS saldo_anterior_mes,
SUM(IF(lc_movimento.tipo = 1, valor, 0)) AS credito,
SUM(IF(lc_movimento.tipo = 0, -1*valor, 0)) AS debito,
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE DATE_FORMAT(lc_movimento.datamov,'%Y%m') =
DATE_FORMAT(L2.datamov,'%Y%m') and
idconta = lc_movimento.idconta) AS bal_mes,
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE DATE_FORMAT(lc_movimento.datamov,'%Y%m') >=
DATE_FORMAT(L2.datamov,'%Y%m') and
idconta = lc_movimento.idconta) AS saldo_atual,
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE year(lc_movimento.datamov) >
year(L2.datamov) and 
idconta = lc_movimento.idconta) AS saldo_aa,
(SELECT SUM(valor) FROM lc_movimento AS L3
WHERE tipo=1 and year(lc_movimento.datamov) = year(L3.datamov) and month(lc_movimento.datamov) >=
month(L3.datamov) and 
idconta = lc_movimento.idconta) AS credito_acum,
(SELECT SUM(valor)*-1 FROM lc_movimento AS L3
WHERE tipo=0 and year(lc_movimento.datamov) = year(L3.datamov) and month(lc_movimento.datamov) >=
month(L3.datamov) and 
idconta = lc_movimento.idconta) AS debito_acum
FROM lc_movimento
WHERE idconta=1 and year(datamov)=2015 and month(datamov)<=5
GROUP BY idconta, ano, mes;


=============================================================================

/* 
/ FUNÇÃO: BALANÇO POR FOLHA E LIVRO.
/ Dados: idconta, idlivro, folha,saldo_folha_ant, credito, debito, saldo_atual, bal_mes, saldo_livro_ant, credito_acum, debito_acum
*/

SELECT idconta, idlivro, folha, 
CASE WHEN lc_movimento.idlivro=1 and lc_movimento.folha=1 THEN 0 
WHEN lc_movimento.idlivro=1 and lc_movimento.folha>=2 THEN 
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L1 WHERE L1.idlivro = lc_movimento.idlivro and L1.folha < lc_movimento.folha and L1.idconta = lc_movimento.idconta) 
WHEN lc_movimento.idlivro >=2 and lc_movimento.folha=1 THEN 
(SELECT SUM(IF(tipo = 1 AND idlivro = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro < lc_movimento.idlivro and L2.idconta = lc_movimento.idconta) 
WHEN lc_movimento.idlivro >= 2 and lc_movimento.folha>=2 THEN 
(SELECT SUM(IF(tipo = 1 AND idlivro = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro < lc_movimento.idlivro and L2.idconta = lc_movimento.idconta) + (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L1 WHERE L1.idlivro = lc_movimento.idlivro and L1.folha < lc_movimento.folha and L1.idconta = lc_movimento.idconta) END AS saldo_folha_ant,
SUM(IF(lc_movimento.tipo = 1, valor, 0)) AS credito_f, 
SUM(IF(lc_movimento.tipo = 0, -1*valor, 0)) AS debito_f,

CASE 
WHEN lc_movimento.idlivro=1 and lc_movimento.folha>=1 THEN 
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro <= lc_movimento.idlivro and L2.folha <= lc_movimento.folha and L2.idconta = lc_movimento.idconta) 
WHEN lc_movimento.idlivro>=2 and lc_movimento.folha=1 THEN 
(SELECT SUM(IF(tipo = 1 AND idlivro = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro < lc_movimento.idlivro and L2.idconta = lc_movimento.idconta) + (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro = lc_movimento.idlivro and L2.folha = lc_movimento.folha and L2.idconta = lc_movimento.idconta) 
WHEN lc_movimento.idlivro>=2 and lc_movimento.folha>=2 THEN 
(SELECT SUM(IF(tipo = 1 AND idlivro = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro < lc_movimento.idlivro and L2.idconta = lc_movimento.idconta) + (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro = lc_movimento.idlivro and L2.folha <= lc_movimento.folha and L2.idconta = lc_movimento.idconta) 
WHEN lc_movimento.idlivro>1 and lc_movimento.folha>1 THEN 
'2-3 ou acima' END AS saldo_atual_f,


(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro = lc_movimento.idlivro and L2.folha = lc_movimento.folha and L2.idconta = lc_movimento.idconta) AS bal_folha, 

CASE WHEN lc_movimento.idlivro=1 THEN 0.00 
WHEN lc_movimento.idlivro>1 THEN (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.idlivro < lc_movimento.idlivro and L2.idconta = lc_movimento.idconta) END AS saldo_livro_ant,

(SELECT SUM(valor) FROM lc_movimento AS L3 WHERE L3.tipo=1 and L3.idlivro = lc_movimento.idlivro and L3.folha <=lc_movimento.folha and L3.idconta = lc_movimento.idconta)  AS credito_acum,

(SELECT IF(SUM(valor) IS NULL , 0, SUM(valor)) FROM lc_movimento AS L3 WHERE L3.tipo=1 and L3.idlivro < lc_movimento.idlivro and L3.idconta = lc_movimento.idconta)  AS cred_la,

(SELECT SUM(valor)*-1 FROM lc_movimento AS L3 WHERE L3.tipo=0 and L3.idlivro = lc_movimento.idlivro and L3.folha <=lc_movimento.folha and L3.idconta = lc_movimento.idconta) AS debito_acum,

(SELECT IF(SUM(valor) IS NULL , 0, SUM(valor)*-1) FROM lc_movimento AS L3 WHERE L3.tipo=0 and L3.idlivro < lc_movimento.idlivro and L3.idconta = lc_movimento.idconta)  AS deb_la,


(SELECT credito_acum) + (SELECT cred_la) + (SELECT debito_acum) + (SELECT deb_la) as bal_cre

FROM lc_movimento WHERE idconta=1 and idlivro=1 and folha>=87 and folha<=87 GROUP BY idconta, idlivro, folha;
====================================================================================================================
/* 
/ FUNÇÃO: LANÇAMENTOS DO MES / SALDO LINHA A LINHA
/ Dados: idconta, id, datamov, descricao, idlivro, folha, mes, ano, saldo_anterior, credito, debito, saldo_atual
*/
SELECT *, 
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE IF(L2.datamov < lc_movimento.datamov, L2.datamov < lc_movimento.datamov and L2.idconta = 
lc_movimento.idconta, L2.datamov = lc_movimento.datamov and L2.idconta = lc_movimento.idconta and L2.id < lc_movimento.id)) AS saldo_anterior,
(SELECT IF( lc_movimento.tipo=1, SUM(valor), 0 ) FROM lc_movimento as L2 WHERE L2.id = lc_movimento.id and idconta=1 and L2.datamov = lc_movimento.datamov) as credito, 
(SELECT IF( lc_movimento.tipo=0, SUM(valor), 0 ) FROM lc_movimento as L2 WHERE L2.datamov = lc_movimento.datamov and idconta=1 and L2.id = lc_movimento.id) as debito, 
((SELECT Saldo_anterior) + (SELECT credito) - (SELECT debito)) as saldo_atual 
 FROM lc_movimento WHERE idconta=1 and month(datamov)=3 and year(datamov)=2015 ORDER BY datamov
 ASC;
 =======================================================================================================================================================================
/* 
/ FUNÇÃO: LANÇAMENTOS POR FOLHA E LIVRO
/ Dados: idconta, id, datamov, descricao, lc_cat.nome, idlivro, folha, mes, ano, saldo_anterior, credito, debito, saldo_atual
*/
SELECT *, (SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE IF(L2.datamov < lc_movimento.datamov, L2.datamov < lc_movimento.datamov and L2.idconta = 
lc_movimento.idconta, L2.datamov = lc_movimento.datamov and L2.idconta = lc_movimento.idconta and L2.id < lc_movimento.id)) AS saldo_anterior,
(SELECT IF( lc_movimento.tipo=1, SUM(valor), 0 ) FROM lc_movimento as L2 WHERE L2.id = lc_movimento.id and idconta=1 and L2.datamov = lc_movimento.datamov) as credito, 
(SELECT IF( lc_movimento.tipo=0, SUM(valor), 0 ) FROM lc_movimento as L2 WHERE L2.datamov = lc_movimento.datamov and idconta=1 and L2.id = lc_movimento.id) as debito, 
((SELECT Saldo_anterior) + (SELECT credito) - (SELECT debito)) as saldo_atual FROM lc_movimento WHERE idconta=1 and idlivro=2 and folha=2 ORDER by datamov;

========================================================================================================================================================================
/* 
/ FUNÇÃO: DADOS POR INTERVALO DE DATAS, CONTA
/ Dados: *, 
*/
SELECT idconta, datamov,
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE lc_movimento.datamov >
L2.datamov and
idconta = lc_movimento.idconta) AS saldo_ano_ant,
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE lc_movimento.datamov >
L2.datamov and
idconta = lc_movimento.idconta) AS saldo_anterior_mes,
SUM(IF(lc_movimento.tipo = 1, valor, 0)) AS credito_mes,
SUM(IF(lc_movimento.tipo = 0, -1*valor, 0)) AS debito_mes,
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE L2.datamov <=
lc_movimento.datamov and
idconta = lc_movimento.idconta) AS saldo_atual_mes,
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE lc_movimento.datamov =
L2.datamov and
idconta = lc_movimento.idconta) AS bal_mes,
(SELECT SUM(valor) FROM lc_movimento AS L3
WHERE tipo=1 and year(lc_movimento.datamov) = year(L3.datamov) and month(lc_movimento.datamov) >=
month(L3.datamov) and 
idconta = lc_movimento.idconta) AS credito_acum_ano,
(SELECT SUM(valor)*-1 FROM lc_movimento AS L3
WHERE tipo=0 and year(lc_movimento.datamov) = year(L3.datamov) and month(lc_movimento.datamov) >=
month(L3.datamov) and 
idconta = lc_movimento.idconta) AS debito_acum_ano
FROM lc_movimento WHERE idconta = 1 and datamov>='2014-12-01' and datamov<='2014-12-31'
GROUP BY idconta, mes, ano ORDER BY ano, mes;

/* 
/ FUNÇÃO: BALANÇO POR DIA COM CREDITOS E DEBITO DO DIA E ACUMULADO DE CREDITO E DEBITO DO DIA (DO MES E ANO SELECIOADO)
/ Dados: idconta, datamov, saldo_dia_ant, credito_dia, debito_dia, saldo_dia_atual, cred_acum_dia, deb_acum_dia
*/

SELECT idconta, datamov, 
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.datamov < lc_movimento.datamov and L2.idconta = lc_movimento.idconta) AS saldo_dia_ant,
(SELECT IF(SUM(valor) IS NULL, 0, SUM(valor)) FROM lc_movimento as L2 WHERE L2.tipo=1 and idconta=1 and L2.datamov = lc_movimento.datamov) as credito_dia, 
(SELECT IF(sum(valor) IS NULL, 0 , sum(valor)) FROM lc_movimento as L2 WHERE L2.tipo=0 and idconta=1 and L2.datamov = lc_movimento.datamov) as debito_dia,
((SELECT saldo_dia_ant) + (SELECT credito_dia) - (SELECT debito_dia)) as saldo_dia_atual,
(SELECT SUM(valor) FROM lc_movimento AS L3
WHERE tipo=1 and year(L3.datamov) = year(lc_movimento.datamov) and month(L3.datamov) = month(lc_movimento.datamov) and L3.datamov <=
lc_movimento.datamov and 
idconta = lc_movimento.idconta) AS cred_acum_dia,
(SELECT SUM(valor) FROM lc_movimento AS L3
WHERE tipo=0 and year(L3.datamov) = year(lc_movimento.datamov) and month(L3.datamov) = month(lc_movimento.datamov) and L3.datamov <=
lc_movimento.datamov and 
idconta = lc_movimento.idconta) AS deb_acum_dia
 FROM lc_movimento WHERE idconta=1 and month(datamov)=1 and year(datamov)=2015 GROUP by day(datamov) ORDER BY datamov
 ASC;
 
 
 =======================================================================================================
 /* BALANÇO POR INTERVALO DE DATA */
 SELECT idconta,

((SELECT SUM(IF(tipo = 1, valor, 0)) FROM lc_movimento AS L2
WHERE L2.datamov < lc_movimento.datamov and L2.idconta = lc_movimento.idconta)+(SELECT SUM(IF(tipo = 0, -1*valor, 0)) FROM lc_movimento AS L2 WHERE L2.datamov < lc_movimento.datamov and L2.idconta = lc_movimento.idconta)) AS saldo_ant_per,
SUM(IF(lc_movimento.tipo = 1, valor, 0)) AS cred_per,
SUM(IF(lc_movimento.tipo = 0, -1*valor, 0)) AS deb_per,
(SELECT SUM(IF(lc_movimento.tipo = 1, valor, 0))) + (SELECT SUM(IF(lc_movimento.tipo = 0, -1*valor, 0))) as bal_per,
((SELECT SUM(IF(tipo = 1, valor, 0)) FROM lc_movimento AS L2
WHERE L2.datamov < lc_movimento.datamov and L2.idconta = lc_movimento.idconta)+(SELECT SUM(IF(tipo = 0, -1*valor, 0)) FROM lc_movimento AS L2 WHERE L2.datamov < lc_movimento.datamov and L2.idconta = lc_movimento.idconta) + SUM(IF(lc_movimento.tipo = 1, valor, 0)) + SUM(IF(lc_movimento.tipo = 0, -1*valor, 0)) ) as saldo_atual,
(SELECT SUM(IF(tipo = 1, valor, 0)) FROM lc_movimento AS L3
WHERE L3.idconta=lc_movimento.idconta and L3.datamov < lc_movimento.datamov) AS credito_acum,
(SELECT SUM(IF(tipo = 0, -1*valor, 0)) FROM lc_movimento AS L3
WHERE  L3.idconta=lc_movimento.idconta and L3.datamov <= lc_movimento.datamov) AS debito_acum,
() AS x
FROM lc_movimento WHERE idconta = 1 and datamov>='2016-01-17' and datamov<='2016-02-08'
GROUP BY idconta;

================================================================================================================================================================================
bal dia folha

SELECT idconta, datamov, folha, idlivro,
(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2 WHERE L2.datamov < lc_movimento.datamov and L2.idconta = lc_movimento.idconta) AS saldo_dia_ant,

(SELECT IF(SUM(valor) IS NULL, 0, SUM(valor)) FROM lc_movimento as L2 WHERE L2.tipo=1 and idconta=1 and L2.datamov = lc_movimento.datamov) as credito_dia, 
(SELECT IF(sum(valor) IS NULL, 0 , sum(valor)) FROM lc_movimento as L2 WHERE L2.tipo=0 and idconta=1 and L2.datamov = lc_movimento.datamov) as debito_dia,
((SELECT saldo_dia_ant) + (SELECT credito_dia) - (SELECT debito_dia)) as saldo_dia_atual,

(SELECT IF(SUM(valor) IS NULL, 0, SUM(valor)) FROM lc_movimento AS L3 WHERE tipo=1 and L3.datamov <=lc_movimento.datamov and L3.idlivro=lc_movimento.idlivro and L3.folha>=lc_movimento.folha and L3.folha<=lc_movimento.folha and L3.idconta=lc_movimento.idconta) AS cred_acum_dia,

(SELECT SUM(valor) FROM lc_movimento AS L3 WHERE tipo=0 and L3.datamov <=lc_movimento.datamov and L3.idlivro=lc_movimento.idlivro and L3.folha>=lc_movimento.folha and L3.folha<=lc_movimento.folha and L3.idconta=lc_movimento.idconta) AS deb_acum_dia


FROM lc_movimento WHERE idconta=1 and idlivro=2 and folha>=2 and folha<=2 GROUP by day(datamov) ORDER BY datamov ASC;

