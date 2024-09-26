create database bgfestas;
use bgfestas;

create table cliente(
	cpf char(14) not null primary key,
    nome varchar(255) not null,
    telefone char(15) not null
);

create table funcionario(
	cpf char(14) not null primary key,
    nome varchar(255) not null,
    senha varchar (25),
    cargo varchar(10) not null
);
INSERT INTO funcionario (idProdt, nome, senha, cargo) VALUES ('652.369.700-24','Gilson Mangia', 'BGfestas001', 'Gerente');

CREATE TABLE produto (
    idProdt INT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    qtdDisp INT,
    qtdTotal INT,
    preco DECIMAL(10, 2)
);

INSERT INTO produto (idProdt, nome, qtdDisp, qtdTotal, preco) VALUES (151, 'Jogo completo', 170, 170, 10.00);
INSERT INTO produto (idProdt, nome, qtdDisp, qtdTotal, preco) VALUES (152, 'Cadeira avulsa', 680, 680, 5.00);
INSERT INTO produto (idProdt, nome, qtdDisp, qtdTotal, preco) VALUES (153, 'Mesa avulsa', 170, 170, 2.00);


create table pedido(
	idPedido INT AUTO_INCREMENT PRIMARY KEY,
    cep varchar(9) not null,
    endereco varchar(255) not null,
    numero int not null,
    complemento varchar(255),
    bairro varchar(255) not null,
    cidade varchar(255) not null,
    dataEntg date not null,
    horaEntg time not null,
    dataRet date not null,
    horaRet time not null,
    cpfCliente char(14) not null,
    telefone char(15) not null,
    preco decimal(10,2),
    cpfResponsavel int not null DEFAULT '652.369.700-24',
    stts varchar(30) DEFAULT 'entrega',
    
    constraint fk_pedidoCliente foreign key (cpfCliente) references cliente(cpf)
    constraint fk_pedidoFunc foreign key (cpfResponsavel) references funcionario(cpf)
);

CREATE TABLE carrinho (
    idItem INT AUTO_INCREMENT PRIMARY KEY,
    idPedido INT NOT NULL,
    idProdt INT NOT NULL,
    quantidade INT NOT NULL,
    constraint fk_itensPedido foreign key (idPedido) references pedido(idPedido),
    constraint fk_itensProdt foreign key (idProdt) references produto(idProdt)
);
