CREATE DATABASE cadastraUsuarios; 
USE cadastraUsuarios; 

CREATE TABLE cadastro_usuario(
id_usuario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
fullname VARCHAR(100) NOT NULL,
datanasc DATE NOT NULL,
email VARCHAR(100) NOT NULL UNIQUE,
senha VARCHAR(500) NOT NULL,
confsenha VARCHAR(500) NOT NULL,
cpf VARCHAR(15) UNIQUE,
tipo_plano VARCHAR(15) NOT NULL, 
token VARCHAR(10),
confirmacao int(1) DEFAULT 0
); 


CREATE TABLE dados_pagamento(
id_pagamento INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
numcartao VARCHAR(19) NOT NULL,
validcartao DATE NOT NULL,
codseg VARCHAR(4) NOT NULL,
nametit VARCHAR(50) NOT NULL,
cpf VARCHAR(15),
FOREIGN KEY (cpf) REFERENCES cadastro_usuario(cpf)
); 



CREATE TABLE recuperacao_senha( 
id_recuperacao INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
token VARCHAR(10),
id_usuario VARCHAR(100) NOT NULL, 
datarec DATETIME NOT NULL, 
dataexp DATETIME NOT NULL, 
utilizacao INT NOT NULL
); 


CREATE TABLE filme(
id_filme INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
titulo VARCHAR(150) NOT NULL, 
id_genero INT NOT NULL,
ano INT NOT NULL, 
duracao INT NOT NULL, 
relevancia FLOAT NOT NULL, 
sinopse VARCHAR(5000),
trailer VARCHAR(300),
FOREIGN KEY (id_genero) REFERENCES genero(id_genero)
); 


CREATE TABLE genero( 
id_genero INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
genero VARCHAR(150)
); 


INSERT 
  INTO filme (titulo,id_genero,ano,duracao,relevancia,sinopse,trailer) 
VALUES ('Amor e Monstros',3,2021,109,95,'Sete anos depois de sobreviver ao apocalipse dos monstros, o fofo e azarado Joel abandona seu bunker aconchegante para a ex','https://www.youtube.com/watch?v=AaUdMfh5j3U');


INSERT 
  INTO filme (titulo,id_genero,ano,duracao,relevancia,sinopse,trailer) 
VALUES ('Esquadrão Trovão',1,2021,107,93,'Duas amigas de infância se reencontram e acabam formando uma dupla de super-heroínas quando uma delas cria uma fórmula que dá superpoderes a pessoas comuns','https://www.youtube.com/watch?v=-2K4wYaLOnM');


INSERT 
  INTO filme (titulo,id_genero,ano,duracao,relevancia,sinopse,trailer) 
VALUES ('Sombra e Ossos',11,2021,500,98,'Em um mundo destruído pela guerra, a órfã Alina Starkov descobre que tem poderes extraordinários e vira alvo de forças sombrias','<iframe width="560" height="315" src="https://www.youtube.com/embed/jLKiB0kNk5A" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');


INSERT 
  INTO filme (titulo,id_genero,ano,duracao,relevancia,sinopse,trailer) 
VALUES ('Expresso do Amanhã',7,2020,60,98,'Os únicos sobreviventes de uma fracassada tentativa de conter o aquecimento global são obrigados a viver em um trem separados em vagões que determinam sua condição social.','<iframe width="560" height="315" src="https://www.youtube.com/embed/zstihByJe9I" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');


INSERT 
  INTO genero(genero) 
 VALUES ('Comédia'),('Romance'),('Aventura'),('Ação'),('Terror'),('Suspense'),('Ficção Científica'),('Infantil'),('Documentário'),('Drama'),('Fantasia');





