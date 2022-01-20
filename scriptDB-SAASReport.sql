--excluindo banco de dados

drop database saas_report;

--criando banco de dados

create database saas_report;

--utilizando banco de dados

use saas_report;

--criando tabelas do banco de dados

create table usuarios_cliente(
id_cli int not null auto_increment,
nome_cli varchar(100) not null,
empresa_cli varchar(50) not null,
email_cli varchar(75) not null unique,
senha_cli varchar(100) not null,
telefone_cli char(11) not null unique,
data_hora_cadastro datetime not null,
situacao_cli char(7) not null check(situacao_cli = "ativo" || situacao_cli = "inativo"),
data_limite_acesso datetime not null,
verificacao_cli char(3) not null check(verificacao_cli = "sim" || verificacao_cli = "nao"),
recupera_senha_cli varchar(100),
primary key(id_cli));

create table usuarios_administrador(
id_adm int not null auto_increment,
nome_adm varchar(100) not null,
email_adm_ctt varchar(75) not null unique,
email_adm varchar(75) not null unique,
telefone_adm char(11) not null unique,
senha_adm varchar(100) not null,
primary key(id_adm));
