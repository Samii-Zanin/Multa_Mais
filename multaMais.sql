CREATE TABLE `policial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(155) DEFAULT NULL,
  `cargo` varchar(155) DEFAULT NULL,
  `local_servico` varchar(155) DEFAULT NULL,
  `departamento` varchar(155) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `usuario` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `motoristas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `num_cnh` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `cpf_cnpj` varchar(14) NOT NULL,
  `pontos_cnh` int(2) DEFAULT NULL,
  `validade_cnh` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf_cnpj` (`cpf_cnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `carros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modelo` varchar(100) DEFAULT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `placa` varchar(10) DEFAULT NULL,
  `ano` int(11) DEFAULT NULL,
  `motorista_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_placa` (`placa`),
  KEY `motorista_id` (`motorista_id`),
  CONSTRAINT `carros_ibfk_1` FOREIGN KEY (`motorista_id`) REFERENCES `motoristas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `multa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_motorista` int(11) DEFAULT NULL,
  `id_carro` int(11) DEFAULT NULL,
  `id_policial` int(11) DEFAULT NULL,
  `valor` decimal(10,0) DEFAULT NULL,
  `tipo_infracao` varchar(155) NOT NULL,
  `descricao` longtext DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `data` datetime DEFAULT current_timestamp(),
  `uf` varchar(2) DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Aguardando Pagamento',
  `data_vencimento` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `multa_ibfk_1` FOREIGN KEY (`id_motorista`) REFERENCES `motoristas` (`id`),
  CONSTRAINT `multa_ibfk_2` FOREIGN KEY (`id_carro`) REFERENCES `carros` (`id`),
  CONSTRAINT `multa_ibfk_3` FOREIGN KEY (`id_policial`) REFERENCES `policial` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
