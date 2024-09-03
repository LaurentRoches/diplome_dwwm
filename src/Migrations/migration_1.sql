CREATE TABLE role (
    id_role             Int Auto_increment PRIMARY KEY,
    str_role            Varchar (50) NOT NULL
)ENGINE=InnoDB;

INSERT INTO role (str_role) VALUES ("USER");
INSERT INTO role (str_role) VALUES ("ADMIN");
INSERT INTO role (str_role) VALUES ("MODO");


CREATE TABLE experience (
    id_experience       Int Auto_increment PRIMARY KEY,
    str_niveau          Varchar (150) NOT NULL
)ENGINE=InnoDB;

INSERT INTO experience (str_niveau) VALUES ("Non renseigné");
INSERT INTO experience (str_niveau) VALUES ("Découverte");
INSERT INTO experience (str_niveau) VALUES ("Débutant");
INSERT INTO experience (str_niveau) VALUES ("Amateur");
INSERT INTO experience (str_niveau) VALUES ("Confirmer");
INSERT INTO experience (str_niveau) VALUES ("Expert");


CREATE TABLE profil_image (
    id_profil_image    INT AUTO_INCREMENT PRIMARY KEY,
    str_chemin          VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

INSERT INTO profil_image (str_chemin) VALUES ('img/profil/clerc.jpg');
INSERT INTO profil_image (str_chemin) VALUES ('img/profil/druid.jpg');
INSERT INTO profil_image (str_chemin) VALUES ('img/profil/alchimiste.jpg');
INSERT INTO profil_image (str_chemin) VALUES ('img/profil/ranger.jpg');
INSERT INTO profil_image (str_chemin) VALUES ('img/profil/rogue.jpg');
INSERT INTO profil_image (str_chemin) VALUES ('img/profil/warrior.jpg');
INSERT INTO profil_image (str_chemin) VALUES ('img/profil/wizard.jpg');


CREATE TABLE user (
    id_user             Int Auto_increment PRIMARY KEY,
    str_email           Varchar (255) NOT NULL UNIQUE,
    str_nom             Varchar (255) NOT NULL,
    str_prenom          Varchar (255) NOT NULL,
    dtm_naissance       Datetime NOT NULL,
    bln_active          TINYINT(1) NOT NULL DEFAULT 0,
    str_mdp             Varchar (255) DEFAULT '',
    bln_notif           TINYINT(1) NOT NULL DEFAULT 0,
    str_pseudo          Varchar (255) NOT NULL UNIQUE,
    str_description     Varchar (255) DEFAULT '',
    bln_mj              TINYINT(1) NOT NULL DEFAULT 0,
    id_experience       Int NOT NULL DEFAULT 1,
    id_role             Int NOT NULL DEFAULT 1,
    id_profil_image     Int NOT NULL DEFAULT 1,
    dtm_creation        Datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dtm_maj             Datetime,
    CONSTRAINT id_experience_FK FOREIGN KEY (id_experience) REFERENCES experience(id_experience),
    CONSTRAINT id_role_FK FOREIGN KEY (id_role) REFERENCES role(id_role),
    CONSTRAINT id_profil_image_FK FOREIGN KEY (id_profil_image) REFERENCES profil_image(id_profil_image)
)ENGINE=InnoDB;



INSERT INTO user (
    id_user, 
    str_email, 
    str_nom, 
    str_prenom, 
    dtm_naissance, 
    bln_active, 
    str_mdp, 
    bln_notif, 
    str_pseudo, 
    str_description, 
    id_experience, 
    id_role, 
    id_profil_image, 
    dtm_creation, 
    dtm_maj
) 
VALUES (
    1, 
    'rocheslaurent@gmail.com', 
    'ROCHES', 
    'Laurent', 
    '1989-05-29 00:00:00', 
    1, 
    '$2y$10$ATuiYOkLwkNxB2fdb.ipaOcdu/zwPWpBw83enKXGBgwuM67ED9WD.', 
    0, 
    'Kagelestis', 
    '', 
    1, 
    2, 
    5, 
    '2024-08-26 14:30:43', 
    NULL
);


CREATE TABLE message (
    id_message          Int AUTO_INCREMENT PRIMARY KEY,
    id_expediteur       Int NOT NULL,
    id_destinataire     Int NOT NULL,
    str_message         Varchar (255) NOT NULL,
    dtm_envoi           DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    bln_lu              TINYINT(1) NOT NULL DEFAULT 0,
    CONSTRAINT id_expediteur_FK FOREIGN KEY (id_expediteur) REFERENCES user(id_user),
    CONSTRAINT id_destinataire_FK FOREIGN KEY (id_destinataire) REFERENCES user(id_user)
) ENGINE=InnoDB;


CREATE TABLE avis_user (
    id_avis_user        Int AUTO_INCREMENT PRIMARY KEY,
    id_observateur      Int NOT NULL,
    id_evalue           Int NOT NULL,
    str_avis            Varchar (255) NOT NULL,
    int_note            Int NOT NULL,
    dtm_envoi           DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT id_observateur_FK FOREIGN KEY (id_observateur) REFERENCES user(id_user),
    CONSTRAINT id_evalue_FK FOREIGN KEY (id_evalue) REFERENCES user(id_user)
)ENGINE=InnoDB;


CREATE TABLE reponse_avis_user (
    id_reponse_avis_user        Int AUTO_INCREMENT PRIMARY KEY,
    id_user                     Int NOT NULL,
    id_avis_user                Int NOT NULL,
    str_message                 Varchar (255) NOT NULL,
    dtm_creation                Datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT id_user_reponse_FK FOREIGN KEY (id_user) REFERENCES user(id_user),
    CONSTRAINT id_avis_user_FK FOREIGN KEY (id_avis_user) REFERENCES avis_user(id_avis_user)
)ENGINE=InnoDB;


CREATE TABLE categorie_game (
    id_categorie_game       Int AUTO_INCREMENT PRIMARY KEY,
    str_nom                 Varchar (255) NOT NULL
)ENGINE=InnoDB;

INSERT INTO categorie_game (str_nom) VALUES ("Fantasy");
INSERT INTO categorie_game (str_nom) VALUES ("Space opéra");
INSERT INTO categorie_game (str_nom) VALUES ("Dark Fantasy");
INSERT INTO categorie_game (str_nom) VALUES ("Policier");


CREATE TABLE game (
    id_game                 Int AUTO_INCREMENT PRIMARY KEY,
    str_nom                 Varchar (255) NOT NULL,
    str_resume              VARCHAR (255) NOT NULL,
    txt_description         TEXT NOT NULL,
    id_categorie_game       Int NOT NULL,
    dtm_creation            Datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dtm_maj                 Datetime ,
    CONSTRAINT id_categorie_game_FK FOREIGN KEY (id_categorie_game) REFERENCES categorie_game(id_categorie_game)
)ENGINE=InnoDB;


CREATE TABLE game_connu (
    id_game         Int NOT NULL,
    id_user         Int NOT NULL,
    CONSTRAINT id_game_connu_FK FOREIGN KEY (id_game) REFERENCES game(id_game) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT id_user_game_connu_FK FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (id_game, id_user)
)ENGINE=InnoDB;


CREATE TABLE game_voulu (
    id_game         Int NOT NULL,
    id_user         Int NOT NULL,
    CONSTRAINT id_game_voulu_FK FOREIGN KEY (id_game) REFERENCES game(id_game) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT id_user_game_voulu_FK FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (id_game, id_user)
)ENGINE=InnoDB;


CREATE TABLE disponibilite (
    id_disponibilite    INT AUTO_INCREMENT PRIMARY KEY,
    id_user             INT NOT NULL,
    str_jour            ENUM('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche') NOT NULL,
    time_debut          TIME NOT NULL,
    time_fin            TIME NOT NULL,
    CONSTRAINT id_user_disponibilite_FK FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;


CREATE TABLE categorie_article (
    id_categorie_article    Int AUTO_INCREMENT PRIMARY KEY,
    str_nom                 Varchar (255) NOT NULL
)ENGINE=InnoDB;


CREATE TABLE article (
    id_article              Int AUTO_INCREMENT PRIMARY KEY,
    str_titre               Varchar (255) NOT NULL,
    str_resume              Varchar (255) NOT NULL,
    txt_contenu             TEXT NOT NULL,
    id_user                 Int NOT NULL,
    dtm_creation            Datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dtm_maj                 Datetime ,
    CONSTRAINT id_user_article_FK FOREIGN KEY (id_user) REFERENCES user(id_user)
)ENGINE=InnoDB;


CREATE TABLE liste_categorie_article (
    id_categorie_article        Int NOT NULL,
    id_article                  Int NOT NULL,
    CONSTRAINT id_categorie_article_FK FOREIGN KEY (id_categorie_article) REFERENCES categorie_article(id_categorie_article) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT id_article_FK FOREIGN KEY (id_article) REFERENCES article(id_article) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (id_categorie_article, id_article)
)ENGINE=InnoDB;

CREATE TABLE avis_article (
    id_avis_article         Int AUTO_INCREMENT PRIMARY KEY,
    id_article              Int NOT NULL,
    id_user                 Int NOT NULL,
    str_titre               Varchar (255) NOT NULL,
    str_avis                Varchar (255) NOT NULL,
    dtm_creation            Datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dtm_maj                 Datetime ,
    CONSTRAINT id_article_avis_FK FOREIGN KEY (id_article) REFERENCES article(id_article) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT id_user_FK FOREIGN KEY (id_user) REFERENCES user(id_user)
)ENGINE=InnoDB;