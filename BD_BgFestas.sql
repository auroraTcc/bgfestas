create database bgfestas;
use bgfestas;

create table cliente(
	cpf char(14) not null primary key,
    nome varchar(255) not null,
    telefone char(15) not null
);

create table funcionario(
	idFunc char(6) not null primary key,
    nome varchar(255) not null,
    senha varchar (25),
    cargo varchar(10) not null
);

create table produto(
	idProdt INT PRIMARY KEY,
    nome varchar(255) not null,
    qtdDisp int,
    qtdTotal int
);
insert into produto(idProdt, nome, qtdDisp, qtdTotal) values (151,"Jogo completo", 170, 170);
insert into produto(idProdt, nome, qtdDisp, qtdTotal) values (152,"Cadeira avulsa", 680, 680);
insert into produto(idProdt, nome, qtdDisp, qtdTotal) values (153,"Mesa avulsa", 170, 170);

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
    #idResponsavel char(6) not null,
    #stts varchar(30),
    
    constraint fk_pedidoCliente foreign key (cpfCliente) references cliente(cpf)
    #constraint fk_pedidoFunc foreign key (idResponsavel) references funcionario(idFunc)
);

CREATE TABLE carrinho (
    idItem INT AUTO_INCREMENT PRIMARY KEY,
    idPedido INT NOT NULL,
    idProdt INT NOT NULL,
    quantidade INT NOT NULL,
    constraint fk_itensPedido foreign key (idPedido) references pedido(idPedido),
    constraint fk_itensProdt foreign key (idProdt) references produto(idProdt)
);

select * from cliente;
select * from pedido;
select * from carrinho;

