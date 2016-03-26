<?php
include '../includes/configHRP.php';

$valaszok = $email = $ido = "";
$csop1 = $csop2 = $csop3 = $csop4 = 0;
$str1 = $str2 = $str3 = $str4 = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $valaszok = test_input($_POST["valaszok"]);
    $email = test_input($_POST["email"]);
    $ido = test_input($_POST["ido"]);
    $tesztId = 1;                   // a gyorsteszt azonosítója

    $stmt = $conn->prepare("INSERT INTO gyteszt_kitolt
                            VALUES (NULL, :email, :teszt, :ido, NULL)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':teszt', $tesztId);
    $stmt->bindParam(':ido', $ido);
    $ret = $stmt->execute();
    $kitoltId = $conn->lastInsertId();

    if($ret) {
        for($i = 1; $i <= 20; $i++) {
            $valasz = substr($valaszok, $i - 1, 1);
            if($i <= 5) $csop1 += (int)$valasz;
            if($i > 5 && $i <= 10) $csop2 += (int)$valasz;
            if($i > 10 && $i <= 15) $csop3 += (int)$valasz;
            if($i > 15 && $i <= 20) $csop4 += (int)$valasz;
            $stmt = $conn->prepare("INSERT INTO gyteszt_valaszok
                            VALUES (NULL, :kitolt, :valaszId, :valasz)");
            $stmt->bindParam(':kitolt', $kitoltId);
            $stmt->bindParam(':valaszId', $i);
            $stmt->bindParam(':valasz', $valasz);
            $stmt->execute();
        }

        if($csop1 <= 5) $str1 = "<p>Önnek, a kérdésekre adott válaszok alapján, a <span style=\"font-style:italic;\">jövőkép, legfontosabb feladatok</span> kérdéscsoportban: <span style=\"font-weight:bold;\">nincs közvetlen teendője</span>.</p><p>Így tovább, összességében jól mennek a dolgok. Ezt a szintet tartsa fent.</p>";
        if($csop1 > 5 && $csop1 <= 11) $str1 = "<p>A kérdésekre adott válaszok alapján a <span style=\"font-style:italic;\">jövőkép, és legfontosabb feladatok</span> kérdéscsoportban felsorolt feladatokban már <span style=\"font-weight:bold;\">megjelenő</span> nehézségek tapasztalhatók.</p><p>Már megjelennek zavarok, de még nehéz beazonosítani őket. A céges működési területek látszólag jól működnek. Azonosítsa be a részterületek gyenge pontjait, készítsen tervet és javítsa ki azokat.</p>";
        if($csop1 > 11 && $csop1 <= 18) $str1 = "<p>A kérdésekre adott válaszok alapján, a <span style=\"font-style:italic;\">jövőkép és legfontosabb feladatok</span> kérdéscsoportban felsorolt feladatok kivitelezésében: <span style=\"font-weight:bold;\">átfogó kivizsgálás</span> szükséges.</p><p>Világítsa át a veszélyben lévő területek teljes működését, értse meg az eltérések okait, készítse el a folyamatok megújításához szükséges cselekvési- és költségtervet. Ha szükséges, a megújításához vegyen igénybe külső szakértőket.</p>";
        if($csop1 > 18 && $csop1 <= 25) $str1 = "<p>A kérdésekre adott válaszok alapján a <span style=\"font-style:italic;\">jövőkép és legfontosabb feladatok</span> kérdéscsoportban felsorolt feladatok kivitelezésében: <span style=\"font-weight:bold;\">rendszer szintű változtatás</span> szükséges.</p><p>A legtöbb eltérés kezelése túlmutat a cégen belüli változtatási lehetőségeken. Külső segítséget kell kérnie, plusztudást, készségeket kell bevonnia az adott terület, vagy területek kezeléséhez, megújításához. A problémás területek teljes működési folyamatát meg kell újítania. Ehhez használja az előző (rossz irány) pontban leírt lépéseket.</p>";

        if($csop2 <= 5) $str2 = "<p>Önnek, a kérdésekre adott válaszok alapján, a <span style=\"font-style:italic;\">dolgozói együttműködési profil</span> kérdéscsoportban: <span style=\"font-weight:bold;\">nincs közvetlen teendője</span>.</p><p>Így tovább, összességében jól mennek a dolgok. Ezt a szintet tartsa fent.</p>";
        if($csop2 > 5 && $csop2 <= 11) $str2 = "<p>A kérdésekre adott válaszok alapján a <span style=\"font-style:italic;\">dolgozói együttműködési profil</span> kérdéscsoportban már <span style=\"font-weight:bold;\">megjelenő nehézségek</span> tapasztalhatók.</p><p>Már megjelennek zavarok, de még nehéz beazonosítani őket. A céges működési területek látszólag jól működnek. Azonosítsa be a részterületek gyenge pontjait, készítsen tervet és javítsa ki azokat.</p>";
        if($csop2 > 11 && $csop2 <= 18) $str2 = "<p>A kérdésekre adott válaszok alapján, <span style=\"font-style:italic;\">dolgozói együttműködési profil</span> kérdéscsoportban felsorolt feladatok kivitelezésében: <span style=\"font-weight:bold;\">átfogó kivizsgálás</span> szükséges.</p><p>Világítsa át a veszélyben lévő területek teljes működését, értse meg az eltérések okait, készítse el a folyamatok megújításához szükséges cselekvési- és költségtervet. Ha szükséges, a megújításához vegyen igénybe külső szakértőket.</p>";
        if($csop2 > 18 && $csop2 <= 25) $str2 = "<p>A kérdésekre adott válaszok alapján <span style=\"font-style:italic;\">dolgozói együttműködési profil</span> kérdéscsoportban felsorolt feladatok kivitelezésében: <span style=\"font-weight:bold;\">rendszer szintű változtatás</span> szükséges.</p><p>A legtöbb eltérés kezelése túlmutat a cégen belüli változtatási lehetőségeken. Külső segítséget kell kérnie, plusztudást, készségeket kell bevonnia az adott terület, vagy területek kezeléséhez, megújításához. A problémás területek teljes működési folyamatát meg kell újítania. Ehhez használja az előző (rossz irány) pontban leírt lépéseket.</p>";

        if($csop3 <= 5) $str3 = "<p>Önnek, a kérdésekre adott válaszok alapján, a <span style=\"font-style:italic;\">dolgozók alapállapota</span> kérdéscsoportban: <span style=\"font-weight:bold;\">nincs közvetlen teendője</span>.</p><p>Így tovább, összességében jól mennek a dolgok. Ezt a szintet tartsa fent.</p>";
        if($csop3 > 5 && $csop3 <= 11) $str3 = "<p>A kérdésekre adott válaszok alapján a <span style=\"font-style:italic;\">dolgozók alapállapota</span> kérdéscsoportban már <span style=\"font-weight:bold;\">megjelenő nehézségek</span> tapasztalhatók.</p><p>Már megjelennek zavarok, de még nehéz beazonosítani őket. A céges működési területek látszólag jól működnek. Azonosítsa be a részterületek gyenge pontjait, készítsen tervet és javítsa ki azokat.</p>";
        if($csop3 > 11 && $csop3 <= 18) $str3 = "<p>A kérdésekre adott válaszok alapján, a <span style=\"font-style:italic;\">dolgozók alapállapota</span> kérdéscsoportban felsorolt feladatok kivitelezésében: <span style=\"font-weight:bold;\">átfogó kivizsgálás</span> szükséges.</p><p>Világítsa át a veszélyben lévő területek teljes működését, értse meg az eltérések okait, készítse el a folyamatok megújításához szükséges cselekvési- és költségtervet. Ha szükséges, a megújításához vegyen igénybe külső szakértőket.</p>";
        if($csop3 > 18 && $csop3 <= 25) $str3 = "<p>A kérdésekre adott válaszok alapján a <span style=\"font-style:italic;\">dolgozók alapállapota</span> kérdéscsoportban felsorolt feladatok kivitelezésében: <span style=\"font-weight:bold;\">rendszer szintű változtatás</span> szükséges.</p><p>A legtöbb eltérés kezelése túlmutat a cégen belüli változtatási lehetőségeken. Külső segítséget kell kérnie, plusztudást, készségeket kell bevonnia az adott terület, vagy területek kezeléséhez, megújításához. A problémás területek teljes működési folyamatát meg kell újítania. Ehhez használja az előző (rossz irány) pontban leírt lépéseket.</p>";

        if($csop4 <= 5) $str4 = "<p>Önnek, a kérdésekre adott válaszok alapján, a <span style=\"font-style:italic;\">pénzügyi és piaci eredményesség</span> kérdéscsoportban: <span style=\"font-weight:bold;\">nincs közvetlen teendője</span>.</p><p>Így tovább, összességében jól mennek a dolgok. Ezt a szintet tartsa fent.</p>";
        if($csop4 > 5 && $csop4 <= 11) $str4 = "<p>A kérdésekre adott válaszok alapján a <span style=\"font-style:italic;\">pénzügyi és piaci eredményesség</span> kérdéscsoportban már <span style=\"font-weight:bold;\">megjelenő nehézségek</span> tapasztalhatók.</p><p>Már megjelennek zavarok, de még nehéz beazonosítani őket. A céges működési területek látszólag jól működnek. Azonosítsa be a részterületek gyenge pontjait, készítsen tervet és javítsa ki azokat.</p>";
        if($csop4 > 11 && $csop4 <= 18) $str4 = "<p>A kérdésekre adott válaszok alapján, a <span style=\"font-style:italic;\">pénzügyi és piaci eredményesség</span> kérdéscsoportban felsorolt feladatok kivitelezésében: <span style=\"font-weight:bold;\">átfogó kivizsgálás</span> szükséges.</p><p>Világítsa át a veszélyben lévő területek teljes működését, értse meg az eltérések okait, készítse el a folyamatok megújításához szükséges cselekvési- és költségtervet. Ha szükséges, a megújításához vegyen igénybe külső szakértőket.</p>";
        if($csop4 > 18 && $csop4 <= 25) $str4 = "<p>A kérdésekre adott válaszok alapján a <span style=\"font-style:italic;\">pénzügyi és piaci eredményesség</span> kérdéscsoportban felsorolt feladatok kivitelezésében: <span style=\"font-weight:bold;\">rendszer szintű változtatás</span> szükséges.</p><p>A legtöbb eltérés kezelése túlmutat a cégen belüli változtatási lehetőségeken. Külső segítséget kell kérnie, plusztudást, készségeket kell bevonnia az adott terület, vagy területek kezeléséhez, megújításához. A problémás területek teljes működési folyamatát meg kell újítania. Ehhez használja az előző (rossz irány) pontban leírt lépéseket.</p>";

        $mp = $ido % 60;
        $perc = floor($ido / 60);
        $ora = floor($perc / 60);
        if($ora == 0) $raf_ido = $perc . " perc, " . $mp . " másodperc.";
        if($perc == 0) $raf_ido = $mp . " másodperc.";
        if($ora != 0 && $perc != 0) $raf_ido = $ora . " óra, " . $perc . " perc, " . $mp . " másodperc.";

        /* ************* HTML E-MAIL KÜLDÉSE ************* */
        $to = $email;
        $subject = "HRP - Gyorsteszt kiértékelés";

        $message = "
        <html>
        <head>
        <title>HRP - Gyorsteszt</title>
        </head>
        <body>
        <h2>Tisztelt Hölgyem/Uram!</h2>
        <p>Ön gyorstesztet töltött ki rendszerünkben, melynek eredményét kiértékeltük, s alább olvasható.</p>
        <fieldset><legend align=\"center\">Gyorsteszt - értékelés</legend><p>Kitöltés ideje: ". date("Y.m.d. H:i") ."</p><p>Ráfordított idő: ". $raf_ido ."</p>
        <fieldset><legend style=\"padding: 0.2em 0.5em;border:1px solid black;background:yellow;border-radius:16px;\">JÖVŐKÉP, LEGFONTOSABB FELADATOK</legend>". $str1 ."</fieldset>
        <div style=\"padding:10px 0px;\"></div>
        <fieldset><legend style=\"padding: 0.2em 0.5em;border:1px solid black;background:rgb(252, 144, 36);border-radius:16px;\">DOLGOZÓI EGYÜTTMŰKÖDÉSI PROFIL</legend>". $str2 ."</fieldset>
        <div style=\"padding:10px 0px;\"></div>
        <fieldset><legend style=\"padding: 0.2em 0.5em;border:1px solid black;background:#89c540;border-radius:16px;\">A DOLGOZÓK ALAPÁLLAPOTA, RENDELKEZÉSRE ÁLLÁSA</legend>". $str3 ."</fieldset>
        <div style=\"padding:10px 0px;\"></div>
        <fieldset><legend style=\"padding: 0.2em 0.5em;border:1px solid black;background:lightblue;border-radius:16px;\">PÉNZÜGYI ÉS PIACI EREDMÉNYESSÉG</legend>". $str4 ."</fieldset></fieldset>
        <div style=\"padding:20px 0px;\"><span style=\"font-style: italic;\">Üdvözlettel:<br>Interaktív Program csapata</span><br>
        <img src=\"http://hrp-interaktiv.hu/kepek/logo_min.jpg\" alt=\"HRP logo mini\"></div>
        </body>
        </html>";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        //$headers .= 'From: <webmaster@example.com>' . "\r\n";
        //$headers .= 'Cc: myboss@example.com' . "\r\n";

        mail($to, $subject, $message, $headers);
        /* *********************************************** */

        echo "gyteszt_send_ok";
    } else {
        echo "gyteszt_send_not_ok";
    }
}