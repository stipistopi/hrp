<?php
$active = "activity";
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
$userLastLogin = date("Y.m.d.", strtotime($_SESSION['userLastLogin'])) . " nap " . date("H", strtotime($_SESSION['userLastLogin'])) . " óra " . date("i", strtotime($_SESSION['userLastLogin'])) . " perckor";

if(pregMatch_oneNumberFromString($timeWindowName)) {
    $numberOfLecke = pregMatch_oneNumberFromString($timeWindowName);
} else {
    $numberOfLecke = "";
}

$daysFromStart = db_getNumberOfDaysFromStart($userId, null, null, null);
$daysToEnd = db_getNumberOfDaysToProgramEnd($userId, null, null, null);
$daysToNextTimeWindow = db_getDaysToNextTimeWindow($userId, null, null, null, $timeWindowName);
$TimeWindowDescription = db_getTimeWindowDescription($timeWindowName);
$NextTimeWindowDescription = db_getNextTimeWindowDescription($timeWindowName);
$numberOfFilledOutTests = db_getHowManyTestsFilledOut($userId);
$numberOfTestsThatAreLeft = db_getHowManyTestsAreLeft($userId);

include 'includes/header.php';

?>

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

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
        <fieldset id="main_fieldset" style="margin: auto;">
            <legend align="center">Tevékenységeim</legend>
            <div style="padding: 0 20px;">
                <h3>Kedves <?php echo $userFirstName; ?>!</h3>
                <h4>Ön a rendszert...</h4>
                <?php
                $randomColor = mt_rand(1,4);
                echo "<table id=\"lecke_number_in_tests\"><tr><td id=\"color$randomColor\"><div>$daysFromStart</div></td></tr></table>";
                ?>
                <h4 style="text-align: right;">...napja használja.</h4>
                <hr>
                <h4>A teljes programból még...</h4>
                <?php
                $randomColor = mt_rand(1,4);
                echo "<table id=\"lecke_number_in_tests\"><tr><td id=\"color$randomColor\"><div>$daysToEnd</div></td></tr></table>";
                ?>
                <h4 style="text-align: right;">...nap van hátra.</h4>
                <p style="font-size: 80%;">(Megj.: Eddig tudja használni a rendszert.)</p>
                <hr>
                <h4>A következő ciklusig még...</h4>
                <?php
                $randomColor = mt_rand(1,4);
                echo "<table id=\"lecke_number_in_tests\"><tr><td id=\"color$randomColor\"><div>$daysToNextTimeWindow</div></td></tr></table>";
                ?>
                <h4 style="text-align: right;">...nap van hátra.</h4>
                <p style="font-size: 80%;">(Megj.: Eddig töltheti ki az aktuális teszteket, nézheti a videókat, stb.)</p>
                <hr>
                <h4>A következő ciklus megnevezése:</h4>
                <p style="text-align: center;"><?php echo $NextTimeWindowDescription; ?></p>
                <h4 style="padding-top: 1em;">Jelenlegi ciklus megnevezése:</h4>
                <p style="text-align: center;"><?php echo $TimeWindowDescription; ?></p>
                <hr>
                <h4>Eddig összesen...</h4>
                <?php
                $randomColor = mt_rand(1,4);
                echo "<table id=\"lecke_number_in_tests\"><tr><td id=\"color$randomColor\"><div>$numberOfFilledOutTests</div></td></tr></table>";
                ?>
                <h4 style="text-align: right;">...tesztet töltött ki.</h4>
                <hr>
                <h4>A program végéig még...</h4>
                <?php
                $randomColor = mt_rand(1,4);
                echo "<table id=\"lecke_number_in_tests\"><tr><td id=\"color$randomColor\"><div>$numberOfTestsThatAreLeft</div></td></tr></table>";
                ?>
                <h4 style="text-align: right;">...tesztet kell (ajánlott) kitöltenie.</h4>
                <hr>
                <h4>Teljesítménye leckékre lebontva:</h4>
                <?php
                for($i=1; $i<=5; $i++) {
                    $statusInLecke = db_getStatusInLecke($userId, "lecke".$i);

                    if($i % 2 == 0) $igazit = "left"; else $igazit = "right";
                    if($i == 5) $padding = "1.3em"; else $padding = 0;

                    echo "<p style=\"text-align: $igazit;font-style: italic;font-weight: bold;padding: 0 1em;\">$i. lecke</p>
                          <div style=\"padding-bottom: $padding;\" align=\"center\">
                            <div id=\"progress$i\" class=\"graph\" align=\"left\">
                                <div id=\"bar$i\" class=\"bar prog_color1\" style=\"width:$statusInLecke%\">
                                    <p>$statusInLecke% teljesítve</p>
                                </div>
                            </div>
                          </div>";
                }
                ?>
                <hr>
                <h4>Legutóbbi 5 tevékenysége:</h4>
                <table id="activity_table" align="center" width="90%">
                    <tr>
                        <td>#</td>
                        <td>Megnevezés</td>
                        <td>Időpont</td>
                    </tr>
                    <?php
                    $ret = db_getUserDataRaw($userId, null, null, null);
                    $userName = $ret['felh_nev'];

                    global $conn;
                    $stmt = $conn->prepare("SELECT aktivitas.leiras, aktivitas_ertekek.datum
                            FROM aktivitas, aktivitas_ertekek
                            WHERE aktivitas_ertekek.felhNev = :uname AND
                                  aktivitas_ertekek.aktivitasId = aktivitas.id
                            ORDER BY aktivitas_ertekek.datum DESC
                            LIMIT 5");
                    $stmt->bindParam(':uname', $userName);
                    $stmt->execute();
                    $last5 = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $i = 1;
                    foreach($last5 as $row) {
                        echo "<tr><td>". $i .".</td><td>". $row['leiras'] ."</td><td>". date("Y.m.d. H:i", strtotime($row['datum'])) ."</td></tr>";
                        $i++;
                    }
                    ?>
                </table>
                <p style="font-style: italic;padding-top: 1em;">Legutóbb <?php echo $userLastLogin; ?> lépett be.</p>
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
