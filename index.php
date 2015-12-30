<!DOCTYPE html>
<html>
<head>
    <title>HRP Interaktív Program</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".kisKor").hover(function() {
                $(".kisKor").css("animation-play-state", "paused");
            }, function() {
                $(".kisKor").css("animation-play-state", "running");
            });
        });
    </script>
</head>

<body>
    <!--
    <div class="nagyKor kozepre"></div>
    -->
    <a href="#"><div class="kisKor kisKor1"><span class="szoveg">Bemutatkozó</span></div></a>
    <a href="#"><div class="kisKor kisKor2"><span class="szoveg">Programajánló demó</span></div></a>
    <a href="#"><div class="kisKor kisKor3"><span class="szoveg">Interaktív program indítása</span></div></a>
</body>
</html>