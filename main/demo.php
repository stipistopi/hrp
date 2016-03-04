<?php
$active = "demo";
include 'includes/header.php';
?>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script>
        $(function() {
            $(document).tooltip({
                track: true,                        // a tooltip követi az egérmozgást
                content: function() {               // sortötés a tooltip-en belül
                    return $(this).attr('title');
                },
                show: { delay: 200 }
            });
        });
    </script>

    <div class="flexbox-container bottom-padding-10">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right" style="height:20px;"></div>
    </div>
    <div class="flexbox-container vertical-padding-10">
        <div class="content-left">
            <div class="circle-green"></div>
        </div>
        <div class="content-right">
            <nav class="cl-effect-21 cl-effect-21-green"><a class="popup-trigger"
                                                            title="Tisztelt Érdeklődő!<br/><br/>A programajánló megtekintéséhez regisztráció és bejelentkezés szükséges. Kérem, kattintson a regisztráció, vagy a bejelentkezés gombra."
                                                            href="#">Programajánló</a></nav>
        </div>
    </div>
    <div class="flexbox-container top-padding-10">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right">
            <!--<img src="images/fakevid.png" height=400 style="display: block;margin:0 auto;">-->
            <video width="560" height="400" controls style="display: block;margin:0 auto;">
                <source src="video/vid_mp4.mp4" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>
        </div>
    </div>
    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right" style="height:40px;"></div>
    </div>

<?php
include 'includes/footer.php';
?>