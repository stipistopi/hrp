<?php

try {
    $dsn = 'mysql:dbname=hrp_interaktiv;host=localhost';
    $username = 'hrp-interaktiv.h';
    $password = base64_decode("WDdhV0k0TVQ");

    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Error handling

    /*
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
      CREATE TABLE IF NOT EXISTS ceg (
         id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
         vallalat_nev VARCHAR(40) NOT NULL UNIQUE
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS telephely (
         cegId INT NOT NULL,
         vallalat_telephely VARCHAR(50) NOT NULL,
         PRIMARY KEY (cegId, vallalat_telephely),
         FOREIGN KEY (cegId) REFERENCES ceg(id) ON DELETE CASCADE
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS kartya (
         kartya_id CHAR(15) PRIMARY KEY NOT NULL,
         cegId INT NOT NULL,
         aktiv BOOLEAN DEFAULT "0" NOT NULL,
         kezdo_nap DATE,
         vallalat_telephely VARCHAR(50),
         FOREIGN KEY (cegId) REFERENCES ceg(id) ON DELETE CASCADE
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS felhasznalo (
         email VARCHAR(50) PRIMARY KEY NOT NULL,
         felh_nev VARCHAR(20) UNIQUE NOT NULL,
         kartyaId CHAR(15),
         jelszo VARCHAR(20) NOT NULL,
         vez_nev VARCHAR(25) NOT NULL,
         ker_nev VARCHAR(25) NOT NULL,
         elonev VARCHAR(20),
         telefon VARCHAR(16),
         lakhely_varos VARCHAR(25) NOT NULL,
         lakhely_varosresz VARCHAR(25),
         reg_datum TIMESTAMP NOT NULL,
         ut_belepes TIMESTAMP,
         szerepkorId INT,
         FOREIGN KEY (szerepkorId) REFERENCES szerepkor(id) ON UPDATE CASCADE ON DELETE SET NULL,
         FOREIGN KEY (kartyaId) REFERENCES kartya(kartya_id) ON UPDATE CASCADE ON DELETE SET NULL
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS erdeklodo (
         sorszam INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
         gen_jelszo CHAR(10) NOT NULL,
         vez_nev VARCHAR(25) NOT NULL,
         ker_nev VARCHAR(25) NOT NULL,
         elonev VARCHAR(20),
         email VARCHAR(50) NOT NULL,
         telefon VARCHAR(16),
         vallalat VARCHAR(40) NOT NULL,
         reg_datum TIMESTAMP NOT NULL
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS statisztika (
         id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
         nev VARCHAR(20) NOT NULL,
         leiras VARCHAR(50),
         ertek VARCHAR(10) NOT NULL
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS idoablakok (
         id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
         nev VARCHAR(20) NOT NULL,
         leiras VARCHAR(50),
         ertek INT NOT NULL,
         kell_email BOOLEAN DEFAULT "0" NOT NULL
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS teszt (
         id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
         nev VARCHAR(20) NOT NULL,
         leiras VARCHAR(200),
         idoablakId INT,
         FOREIGN KEY (idoablakId) REFERENCES idoablakok(id) ON UPDATE CASCADE ON DELETE SET NULL
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS kerdes (
         id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
         kerdes VARCHAR(200) NOT NULL,
         tesztId INT NOT NULL,
         FOREIGN KEY (tesztId) REFERENCES teszt(id) ON UPDATE CASCADE ON DELETE CASCADE
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS valaszlehetosegek (
         melyik_helyes INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
         kerdesId INT NOT NULL,
         val_lehetoseg VARCHAR(200) NOT NULL,
         FOREIGN KEY (kerdesId) REFERENCES kerdes(id) ON UPDATE CASCADE ON DELETE CASCADE
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS valasz (
         melyik_helyes INT NOT NULL,
         kerdesId INT NOT NULL,
         PRIMARY KEY (melyik_helyes, kerdesId),
         FOREIGN KEY (kerdesId) REFERENCES kerdes(id) ON UPDATE CASCADE ON DELETE CASCADE,
         FOREIGN KEY (melyik_helyes) REFERENCES valaszlehetosegek(melyik_helyes) ON UPDATE CASCADE ON DELETE CASCADE
      ) ENGINE=InnoDB CHARSET=utf8;
      CREATE TABLE IF NOT EXISTS kitolt (
         felhNev VARCHAR(20) NOT NULL,
         tesztId INT NOT NULL,
         pontszam INT NOT NULL,
         raford_ido INT NOT NULL,
         datum TIMESTAMP NOT NULL,
         pont_per_kerd_ar DECIMAL(3, 2) NOT NULL,
         PRIMARY KEY (felhNev, tesztId),
         FOREIGN KEY (felhNev) REFERENCES felhasznalo(felh_nev) ON UPDATE CASCADE ON DELETE CASCADE,
         FOREIGN KEY (tesztId) REFERENCES teszt(id) ON UPDATE CASCADE
      ) ENGINE=InnoDB CHARSET=utf8;';

    $conn->exec($query);
    */

} catch(PDOException $e) {
    // Something went wrong rollback!
    //$conn->rollBack();
    echo $e->getMessage(); // Remove or change message in production code
}

/*
$parameters = array($_GET['string_col'], $_GET['int_col'], $user_id);

$statement = $conn->prepare($query);

$statement->execute($parameters);
*/