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
INSERT INTO experience (str_niveau) VALUES ("Confirmé");
INSERT INTO experience (str_niveau) VALUES ("Expert");


CREATE TABLE profil_image (
    id_profil_image    INT AUTO_INCREMENT PRIMARY KEY,
    str_chemin         VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

INSERT INTO profil_image (str_chemin) VALUES ('img/profil/clerc.png');
INSERT INTO profil_image (str_chemin) VALUES ('img/profil/druid.png');
INSERT INTO profil_image (str_chemin) VALUES ('img/profil/alchimiste.png');
INSERT INTO profil_image (str_chemin) VALUES ('img/profil/ranger.png');
INSERT INTO profil_image (str_chemin) VALUES ('img/profil/rogue.png');
INSERT INTO profil_image (str_chemin) VALUES ('img/profil/warrior.png');
INSERT INTO profil_image (str_chemin) VALUES ('img/profil/wizard.png');


CREATE TABLE user (
    id_user                 Int Auto_increment PRIMARY KEY,
    str_email               Varchar (255) NOT NULL UNIQUE,
    str_nom                 Varchar (255) NOT NULL,
    str_prenom              Varchar (255) NOT NULL,
    dtm_naissance           Datetime NOT NULL,
    bln_active              TINYINT(1) NOT NULL DEFAULT 0,
    str_mdp                 Varchar (255) DEFAULT '',
    str_token               Varchar (100) DEFAULT '',
    str_pseudo              Varchar (255) NOT NULL UNIQUE,
    str_description         Varchar (255) DEFAULT '',
    bln_mj                  TINYINT(1) NOT NULL DEFAULT 0,
    id_experience           Int NOT NULL DEFAULT 1,
    id_role                 Int NOT NULL DEFAULT 1,
    id_profil_image         Int NOT NULL DEFAULT 1,
    dtm_creation            Datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dtm_maj                 Datetime,
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
    str_token,
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
    '',
    'Kagelestis', 
    'Administrateur du site JDRConnexion', 
    1, 
    2, 
    5, 
    '2024-08-26 14:30:43', 
    NULL
);
INSERT INTO user (
    id_user, 
    str_email, 
    str_nom, 
    str_prenom, 
    dtm_naissance, 
    bln_active, 
    str_mdp, 
    str_token,
    str_pseudo, 
    str_description, 
    id_experience, 
    id_role, 
    id_profil_image, 
    dtm_creation, 
    dtm_maj
) 
VALUES (
    2, 
    'archived@user.fr', 
    'Utilisateur supprimer', 
    'Utilisateur supprimer', 
    '1989-05-29 00:00:00', 
    1, 
    '$2y$10$ATuiYOkLwkNxB2fdb.ipaOcdu/zwPWpBw83enKXGBgwuM67ED9WD.', 
    '',
    'Utilisateur supprimer', 
    'Utilisateur supprimer', 
    1, 
    2, 
    5, 
    '2024-08-26 14:30:44', 
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
    bln_aime            TINYINT(1) NOT NULL DEFAULT 0,
    dtm_creation        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dtm_maj             Datetime,
    CONSTRAINT id_observateur_FK FOREIGN KEY (id_observateur) REFERENCES user(id_user),
    CONSTRAINT id_evalue_FK FOREIGN KEY (id_evalue) REFERENCES user(id_user)
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
    str_chemin_img_1        VARCHAR(255) NOT NULL,
    str_titre_section_1     Varchar (255) NOT NULL,
    txt_section_1           TEXT NOT NULL,
    str_chemin_img_2        VARCHAR(255) NOT NULL,
    str_titre_section_2     Varchar (255) NOT NULL,
    txt_section_2           TEXT NOT NULL,
    id_user                 Int NOT NULL,
    dtm_creation            Datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dtm_maj                 Datetime,
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


CREATE TABLE tabou (
    id_tabou            Int AUTO_INCREMENT PRIMARY KEY,
    str_mot             Varchar (100) NOT NULL UNIQUE
)ENGINE=InnoDB;

INSERT INTO tabou (str_mot) VALUES ("pute");
INSERT INTO tabou (str_mot) VALUES ("salope");
INSERT INTO tabou (str_mot) VALUES ("petasse");
INSERT INTO tabou (str_mot) VALUES ("connard");
INSERT INTO tabou (str_mot) VALUES ("batard");
INSERT INTO tabou (str_mot) VALUES ("encule");
INSERT INTO tabou (str_mot) VALUES ("vie vite l'air");
INSERT INTO tabou (str_mot) VALUES ("noix regale singe");
INSERT INTO tabou (str_mot) VALUES ("mein kampf");
INSERT INTO tabou (str_mot) VALUES ("reich");
INSERT INTO tabou (str_mot) VALUES ("milf");
INSERT INTO tabou (str_mot) VALUES ("debilos");
INSERT INTO tabou (str_mot) VALUES ("morveux");
INSERT INTO tabou (str_mot) VALUES ("debile");
INSERT INTO tabou (str_mot) VALUES ("double pene");
INSERT INTO tabou (str_mot) VALUES ("spank me");
INSERT INTO tabou (str_mot) VALUES ("vibromasseur");
INSERT INTO tabou (str_mot) VALUES ("god michel");
INSERT INTO tabou (str_mot) VALUES ("dildo");
INSERT INTO tabou (str_mot) VALUES ("plug");
INSERT INTO tabou (str_mot) VALUES ("anal");
INSERT INTO tabou (str_mot) VALUES ("sodomie");
INSERT INTO tabou (str_mot) VALUES ("felation");
INSERT INTO tabou (str_mot) VALUES ("cock");
INSERT INTO tabou (str_mot) VALUES ("youporn");
INSERT INTO tabou (str_mot) VALUES ("spankwire");
INSERT INTO tabou (str_mot) VALUES ("porn");
INSERT INTO tabou (str_mot) VALUES ("pronhub");
INSERT INTO tabou (str_mot) VALUES ("xhamster");
INSERT INTO tabou (str_mot) VALUES ("only fan");
INSERT INTO tabou (str_mot) VALUES ("onlyfan");
INSERT INTO tabou (str_mot) VALUES ("nude");
INSERT INTO tabou (str_mot) VALUES ("porno");
INSERT INTO tabou (str_mot) VALUES ("cocaine");
INSERT INTO tabou (str_mot) VALUES ("shit");
INSERT INTO tabou (str_mot) VALUES ("mongol");
INSERT INTO tabou (str_mot) VALUES ("tapette");
INSERT INTO tabou (str_mot) VALUES ("tarlouze");
INSERT INTO tabou (str_mot) VALUES ("sale gros");
INSERT INTO tabou (str_mot) VALUES ("gros porc");
INSERT INTO tabou (str_mot) VALUES ("motherfucker");
INSERT INTO tabou (str_mot) VALUES ("fuck");
INSERT INTO tabou (str_mot) VALUES ("bitch");
INSERT INTO tabou (str_mot) VALUES ("marie-toutoule");
INSERT INTO tabou (str_mot) VALUES ("tchoin");
INSERT INTO tabou (str_mot) VALUES ("grognasse");
INSERT INTO tabou (str_mot) VALUES ("chibre");
INSERT INTO tabou (str_mot) VALUES ("enfoire");
INSERT INTO tabou (str_mot) VALUES ("mort au flic");
INSERT INTO tabou (str_mot) VALUES ("couille");
INSERT INTO tabou (str_mot) VALUES ("sale blanc");
INSERT INTO tabou (str_mot) VALUES ("sale arabe");
INSERT INTO tabou (str_mot) VALUES ("anti-juif");
INSERT INTO tabou (str_mot) VALUES ("chintok");
INSERT INTO tabou (str_mot) VALUES ("bamboula");
INSERT INTO tabou (str_mot) VALUES ("bicot");
INSERT INTO tabou (str_mot) VALUES ("bougnoule");
INSERT INTO tabou (str_mot) VALUES ("nigger");
INSERT INTO tabou (str_mot) VALUES ("negro");
INSERT INTO tabou (str_mot) VALUES ("hitler");
INSERT INTO tabou (str_mot) VALUES ("salaud");
INSERT INTO tabou (str_mot) VALUES ("faire foutre");
INSERT INTO tabou (str_mot) VALUES ("faire enculer");
INSERT INTO tabou (str_mot) VALUES ("faire mettre");
INSERT INTO tabou (str_mot) VALUES ("bite");
INSERT INTO tabou (str_mot) VALUES ("cul");
INSERT INTO tabou (str_mot) VALUES ("putain");
INSERT INTO tabou (str_mot) VALUES ("putin");
INSERT INTO tabou (str_mot) VALUES ("merde");
INSERT INTO tabou (str_mot) VALUES ("pd");
INSERT INTO tabou (str_mot) VALUES ("quoicoubeh");
INSERT INTO tabou (str_mot) VALUES ("Holocaust");
INSERT INTO tabou (str_mot) VALUES ("deportation");
INSERT INTO tabou (str_mot) VALUES ("cheh");
INSERT INTO tabou (str_mot) VALUES ("a la mords-moi");
INSERT INTO tabou (str_mot) VALUES ("con");
INSERT INTO tabou (str_mot) VALUES ("a chier");
INSERT INTO tabou (str_mot) VALUES ("aller liberer Mandela");
INSERT INTO tabou (str_mot) VALUES ("niquer");
INSERT INTO tabou (str_mot) VALUES ("alibofi");
INSERT INTO tabou (str_mot) VALUES ("bibite");
INSERT INTO tabou (str_mot) VALUES ("biatch");
INSERT INTO tabou (str_mot) VALUES ("enculer");
INSERT INTO tabou (str_mot) VALUES ("archinul");
INSERT INTO tabou (str_mot) VALUES ("archifoutre");
INSERT INTO tabou (str_mot) VALUES ("archicon");
INSERT INTO tabou (str_mot) VALUES ("sperm");
INSERT INTO tabou (str_mot) VALUES ("foutre");
INSERT INTO tabou (str_mot) VALUES ("avoir la gaule");
INSERT INTO tabou (str_mot) VALUES ("baisable");
INSERT INTO tabou (str_mot) VALUES ("baise");
INSERT INTO tabou (str_mot) VALUES ("baiser");
INSERT INTO tabou (str_mot) VALUES ("bande-mou");
INSERT INTO tabou (str_mot) VALUES ("balek");
INSERT INTO tabou (str_mot) VALUES ("biffle");
INSERT INTO tabou (str_mot) VALUES ("bitembois");
INSERT INTO tabou (str_mot) VALUES ("bifle");
INSERT INTO tabou (str_mot) VALUES ("blc");
INSERT INTO tabou (str_mot) VALUES ("bordel à");
INSERT INTO tabou (str_mot) VALUES ("bander comme");
INSERT INTO tabou (str_mot) VALUES ("partouze");
INSERT INTO tabou (str_mot) VALUES ("boucake");
INSERT INTO tabou (str_mot) VALUES ("boukak");
INSERT INTO tabou (str_mot) VALUES ("boucaque");
INSERT INTO tabou (str_mot) VALUES ("branlette");
INSERT INTO tabou (str_mot) VALUES ("branleur");
INSERT INTO tabou (str_mot) VALUES ("gang bang");
INSERT INTO tabou (str_mot) VALUES ("bullshit");
INSERT INTO tabou (str_mot) VALUES ("catin");
INSERT INTO tabou (str_mot) VALUES ("chienasse");
INSERT INTO tabou (str_mot) VALUES ("cochonne");
INSERT INTO tabou (str_mot) VALUES ("gueunon");
INSERT INTO tabou (str_mot) VALUES ("connaud");
INSERT INTO tabou (str_mot) VALUES ("conne");
INSERT INTO tabou (str_mot) VALUES ("connerie");
INSERT INTO tabou (str_mot) VALUES ("conneau");
INSERT INTO tabou (str_mot) VALUES ("culbuter");
INSERT INTO tabou (str_mot) VALUES ("culbute");
INSERT INTO tabou (str_mot) VALUES ("dtc");
INSERT INTO tabou (str_mot) VALUES ("ducon");
INSERT INTO tabou (str_mot) VALUES ("ducon-la-joie");
INSERT INTO tabou (str_mot) VALUES ("emmancher");
INSERT INTO tabou (str_mot) VALUES ("emmerde");
INSERT INTO tabou (str_mot) VALUES ("emmerder");
INSERT INTO tabou (str_mot) VALUES ("fdp");
INSERT INTO tabou (str_mot) VALUES ("pedes");
INSERT INTO tabou (str_mot) VALUES ("puterie");
INSERT INTO tabou (str_mot) VALUES ("garce");
INSERT INTO tabou (str_mot) VALUES ("fion");
INSERT INTO tabou (str_mot) VALUES ("fiotte");
INSERT INTO tabou (str_mot) VALUES ("fister");
INSERT INTO tabou (str_mot) VALUES ("fouf");
INSERT INTO tabou (str_mot) VALUES ("foufoune");
INSERT INTO tabou (str_mot) VALUES ("foufounette");
INSERT INTO tabou (str_mot) VALUES ("fucker");
INSERT INTO tabou (str_mot) VALUES ("imbaisable");
INSERT INTO tabou (str_mot) VALUES ("imbitable");
INSERT INTO tabou (str_mot) VALUES ("lopette");
INSERT INTO tabou (str_mot) VALUES ("merdasse");
INSERT INTO tabou (str_mot) VALUES ("nardinamouk");
INSERT INTO tabou (str_mot) VALUES ("nèg");
INSERT INTO tabou (str_mot) VALUES ("nikoumouk");
INSERT INTO tabou (str_mot) VALUES ("nique");
INSERT INTO tabou (str_mot) VALUES ("ntm");
INSERT INTO tabou (str_mot) VALUES ("nulach");
INSERT INTO tabou (str_mot) VALUES ("zob");
INSERT INTO tabou (str_mot) VALUES ("pepom");
INSERT INTO tabou (str_mot) VALUES ("pine");
INSERT INTO tabou (str_mot) VALUES ("piner");
INSERT INTO tabou (str_mot) VALUES ("pineur");
INSERT INTO tabou (str_mot) VALUES ("popaul");
INSERT INTO tabou (str_mot) VALUES ("putalike");
INSERT INTO tabou (str_mot) VALUES ("putassier");
INSERT INTO tabou (str_mot) VALUES ("pvtin");
INSERT INTO tabou (str_mot) VALUES ("pvtain");
INSERT INTO tabou (str_mot) VALUES ("queutard");
INSERT INTO tabou (str_mot) VALUES ("queutarde");
INSERT INTO tabou (str_mot) VALUES ("raton");
INSERT INTO tabou (str_mot) VALUES ("roubignole");
INSERT INTO tabou (str_mot) VALUES ("shnek");
INSERT INTO tabou (str_mot) VALUES ("shleu");
INSERT INTO tabou (str_mot) VALUES ("se doigter");
INSERT INTO tabou (str_mot) VALUES ("se taper une");
INSERT INTO tabou (str_mot) VALUES ("se taper un");
INSERT INTO tabou (str_mot) VALUES ("suceuse");
INSERT INTO tabou (str_mot) VALUES ("suceur");
INSERT INTO tabou (str_mot) VALUES ("ta gueule");
INSERT INTO tabou (str_mot) VALUES ("tagueule");
INSERT INTO tabou (str_mot) VALUES ("tantouze");
INSERT INTO tabou (str_mot) VALUES ("taspe");
INSERT INTO tabou (str_mot) VALUES ("tepu");
INSERT INTO tabou (str_mot) VALUES ("teub");
INSERT INTO tabou (str_mot) VALUES ("teube");
INSERT INTO tabou (str_mot) VALUES ("techa");
INSERT INTO tabou (str_mot) VALUES ("teucha");
INSERT INTO tabou (str_mot) VALUES ("teuch");
INSERT INTO tabou (str_mot) VALUES ("tg");
INSERT INTO tabou (str_mot) VALUES ("tringler");
INSERT INTO tabou (str_mot) VALUES ("troncher");
INSERT INTO tabou (str_mot) VALUES ("trou de balle");
INSERT INTO tabou (str_mot) VALUES ("trouduc");
INSERT INTO tabou (str_mot) VALUES ("troufion");
INSERT INTO tabou (str_mot) VALUES ("zboob");
INSERT INTO tabou (str_mot) VALUES ("zboube");
INSERT INTO tabou (str_mot) VALUES ("zguegue");