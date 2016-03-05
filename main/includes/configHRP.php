<?php

try {
    $dsn = 'mysql:dbname=hrp_interaktiv;host=localhost';
    $username = 'hrp-interaktiv.hu';
    $password = imap_base64("WDdhV0k0TVQ");

    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // Error handling

    $query = 'CREATE TABLE IF NOT EXISTS szerepkor (
         id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
         nev VARCHAR(12) NOT NULL
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS jogosultsaglista (
         szerepkorId INT NOT NULL,
         engedely VARCHAR(12) NOT NULL,
         PRIMARY KEY (szerepkorId, engedely),
         FOREIGN KEY (szerepkorId) REFERENCES szerepkor(id) ON DELETE CASCADE
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS felhasznalo (
         e-mail CHAR(50) NOT NULL,
         felh_nev VARCHAR(20) NOT NULL,
         jelszo VARCHAR(20) NOT NULL,
         vez_nev VARCHAR(25) NOT NULL,
         ker_nev VARCHAR(25) NOT NULL,
         elonev VARCHAR(20),
         telefon VARCHAR(16),
         vallalat_nev VARCHAR(40) NOT NULL,
         vallalat_telephely VARCHAR(50),
         lakhely_varos VARCHAR(25) NOT NULL,
         lakhely_varosresz VARCHAR(25),
         reg_datum TIMESTAMP NOT NULL,
         ut_belepes TIMESTAMP,
         szerepkorId INT NOT NULL,
         PRIMARY KEY (e-mail, felh_nev)
         FOREIGN KEY (szerepkorId) REFERENCES szerepkor(id) ON UPDATE CASCADE
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS erdeklodo (
         id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
         gen_jelszo VARCHAR(20) NOT NULL,
         vez_nev VARCHAR(25) NOT NULL,
         ker_nev VARCHAR(25) NOT NULL,
         elonev VARCHAR(20),
         e-mail CHAR(50) NOT NULL,
         telefon VARCHAR(16),
         vallalat VARCHAR(40) NOT NULL,
         reg_datum TIMESTAMP NOT NULL,
      ) ENGINE=InnoDB CHARSET=utf8;';

    $conn->exec($query);

} catch(PDOException $e) {
    // Something went wrong rollback!
    $conn->rollBack();
    echo $e->getMessage(); // Remove or change message in production code
}


/*
$another = '
      CREATE TABLE IF NOT EXISTS kerdes (
         id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
         kerdes VARCHAR(130) NOT NULL,
         felv_datuma TIMESTAMP NOT NULL,
         gyakorisag INT,
         eltalaljak INT,
         elrontjak INT,
         vilagFelev CHAR(11) NOT NULL,
         FOREIGN KEY (vilagFelev) REFERENCES vilag(felev) ON UPDATE CASCADE ON DELETE CASCADE
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS valaszlehetosegek (
         melyik_helyes INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
         kerdesId INT NOT NULL,
         valaszlehetoseg VARCHAR(150) NOT NULL,
         FOREIGN KEY (kerdesId) REFERENCES kerdes(id) ON UPDATE CASCADE ON DELETE CASCADE
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS valasz (
         melyik_helyes INT NOT NULL,
         kerdesId INT NOT NULL,
         PRIMARY KEY (melyik_helyes, kerdesId),
         FOREIGN KEY (kerdesId) REFERENCES kerdes(id) ON UPDATE CASCADE ON DELETE CASCADE,
         FOREIGN KEY (melyik_helyes) REFERENCES valaszlehetosegek(melyik_helyes) ON UPDATE CASCADE ON DELETE CASCADE
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS kitolti (
         felhasznaloEha CHAR(11) NOT NULL,
         vilagFelev CHAR(11),
         sorszam INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
         datum TIMESTAMP NOT NULL,
         raford_ido INT NOT NULL,
         pontszam INT NOT NULL,
         pontszam_per_kerdes DECIMAL(3, 2) NOT NULL,
         FOREIGN KEY (felhasznaloEha) REFERENCES felhasznalo(eha) ON DELETE CASCADE,
         FOREIGN KEY (vilagFelev) REFERENCES vilag(felev) ON UPDATE CASCADE ON DELETE SET NULL
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS hozzaad (
         felhasznaloEha CHAR(11) NOT NULL,
         kerdesId INT NOT NULL,
         vilagFelev CHAR(11) NOT NULL,
         PRIMARY KEY (felhasznaloEha, kerdesId, vilagFelev),
         FOREIGN KEY (felhasznaloEha) REFERENCES felhasznalo(eha),
         FOREIGN KEY (kerdesId) REFERENCES kerdes(id) ON UPDATE CASCADE ON DELETE CASCADE,
         FOREIGN KEY (vilagFelev) REFERENCES vilag(felev) ON UPDATE CASCADE
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS torol (
         felhasznaloEha CHAR(11) NOT NULL,
         kerdesId INT NOT NULL,
         vilagFelev CHAR(11) NOT NULL,
         PRIMARY KEY (felhasznaloEha, kerdesId, vilagFelev),
         FOREIGN KEY (felhasznaloEha) REFERENCES felhasznalo(eha),
         FOREIGN KEY (kerdesId) REFERENCES kerdes(id) ON UPDATE CASCADE ON DELETE CASCADE,
         FOREIGN KEY (vilagFelev) REFERENCES vilag(felev) ON UPDATE CASCADE
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS modosit (
         felhasznaloEha CHAR(11) NOT NULL,
         kerdesId INT NOT NULL,
         vilagFelev CHAR(11) NOT NULL,
         PRIMARY KEY (felhasznaloEha, kerdesId, vilagFelev),
         FOREIGN KEY (felhasznaloEha) REFERENCES felhasznalo(eha),
         FOREIGN KEY (kerdesId) REFERENCES kerdes(id) ON UPDATE CASCADE ON DELETE CASCADE,
         FOREIGN KEY (vilagFelev) REFERENCES vilag(felev) ON UPDATE CASCADE
      ) ENGINE=InnoDB CHARSET=utf8;';

$parameters = array($_GET['string_col'], $_GET['int_col'], $user_id);

$statement = $conn->prepare($query);

$statement->execute($parameters);

*/