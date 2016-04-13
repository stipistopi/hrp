<?php
$active = "lecke";
$color = "magenta";

include_once 'includes/config.php';

//session_start();

if(!isset($_SESSION["is_auth"])) {
    header('location: login.php?msg=1');
    exit;
}

$userFirstName = $_SESSION['userFirstName'];
$userLastLogin = date("Y.m.d.", strtotime($_SESSION['userLastLogin'])) . " nap " . date("H", strtotime($_SESSION['userLastLogin'])) . " óra " . date("i", strtotime($_SESSION['userLastLogin'])) . " perckor";

include 'includes/header.php';

if(!empty($_GET['msg'])) {
    if($_GET['msg'] == 1) {
        $text = "A teszt még (vagy már) nem elérhető.";
    }
    if($_GET['msg'] == 2) {
        $text = "Ez a tartalom jelenleg Önnek nem elérhető.";
    }
    $message = "<div style=\"padding-top: 20px;width:90%;margin: auto;\"><p style=\"background-color:darkred;border-radius:16px;text-align: center;padding: 5px 0;font-weight: bold;color: white;\">$text</p></div>";
}
?>

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.blockUI.js"></script>
<script type="text/javascript" src="js/lecke.js"></script>
<link rel="stylesheet" type="text/css" href="css/lecke.css">
<link rel="stylesheet" type="text/css" href="css/progressbar.css">
<link href='http://fonts.googleapis.com/css?family=PT+Sans+Caption:400,700' rel='stylesheet' type='text/css'>

<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right"><?php if(isset($message)) echo $message; ?></div>
</div>
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right"><h2>Üdvözlöm, <?php echo $userFirstName; ?>!</h2></div>
</div>
<!--
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right" style="display: inline-block;padding: 60px 0;">
        <div class="checkout-wrap">
            <ul class="checkout-bar">
                <li class="visited first"><a href="#">Login</a></li>
                <li class="previous visited">Shipping & Billing</li>
                <li class="active">Shipping Options</li>
                <li class="next">Review & Payment</li>
                <li class="">Complete</li>
            </ul>
        </div>
    </div>
</div>
-->
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right" style="padding-bottom: 1em;">
        <fieldset style="margin: auto;width: 90%;">
            <legend align="center">Ön jelenleg itt tart...</legend>
            <h4>A teljes programban:</h4>
            <div style="padding: .6em 0;" align="center">
                <div id="progress" class="graph" align="left">
                    <div id="bar" class="prog_color1" style="width:34%">
                        <p>34% teljesítve</p>
                    </div>
                </div>
            </div>
            <h4>A leckében (2. lecke):</h4>
            <div style="padding: .6em 0;" align="center">
                <div id="progress" class="graph" align="left">
                    <div id="bar" class="prog_color2" style="width:80%">
                        <p>80% teljesítve</p>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right content-right-mod" style="padding: 1.5em 0;">
        <div class="lecke-upper-1" onclick="window.location='lecke_start.php';"
             title="Erre a gombra kattintva indíthatja el és aktiválhatja az aktuális témakör lecke anyagát és töltheti le a leckéhez tartozó gyorstesztet.">
            Lecke indítása
        </div>
        <div class="lecke-upper-2" onclick="window.location='lecke_end.php';"
             title="Erre a gombra kattintva jelezheti, hogy az aktuális témakört feldolgozta, készen áll a következő lecke fogadására, illetve itt mondhatja el véleményét, megjegyzéseit.">
            Lecke zárása
        </div>
    </div>
</div>
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
    <div class="content-right content-right-mod">
        <div class="lecke">
            <?php echo file_get_contents("images/lecke.svg"); ?>
            <div class="lecke-vid-container"
                 title="A beépített tartalomra kattintva nézheti meg az előadást, a lecke prezentációját.">
                <img src="images/fakevid.png" class="lecke-vid">
            </div>
        </div>
    </div>
</div>
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right vertical-padding-10" style="padding: 20px 0;"><p style="font-style: italic;">Legutóbb ekkor járt itt: <?php echo $userLastLogin; ?>.</p></div>
</div>

<?php
include 'includes/footer.php';
?>

