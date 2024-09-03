create database BG_festas;
use BG_festas;

create table cliente (
	cpf char(11) not null primary key,
    nome varchar(255) not null,
    endereco varchar(255) not null,
    bairro varchar(255) not null,
    email varchar(255) not null,
    contato char(11) not null
);

create table funcionario(
	id_func char(6) not null primary key,
    nome varchar(255) not null,
    senha varchar (25),
    cargo varchar(10) not null
);

create table produto(
	id_prodt INT AUTO_INCREMENT PRIMARY KEY,
    nome varchar(255) not null,
    descricao varchar(255) not null,
    preco decimal(10,2) not null,
    imagem varchar(255)
);

create table pedido(
	id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_carr int not null,
    endereco varchar(255) not null,
    bairro varchar(255) not null,
    data_entg date not null,
    horario time not null,
    cpf_cliente varchar(255) not null,
    contato char(11) not null,
    id_responsavel varchar(255) not null,
    stts varchar(30),
    
    constraint fk_pedidoCliente foreign key (cpf_cliente) references cliente(cpf),
	constraint fk_pedidoCarr foreign key (id_carr) references carinho(id_carr),
    constraint fk_pedidoFunc foreign key (id_responsavel) references funcionario(id_func)
);

CREATE TABLE carrinho (
    id_carr INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente char(11) not null,
    id_prodt INT,
    quantidade INT,
    constraint fk_carrinhoCliente foreign key (id_cliente) references cliente(cpf),
    constraint fk_carrinhoProdt foreign key (id_prodt) references produto(id_prodt)
);

CREATE TABLE pedido_itens (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    id_prodt INT NOT NULL,
    quantidade INT NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    constraint fk_itensPedido foreign key (id_pedido) references pedido(id_pedido),
    constraint fk_itensProdt foreign key (id_prodt) references produto(id_prodt)
);
 
