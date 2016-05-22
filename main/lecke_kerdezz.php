<?php
$active = "lecke";
$color = "magenta";

include_once 'includes/config.php';

//session_start();

if(!isset($_SESSION["is_auth"])) {
    header('location: login.php?msg=1');
    exit;
}

$userId = $_SESSION['userId'];
$timeWindowName = $_SESSION['timeWindowName'];
$userFirstName = $_SESSION['userFirstName'];

$testName = db_getLeckeKerdezzTestName($timeWindowName);
$filledOut = db_checkIfTestFilledOut($userId, $testName);

if(pregMatch_oneNumberFromString($testName)) {
    $numberOfLecke = pregMatch_oneNumberFromString($testName);
} else {
    $numberOfLecke = "";
}

if(strpos($timeWindowName, 'lecke') === false || $filledOut) {
    header('location: lecke.php?msg=1');
    exit;
}

if(!db_checkUserActivity($timeWindowName, "lecke_kf_nyit", $userId, null, null, null)) {
    db_addUserActivity($timeWindowName, "lecke_kf_nyit", $userId, null, null, null);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['test_submit'])) {

        // pontszám számítása
        $pont = 0;
        $i = 1;
        while(isset($_POST['csop' . $i])) {
            $pont += $_POST['csop' . $i];
            $i++;
        }

        // kitöltésre fordított idő számítása
        $start_time = test_input($_POST['start_time']);
        $timeDiff = strtotime('now') - strtotime($start_time);
        $fillOutTime = date("s", $timeDiff) + 60*date("i", $timeDiff) + 60*60*(date("H", $timeDiff) - 1);

        // százalék számítása
        $szazalek = round($pont/10, 3);

        if(db_addNewRecordInTableKitolt($userId, $testName, $pont, $fillOutTime, $szazalek)) {
            $user = db_getUserDataRaw($userId, null, null, null);
            $email = $user['email'];

            /* ************* HTML E-MAIL KÜLDÉSE ************* */
            $to = $email;
            $subject = "HRP - Kérdezz-felelek teszt kiértékelése (" . $numberOfLecke . ". lecke)";

            if($numberOfLecke == 1) {
                $leckeTextSima = "táplálkozás és emésztés";
                $leckeText = "táplálkozással és emésztéssel kapcsolatos";
            } else {
                $leckeText = "!!NEM DEFINIÁLT VÁLTOZÓ!!";
            }

            if($pont >= 0 && $pont <= 3) {
                $szint = "nem megfelelő";
            } else if($pont > 3 && $pont <= 7) {
                $szint = "megfelelő";
            } else if($pont > 7 && $pont <= 10) {
                $szint = "kitűnő";
            } else {
                $szint = "!!NEM DEFINIÁLT VÁLTOZÓ!!";
            }

            $message = "
            <html>
            <head>
            <title>HRP - Kérdezz-felelek teszt</title>
            </head>
            <body>
            <h2>Tisztelt Partnerünk!</h2>
            <p>A kérdezz-felelek felmérés az Ön tudásszintjéről ad visszajelzést. Megmutatja, hogy mennyire sikerült a(z) $leckeText ismereteket megjegyeznie.</p>
            <p style=\"font-weight:bold;\">Az eredményét itt láthatja:</p>
            <div style=\"margin-left:4em;\">
            <p>Az Ön $leckeTextSima témakör elsajátítási szintje: " . strtoupper($szint) . "</p>
            <div style=\"text-align: center;\">
            <p style=\"font-style: italic;\">Az eddig kitöltők átlagos elsajátítási szintje</p>
            <p><a href=\"http://hrp-interaktiv.hu/main/results.php?test=kf&lecke=$numberOfLecke\" target=\"_blank\"><img src=\"http://hrp-interaktiv.hu/main/images/graph.png\" alt=\"HRP grafikon kép\" width=\"400\" height=\"auto\"></a></p>
            </div>
            </div>
            <p>Tipp: A <a href=\"http://hrp-interaktiv.hu/main/ttar.php\" target=\"_blank\">tudástárban</a> további hasznos ismereteket találhat. Vegye és bővítse tovább ismereteit.</p>
            <p>Ha a kérdezz-felelek kérdéssorral kapcsolatban megjegyzése van, kérem, vegye fel a kapcsolatot az <a href=\"http://hrp-interaktiv.hu/main/help.php\" target=\"_blank\">ügyfélszolgálatunk</a>kal!</p>
            <div style=\"padding:20px 0;\"><span style=\"font-style: italic;\">Üdvözlettel:<br>Interaktív Program csapata</span><br>
            <img src=\"http://hrp-interaktiv.hu/kepek/logo_min.jpg\" alt=\"HRP logo mini\"></div>
            </body>
            </html>";

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            //$headers .= 'From: <webmaster@example.com>' . "\r\n";
            //$headers .= 'Cc: myboss@example.com' . "\r\n";

            mail($to, $subject, $message, $headers);
            /* *********************************************** */

            header('location: lecke.php?msg=3');
            exit;
        } else {
            header('location: lecke.php?msg=4');
            exit;
        }

    }
}

