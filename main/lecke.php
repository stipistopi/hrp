<?php
$active = "lecke";
$color = "magenta";

include_once 'includes/config.php';

//session_start();

if(!isset($_SESSION["is_auth"])) {
    header('location: login.php?msg=1');
    exit;
}

include 'includes/header.php';

$userId = $_SESSION['userId'];
$timeWindowName = $_SESSION['timeWindowName'];
$userFirstName = $_SESSION['userFirstName'];
$userLastLogin = date("Y.m.d.", strtotime($_SESSION['userLastLogin'])) . " nap " . date("H", strtotime($_SESSION['userLastLogin'])) . " óra " . date("i", strtotime($_SESSION['userLastLogin'])) . " perckor";
$statusInFullProgram = db_getStatusInFullProgram($userId);
$statusInLecke = db_getStatusInLecke($userId, $timeWindowName);

if(pregMatch_oneNumberFromString($timeWindowName)) {
    $numberOfLecke = pregMatch_oneNumberFromString($timeWindowName);
    $vid_title = $numberOfLecke . ". lecke videóanyagának megnyitása. (Ha szünetet tartana, csak állítsa meg, a rendszer megjegyzi, hol tartott.)";
    if($numberOfLecke == 1) $vidId = "rPMh2fETxEg";
    if($numberOfLecke == 2) $vidId = "U6zt9S_dzlE";
} else {
    $numberOfLecke = "";
    $vid_title = "Videó jelenleg nem elérhető.";
}

$randomColor1 = mt_rand(1,4);
do {
    $randomColor2 = mt_rand(1,4);
} while ($randomColor1 == $randomColor2);

if(!empty($_GET['msg'])) {
    $msgColor = "darkred";
    if($_GET['msg'] == 1) {
        $text = "A teszt még (vagy már) nem elérhető.";
    } else if($_GET['msg'] == 2) {
        $text = "Ez a tartalom jelenleg Önnek nem elérhető.";
    } else if($_GET['msg'] == 3) {
        $text = "Sikeres teszt beküldés!";
        $msgColor = "darkgreen";
    } else if($_GET['msg'] == 4) {
        $text = "Adatbázis hiba! Kérjük, jelentse!";
    } else if($_GET['msg'] == 5) {
        $text = "Ez az oldal nem létezik.";
    } else {
        $text = null;
    }
    if(isset($text)) {
        $message = "<div style=\"padding-top: 20px;width:90%;margin: auto;\"><p style=\"background-color:$msgColor;border-radius:16px;text-align: center;padding: 5px 0;font-weight: bold;color: white;\">$text</p></div>";
    }
}
?>

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.blockUI.js"></script>
<script type="text/javascript" src="js/lecke.js"></script>
<link rel="stylesheet" type="text/css" href="css/lecke.css">

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
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right" style="padding-bottom: 1em;">
        <fieldset style="margin: auto;width: 90%;">
            <legend align="center">Ön jelenleg itt tart...</legend>
            <h4>A teljes programban:</h4>
            <div style="padding: .6em 0;" align="center">
                <div id="progress1" class="graph" align="left">
                    <div id="bar1" class="bar prog_color<?php echo $randomColor1; ?>" style="width:0%">
                        <p class="<?php echo $statusInFullProgram; ?>">0% teljesítve</p>
                    </div>
                </div>
            </div>
            <?php
            if(!empty($numberOfLecke)) {
                echo "<h4>A leckében ($numberOfLecke. lecke):</h4>
                        <div style=\"padding: .6em 0;\" align=\"center\">
                            <div id=\"progress2\" class=\"graph\" align=\"left\">
                                <div id=\"bar2\" class=\"bar prog_color". $randomColor2 ."\" style=\"width:0%\">
                                    <p class=\"$statusInLecke\">0% teljesítve</p>
                                </div>
                            </div>
                        </div>";
            }
            ?>
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
            <div <?php if(!empty($numberOfLecke)) echo "id=\"open-modal\" style=\"cursor: pointer;\""; ?> class="lecke-vid-container"
                 title="<?php echo $vid_title; ?>">
                <!-- Eredeti title: "A beépített tartalomra kattintva nézheti meg az előadást, a lecke prezentációját."  -->
                <img src="images/fakevid.png" class="lecke-vid">
                <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
                <div id="player" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>
<?php if(!empty($numberOfLecke)): ?>
<script>
    // 2. This code loads the IFrame Player API code asynchronously.
    var tag = document.createElement('script');

    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // 3. This function creates an <iframe> (and YouTube player)
    //    after the API code downloads.
    var player;
    function onYouTubeIframeAPIReady() {
        $("#open-modal").click(function() {
            player = new YT.Player('player', {
                height: playerHeight,
                width: playerWidth,
                videoId: '<?php echo $vidId; ?>',
                playerVars: {
                    <?php
                    if(!empty($_COOKIE['vid_state_in_secs'])) {
                        list($lecke, $secs) = explode(':', $_COOKIE['vid_state_in_secs']);
                        if($lecke == $numberOfLecke) echo "'start': " . $secs . ",";
                    }
                    ?>
                    'rel': 0,
                    'showinfo': 0,
                    'modestbranding': 1
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });

            $("iframe#player").attr("title", "");
        });
    }

    // 4. The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        // do whatever you want here
        //event.target.playVideo();
    }

    // 5. The API calls this function when the player's state changes.
    //    The function indicates that when playing a video (state=1),
    //    the player should play for six seconds and then stop.
    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PAUSED) {
            $.ajax({
                url: "ajax/save_vid_state.php",
                type: "POST",
                data: {
                    vidMp: Math.round(player.getCurrentTime())
                }
            });
        }
    }

    function stopVideo() {
        player.stopVideo();
    }
</script>
<?php endif ?>
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right vertical-padding-10" style="padding: 20px 0;"><p style="font-style: italic;">Legutóbb ekkor járt itt: <?php echo $userLastLogin; ?>.</p></div>
</div>

<?php
include 'includes/footer.php';
?>

