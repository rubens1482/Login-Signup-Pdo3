SELECT idconta, folha, idlivro,

SUM(IF(lc_movimento.tipo = 1, valor, 0)) AS credito,

SUM(IF(lc_movimento.tipo = 0, -1*valor, 0)) AS debito,

(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE lc_movimento.idlivro = L2.idlivro and lc_movimento.folha = L2.folha
lc_movimento.idconta = L2.idconta) AS bal_mes,

(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE lc_movimento.idlivro >= L2.idlivro and lc_movimento.folha >= L2.folha and
idconta = lc_movimento.idconta) AS saldo_atual,

(SELECT SUM(IF(tipo = 1, valor, -1*valor)) FROM lc_movimento AS L2
WHERE lc_movimento.idlivro > L2.idlivro and 
idconta = lc_movimento.idconta) AS saldo_aa,

(SELECT SUM(valor) FROM lc_movimento AS L3
WHERE tipo=1 and lc_movimento.idlivro = L3.idlivro and lc_movimento.folha >=
L3.folha and 
lc_movimento.idconta = L3.idconta) AS credito_acu,

(SELECT SUM(valor)*-1 FROM lc_movimento AS L3
WHERE tipo=0 and lc_movimento.idlivro = L3.idlivro and lc_movimento.folha >=
L3.folha and 
idconta = lc_movimento.idconta) AS debito_acum

FROM lc_movimento
WHERE idconta=1 and idlivro=1 and folha<=5
GROUP BY idconta, idlivro, folha;