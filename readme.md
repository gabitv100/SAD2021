Sistema de apoio a decisão com análise de dados eleitorais.

Utilizando dados das eleições ordinárias de 2020 em Mato Grosso e verificando se o poderio econômico pode alterar o resultado do pleito.

Para utilizar.
  1. Baixe os php's e execute em servidor php>7
  2. Baixe o script sql e execute no sgbd de sua preferencia(configure o sgbd dentro dos php!)
  3. A tabela fato é muito grande para inserir no github então precisará acessar os dados do tse e extrair novamente os dados. O create para esta tabela:
  
  CREATE TABLE `fato` (
  `Nome` varchar(25) DEFAULT NULL,
  `Numero` varchar(6) DEFAULT NULL,
  `Situacao` varchar(12) DEFAULT NULL,
  `DespesaTotal` double(10,2) DEFAULT NULL,
  `Municipio` varchar(15) DEFAULT NULL,
  `Partido` varchar(15) DEFAULT NULL,
  `Cargo` varchar(8) NOT NULL
)
