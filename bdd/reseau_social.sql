 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0; 
 
drop database if exists reseau_social2;
  create database reseau_social2;
  use reseau_social2;

  create table utilisateur(
     iduser int(3) not null AUTO_INCREMENT,
     nom varchar(50) not null,
     prenom varchar(50) not null,
     email varchar(50) not null,
     pseudo varchar(50) not null,
     age int(3) not null,
     ville varchar(50) not null,
     mdp varchar(50) not null,
     photo varchar(50),
     sexe varchar(50),
     date_inscription datetime not null default current_timestamp,
     primary key(iduser)
  );

  create table Friend (
    iduser int(3) NOT NULL,
    idami int(3) NOT NULL,
    date_ajout datetime not null default current_timestamp,
    primary key (iduser, idami),
    foreign key (iduser) references utilisateur (iduser),
    foreign key (idami) references utilisateur (iduser)
  );

  create table Status(
     Numero int,
     Delai TIME,
     chemin_acces varchar(50),
     primary key(Numero)
  );

  create table Discussion(
     numd int,
     Date_creation DATE,
     primary key(numd)
  );

  create table sessions(
     id_sessions varchar(50),
     iduser int not null,
     primary key(id_sessions),
     foreign key (iduser) references Utilisateur(iduser)
  );

  create table Pages(
     nump int,
     Nomp varchar(50),
     Description int,
     iduser int,
     primary key(nump),
     foreign key (iduser) references Utilisateur(iduser)
  );

  create table Post(
     numposte int,
     lien varchar(50),
     titre varchar(50),
     Description varchar(50),
     iduser int,
     primary key(numposte),
     foreign key (iduser) references Utilisateur(iduser)
  );

  CREATE TABLE Messages(
      idmessage int(3) auto_increment,
      iduser int(3) not null,
      idami int(3) not null,
      texte text not null,
      date_creation datetime not null default current_timestamp,
      primary key (idmessage),
      foreign key (iduser) references Utilisateur(iduser),
      foreign key (idami) references Utilisateur(iduser)
  );

  create table Commentaire(
     idcom int,
     Texte varchar(50),
     numposte int not null,
     iduser int not null,
     primary key(idcom),
     foreign key (numposte) references Post(numposte),
     foreign key (iduser) references Utilisateur(iduser)
  );

  create table Publier(
     iduser int,
     numposte int,
     primary key(iduser, numposte),
     foreign key (iduser) references Utilisateur(iduser),
     foreign key (numposte) references Post(numposte)
  );

  create table Suivre(
     iduser int,
     nump int,
     primary key(iduser, nump),
     foreign key (iduser) references Utilisateur(iduser),
     foreign key (nump) references Pages(nump)
  );

  create table Gerer(
     iduser int,
     nump int,
     primary key(iduser, nump),
     foreign key (iduser) references Utilisateur(iduser),
     foreign key (nump) references Pages(nump)
  );

  create table Poster(
     iduser int,
     Numero int,
     primary key(iduser, Numero),
     foreign key (iduser) references Utilisateur(iduser),
     foreign key (Numero) references Status(Numero)
  );

  create table demandeami(
    iddemande int(3) auto_increment,
    iduser int(3) not null,
    idami int(3) not null,
    statut varchar(50) not null default 'en_attente',
    date_creation datetime not null default current_timestamp,
    primary key(iddemande),
    foreign key (iduser) references utilisateur(iduser),
    foreign key (idami) references utilisateur(iduser)
);

create view amis_communs as
select f1.iduser, f2.iduser AS idami, COUNT(*) AS nbAmisCommuns
from friend f1
inner join friend f2 on f1.idami = f2.idami
where f1.iduser != f2.iduser
group by f1.iduser, f2.iduser;



  insert into utilisateur values
  (null, "FRESNEL", "Jean", "jean@gmail.com", "JJ", 20, "Paris", "123", "img\\profile-1.jpeg", "Homme", null),
  (null, "DUBOIS", "Valérie", "val@gmail.com", "Valou", 21, "Lyon", "123", "img\\profile-2.jpg", "Femme", null);


  insert into Friend (iduser, idami) values
        (1, 2),
        (2, 1);
delimiter //
        create trigger supprimer_demandeami after insert on friend
        for each row
        begin
            delete from demandeami
            where iduser = new.idami
            and idami = new.iduser;
        end //
        
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT;
SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS;
SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION;
SET SQL_NOTES=@OLD_SQL_NOTES;