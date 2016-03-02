<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>HRP Interaktív Program</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/fonts.css">
    <link rel="stylesheet" type="text/css" href="../css/component.css">
    <link rel="stylesheet" type="text/css" href="../css/lecke.css">
    <script src="../../js/jquery.min.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/lecke.js"></script>
</head>
<body>
<div id="page-wrapper">
    <div id="top-menu-wrapper">
        <img src="../images/logo.png">
        <ul id="top-menu">
            <li><a href="../../index.html">Főoldal</a></li>
            <li><a href="../about.html">Rólunk</a></li>
            <li><a href="../services.html">Szolgáltatásaink</a></li>
            <li><a href="../contact.html">Kapcsolat</a></li>
            <li><a href="../career.html">Karrier</a></li>
            <li style="float:right;">
                <ul style="list-style-type:none;">
                    <li><a href="../reg.php">Regisztráció</a></li>
                    <li><a href="#">Bejelentkezés</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div id="content-wrapper">
        <div id="content">
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
                    <div class="lecke-upper-1" title="Erre a gombra kattintva indíthatja el és aktiválhatja az aktuális témakör lecke anyagát és töltheti le a leckéhez tartozó gyorstesztet.">Lecke indítása</div>
                    <div class="lecke-upper-2" title="Erre a gombra kattintva jelezheti, hogy az aktuális témakört feldolgozta, készen áll a következő lecke fogadására, illetve itt mondhatja el véleményét, megjegyzéseit.">Lecke zárása</div>
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
                        <!--
                        <img src="images/lecke.svg" width=550>
                        -->
                        <?php echo file_get_contents("../images/lecke.svg"); ?>
                        <div class="lecke-vid-container" title="A beépített tartalomra kattintva nézheti meg az előadást, a lecke prezentációját.">
                            <img src="../images/fakevid.png" class="lecke-vid">
                        </div>
                    </div>
                </div>
            </div>
            <div class="flexbox-container">
                <div class="content-left">
                    <div class="line-magenta"></div>
                </div>
                <div class="content-right vertical-padding-10"></div>
            </div>
        </div>
        <div id="right-menu">
            <ul>
                <li class="magenta-bottom"><nav class="cl-effect-12"><a href="#">Éléskamra program</a></nav></li>
                <li class="magenta-bottom"><nav class="cl-effect-12"><a href="#">Gyorsteszt</a></nav></li>
                <li class="magenta-bottom"><nav class="cl-effect-12"><a href="#">Kapcsolatfelvétel</a></nav></li>
                <li class="magenta-bottom"><nav class="cl-effect-12"><a href="#">Tanulmányok</a></nav></li>
                <li class="magenta-bottom"><nav class="cl-effect-12"><a href="#">Közösségi oldalak</a></nav></li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>