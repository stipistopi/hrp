<?php
$active = "lecke";
$color = "magenta";

include_once 'includes/config.php';

if(!isset($_SESSION["is_auth"])) {
    header('location: login.php?msg=1');
    exit;
}

$userId = $_SESSION['userId'];
$timeWindowName = $_SESSION['timeWindowName'];
$userFirstName = $_SESSION['userFirstName'];

if(strpos($timeWindowName, 'lecke') === false) { // tesztelni azt is, hogy kitöltötte-e már az adott vállalom-részt
    header('location: lecke.php?msg=2');
    exit;
}

if(pregMatch_oneNumberFromString($timeWindowName)) {
    $numberOfLecke = pregMatch_oneNumberFromString($timeWindowName);
} else {
    $numberOfLecke = "";
}

if($numberOfLecke == 1) {
    $vallalasok = array("A mai naptól oda figyelek az étkezésemre. Naponta többször keveset eszem.",
        "A mai naptól tartózkodom a túlforró, vagy túl fűszeres ételek fogyasztásától.",
        "A mai naptól megválogatom a táplálékaimat. Törekszem arra, hogy hagyományos eljárással készült 'tiszta' táplálék legyen.",
        "A mai naptól figyelek a kellő mennyiségű folyadék bevitelére.",
        "A mai naptól figyelek a testsúlyomra, elérem az optimális testsúlyomat.",
        "A mai naptól rendszeresen mozgással is segítem emésztésemet, egészségemet.",
        "A mai naptól legalább évente járok szűrésekre, rendszeresen elmegyek orvosi vizsgálatra.",
        "Nem vállalok semmit.");
}

$text = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['vallalasok_check'])) {
        $valaszok = $_POST['vallalasok_check'];
    } else {
        $valaszok = "";
    }

    if(empty($valaszok)) {
        $text = "<div style=\"width:90%;margin: auto;\"><p style=\"background-color:darkred;border-radius:16px;text-align: center;padding: 5px 0;font-weight: bold;color: white;\">Legalább egy választ meg kell adni!</p></div>";
    } else {
        $n = count($valaszok);

        $user = db_getUserDataRaw($userId, null, null, null);
        $email = $user['email'];

        /* ************* HTML E-MAIL KÜLDÉSE ************* */
        $to = $email;
        $subject = "HRP - Vállalások (" . $numberOfLecke . ". lecke)";

        if($valaszok[0] == $vallalasok[sizeof($vallalasok) - 1]) {
            $message = "
            <html>
            <head>
            <title>HRP - Vállalások</title>
            </head>
            <body>
            <h2>Tisztelt Partnerünk!</h2>
            <p>Sajnálattal tapasztaltuk, hogy Ön, úgy döntött, táplálkozással kapcsolatos egészségkockázatainak csökkentéséért nem vállal semmit.</p>
            <p>Ne felejtse! Az egészségfejlesztés a hozzáállásban dől el.</p>
            <p>A következő témakörnél lesz alkalma, hogy egyéni vállalásával hozzájáruljon egészségesebb és teljesebb élet kialakításához és fenntartásához.</p>
            <div style=\"padding:20px 0;\"><span style=\"font-style: italic;\">Üdvözlettel:<br>Interaktív Program csapata</span><br>
            <img src=\"http://hrp-interaktiv.hu/kepek/logo_min.jpg\" alt=\"HRP logo mini\"></div>
            </body>
            </html>";
        } else {
            $message = "
            <html>
            <head>
            <title>HRP - Vállalások</title>
            </head>
            <body>
            <h2>Tisztelt Partnerünk!</h2>
            <h3>Gratulálunk!</h3>
            <p>Ön ezzel a döntésével megerősítette, hogy kész tenni saját magáért, táplálkozással kapcsolatos egészségkockázatainak csökkentéséért.</p>
            <p>Megtette a legfontosabbat. Szembe nézett önmagával és gyengeségeivel, majd úgy döntött: néhány dolgot megváltoztat életében.</p>
            <p>Ön azt vállalta, hogy a táplálkozás és emésztőrendszere egészségének érdekében a mai napot követően az alábbiakat teszi meg:</p><ul>";
            for($k = 0; $k < $n; $k++) {
                $message .= "<li style=\"padding:10px 0;\">" . $valaszok[$k] . "</li>";
            }
            $message .= "</ul><div style=\"padding:20px 0;\"><span style=\"font-style: italic;\">Üdvözlettel:<br>Interaktív Program csapata</span><br>
            <img src=\"http://hrp-interaktiv.hu/kepek/logo_min.jpg\" alt=\"HRP logo mini\"></div>
            </body>
            </html>";
        }

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        //$headers .= 'From: <webmaster@example.com>' . "\r\n";
        //$headers .= 'Cc: myboss@example.com' . "\r\n";

        mail($to, $subject, $message, $headers);
        /* *********************************************** */

        header('location: lecke.php');
        exit;
    }
}

include 'includes/header.php';

?>

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.blockUI.js"></script>
<script type="text/javascript" src="js/vallal.js"></script>

<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right vertical-padding-10"></div>
</div>
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right">
        <fieldset style="width: 80%;margin: auto;">
            <legend align="center">Én ezt vállalom...</legend>
            <div style="padding: 0 20px;">
                <?php echo $text; ?>
                <div style="background-color:#e4e4e4;">
                    <div style="padding: 0 15px;">
                        <p style="font-weight: bold;padding-top: 5px;">Kedves <?php echo $userFirstName; ?>!</p>
                        <p style="padding-bottom: 5px;">Az alábbiakban található pontok közül kedve szerint válasszon egy, vagy több pontot. A kiválasztással azt vállalja, hogy az elkövetkező egy évben azt megtartja, és azt beépíti mindennapi életébe. Azt vállalja, hogy konkrét lépéssel, pozitív magatartási mintával is elősegíti egészsége fejlesztését.</p>
                    </div>
                </div>
                <p style="font-weight: bold;">Egészségem érdekében...</p>
                <form id="vallal_form" method="post" action="">
                    <table id="vallal_tabla" width="90%" align="center">
                        <?php
                        $max = count($vallalasok);
                        for($i = 0; $i < $max; $i++) {
                            echo "<tr><td><input type=\"checkbox\" name=\"vallalasok_check[]\" id=\"id$i\" value=\"$vallalasok[$i]\" /></td><td style=\"padding-left: 15px;\"><label for=\"id$i\">$vallalasok[$i]</label></td></tr>";
                        }
                        ?>
                        <tr>
                            <td colspan="2" align="center"><input type="submit" value="Kész"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </fieldset>
    </div>
</div>
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right">
    </div>
</div>
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right" style="height:40px;"></div>
</div>

<?php
include 'includes/footer.php';
?>

