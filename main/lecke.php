<?php
$active = "lecke";
$color = "magenta";

session_start();

if(!isset($_SESSION["is_auth"])) {
    header('location: login.php?msg=1');
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
    <div class="content-right" style="height:60px;">
        <div class="lecke-upper-1"
             title="Erre a gombra kattintva indíthatja el és aktiválhatja az aktuális témakör lecke anyagát és töltheti le a leckéhez tartozó gyorstesztet.">
            Lecke indítása
        </div>
        <div class="lecke-upper-2"
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
    <div class="content-right">
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
    <div class="content-right vertical-padding-10" style="padding: 40px 0;"></div>
</div>

<?php
include 'includes/footer.php';
?>

