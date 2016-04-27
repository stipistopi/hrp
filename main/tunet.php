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

if($timeWindowName == "pkezdo") {
    header('location: lecke.php?msg=2');
    exit;
}

if(pregMatch_oneNumberFromString($timeWindowName)) {
    $numberOfLecke = pregMatch_oneNumberFromString($timeWindowName);
} else {
    $numberOfLecke = db_getNumberOfAllLecke();
}

$ids = array();
$ids[1] = "egSbAzhcN";

include 'includes/header.php';

?>

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.blockUI.js"></script>

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
        <h2>Tünetellenőrző</h2>
    </div>
</div>
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right">
        <h4>Válasszon leckét (a lista bővül, ahogy halad a programban)!</h4>
    </div>
</div>
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right">
        <div id="tunet_list">
            <?php
            for($i = 1; $i <= $numberOfLecke; $i++) {
                echo "<p class=\"tunet_item\"><a class=\"also_link\" href=\"docs/tunet_". $i ."_". $ids[$i] .".pdf\" target=\"_blank\">$i. lecke tünetellenőrzőjének megnyitása</a></p>";
            }
            ?>
        </div>
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
    <?php if ($numberOfLecke < 4): ?>
        <div class="content-right" style="height:160px;"></div>
    <?php else: ?>
        <div class="content-right" style="height:40px;"></div>
    <?php endif ?>
</div>

<?php
include 'includes/footer.php';
?>

