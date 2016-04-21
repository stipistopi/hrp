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

$testName = db_getLeckeStartTestName($timeWindowName);
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
            <legend align="center">Leckekezdő teszt</legend>
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
                        <p>Az egészségfejlesztés első lépése, hogy szembenézzünk önmagunkkal és meghatározzuk, honnan is kell elinduljunk, és mit kell pontosan tennünk. Ehhez ad segítséget az alábbi kérdéssor is.</p>
                        <p>Minden kérdésnél három lehetséges választ sorolunk fel. Önnek ezek közül kell egyet kiválasztania.</p>
                        <p>Az Ön által adott adatok bizalmasak, ezért arról csak Ön kap egy részletes kockázatértékelést.</p>
                        <p>Jó munkát kívánunk!</p>
                        <p>Üdvüzlettel:<br>Interaktív Program csapata</p>
                    </div>
                </div>
                <h3>Kérem, válasszon a felsorolt válaszok közül!</h3>
            </div>
            <div style="padding: 0 60px;">
                <form id="form-leckekezdo" onsubmit="return false;">
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
                        <input type="submit" value="Kiértékelés">
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

