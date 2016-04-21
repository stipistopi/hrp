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

include 'includes/header.php';

?>

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.blockUI.js"></script>
<script type="text/javascript" src="js/help.js"></script>

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
        <div class="contact_ok" style="display:none;">
            <h1>E-mail elküldve</h1>
            <h2>Köszönjük! Hamarosan visszajelzünk</h2>
        </div>
        <div class="contact_uj" style="display:none;">
            <h1>Hiba!</h1>
            <h2>Az e-mailt már elküldtük</h2>
        </div>
        <fieldset style="width: 80%;margin: auto;">
            <legend align="center">Segítségkérés</legend>
            <div style="padding: 0 20px;">
                <div style="background-color:#e4e4e4;">
                    <div style="padding: 0 15px;">
                        <p style="font-weight: bold;padding-top: 5px;">Kedves <?php echo $userFirstName; ?>!</p>
                        <p>Küldje el kérdését ügyfélszolgálatunk számára!<br>Munkatársaink hamarosan felveszik Önnel a kapcsolatot.</p>
                        <p style="padding-bottom: 5px;">Üdvüzlettel:<br>Interaktív Program csapata</p>
                    </div>
                </div>
            </div>
            <form id="help_form" onsubmit="return false;">
                <div style="text-align: center;">
                    <div style="padding: .5em;">
                        <textarea id="help_msg" rows="4" style="width:90%;resize:vertical;" maxlength="500" placeholder="Üzenet szövege..." required autofocus></textarea>
                    </div>
                    <div style="padding: .5em;">
                        <input type="submit" value="Küldés">
                    </div>
                    <div id="userId" style="display: none;"><?php echo $userId; ?></div>
                    <div id="timeWindow" style="display: none;"><?php echo $timeWindowName; ?></div>
                </div>
            </form>
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
    <div class="content-right" style="height:160px;"></div>
</div>

<?php
include 'includes/footer.php';
?>