include 'includes/header.php';

?>

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/lecke.js"></script>
<link rel="stylesheet" type="text/css" href="css/lecke.css">

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
        <fieldset id="main_fieldset">
            <legend align="center">Kérdezz-felelek teszt</legend>
            <div style="padding: 0 20px;">
                <?php
                $randomColor = mt_rand(1,4);
                if(!empty($numberOfLecke)) {
                    echo "<table id=\"lecke_number_in_tests\"><tr><td id=\"color$randomColor\"><div>#$numberOfLecke</div></td></tr></table>";
                }
                ?>
                <div style="background-color:#e4e4e4;">
                    <div style="padding: 0 10px;">
                        <p style="font-weight: bold;">Kedves <?php echo $userFirstName; ?>!</p>
                        <p>Kérjük, olvassa végig a kérdéseket, majd a megadott válaszlehetőségekből válassza ki és jelölje be a helyes választ! (Egy helyes megoldás van.)</p>
                        <p>A teszt kitöltéséről hamarosan visszajelzést, értékelést kap.</p>
                        <p>Üdvüzlettel:<br>Interaktív Program csapata</p>
                    </div>
                </div>
            </div>
            <div style="padding: 0 60px;">
                <form id="form-leckekezdo" method="post" action="">
                    <?php
                    $testId = db_getTestId($testName);
                    $startFromQuestionId = db_getStartQuestionId($testId);
                    $questionInterval = db_getQuestionInterval($testId);
                    //$randomColor = mt_rand(1,4);
                    $numsQ = 1;
                    for($i = $startFromQuestionId; $i < ($startFromQuestionId + $questionInterval); $i++) {
                        $stmt = $conn->prepare("SELECT kerdes FROM kerdes WHERE id = :qId;");
                        $stmt->bindParam(':qId', $i);
                        $stmt->execute();
                        $question = $stmt->fetchColumn();
                        echo "<h4>" . $numsQ . ") " . $question . "</h4>";

                        $stmt = $conn->prepare("SELECT val_lehetoseg, suly FROM valasz WHERE kerdesId = :qId;");
                        $stmt->bindParam(':qId', $i);
                        $stmt->execute();
                        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        echo "<table style=\"margin-left: 80px;width: 100%\">";
                        $numsA = 1;
                        $sizeA = sizeof($rows);
                        foreach($rows as $row) {
                            if($numsA == 1) $numsALetter = "a";
                            if($numsA == 2) $numsALetter = "b";
                            if($numsA == 3) $numsALetter = "c";
                            if($numsA == 4) $numsALetter = "d";
                            if($numsA == 5) $numsALetter = "e";
                            echo "<tr><td width=\"50%\">" . $numsALetter . ") " . $row['val_lehetoseg'] . "</td>";
                            if($numsA == 1) {
                                echo "<td rowspan=\"" . $sizeA . "\" width=\"50%\" align=\"center\">";
                                echo "<ul id=\"gy_g". $randomColor ."\" class=\"gyteszt_gombok insert_x\">";
                                $numsB = 1;
                                foreach($rows as $row1) {
                                    echo "<li><input type=\"radio\" id=\"v". $numsQ ."_". $numsB ."\" name=\"csop". $numsQ ."\" value=\"". $row1['suly'] ."\" required />";
                                    echo "<label for=\"v". $numsQ ."_". $numsB ."\"></label></li>";
                                    if($numsB != $sizeA) echo "<br><div style=\"padding: .8em 0;\"></div>";
                                    $numsB++;
                                }
                                echo "</ul>";
                                echo "</td></tr>";
                            } else {
                                echo "</tr>";
                            }
                            $numsA++;
                        }
                        echo "</table>";
                        if($i != ($startFromQuestionId + $questionInterval) - 1) echo "<hr>";
                        $numsQ++;
                    }
                    ?>
                    <div style="padding: 20px 0;"></div>
                    <div id="test_submit<?php echo $randomColor; ?>" class="teszt_kiertekel">
                        <input type="text" name="start_time" value="<?php echo date("Y-m-d H:i:s"); ?>" style="display: none;">
                        <input type="submit" name="test_submit" value="Kiértékelés">
                    </div>
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

