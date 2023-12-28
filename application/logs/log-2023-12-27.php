<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-12-27 10:48:53 --> Query error: Unknown column 'os.veiculo_id' in 'on clause' - Invalid query: SELECT `os`.*, COALESCE((SELECT SUM(produtos_os.preco * produtos_os.quantidade ) FROM produtos_os WHERE produtos_os.os_id = os.idOs), 0) totalProdutos, COALESCE((SELECT SUM(servicos_os.preco * servicos_os.quantidade ) FROM servicos_os WHERE servicos_os.os_id = os.idOs), 0) totalServicos, `clientes`.`idClientes`, `veiculos`.`placa`, `clientes`.`nomeCliente`, `clientes`.`celular` as `celular_cliente`, `usuarios`.`nome`, `garantias`.*
FROM `os`
JOIN `clientes` ON `clientes`.`idClientes` = `os`.`clientes_id`
JOIN `veiculos` ON `veiculos`.`idVeiculos` = `os`.`veiculo_id`
JOIN `usuarios` ON `usuarios`.`idUsuarios` = `os`.`usuarios_id`
LEFT JOIN `garantias` ON `garantias`.`idGarantias` = `os`.`garantias_id`
LEFT JOIN `produtos_os` ON `produtos_os`.`os_id` = `os`.`idOs`
LEFT JOIN `servicos_os` ON `servicos_os`.`os_id` = `os`.`idOs`
GROUP BY `os`.`idOs`
ORDER BY `os`.`idOs` DESC
 LIMIT 10
