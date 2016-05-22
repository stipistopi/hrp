<?php
$active = "results";
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

if(pregMatch_oneNumberFromString($timeWindowName)) {
    $numberOfLecke = pregMatch_oneNumberFromString($timeWindowName);
} else {
    $numberOfLecke = db_getNumberOfAllLecke();
}

if(isset($_GET['test']) && $_GET['test'] != "pkezdo") {
    if(!db_checkIfTimeWindowGreaterThanPkezdo($timeWindowName)) {
        header('location: lecke.php?msg=2');
        exit;
    }
}

if(isset($_GET['lecke']) && ($_GET['lecke'] <= 0 || $_GET['lecke'] > $numberOfLecke)) {
    header('location: lecke.php?msg=5');
    exit;
}

include 'includes/header.php';

?>

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        var fontSize = parseInt($(".gyteszt_gombok li").height())+"px";
        var oszlop1 = $(".graph-container > li:nth-child(1) .bar-inner");
        var oszlop2 = $(".graph-container > li:nth-child(2) .bar-inner");
        var oszlop3 = $(".graph-container > li:nth-child(3) .bar-inner");
        var oszlop_szov1 = $(".graph-container > li:nth-child(1) .bar-inner-text");
        var oszlop_szov2 = $(".graph-container > li:nth-child(2) .bar-inner-text");
        var oszlop_szov3 = $(".graph-container > li:nth-child(3) .bar-inner-text");
        var dur = 800;

        $(".gyteszt_gombok li label").css('font-size', fontSize);

        <?php
        if($_GET['test'] != "pkezdo") {
            for($lecke = 1; $lecke <= $numberOfLecke; $lecke++) {
                if($_GET['test'] == "lkezdo") {
                    $graphData = db_getGraphDataForLeckeStartTest($userId, $lecke);
                } else if($_GET['test'] == "kf") {
                    $graphData = db_getGraphDataForLeckeKerdezzTest($lecke);
                }

                if(isset($_GET['lecke'])) {
                    if($lecke == $_GET['lecke']) {
                        for($init = 1; $init <= 3; $init++) {
                            echo "oszlop$init.css({\"height\": \"" . $graphData[$init - 1] . "%\", \"bottom\": \"0\"});";
                            echo "oszlop_szov$init.css({\"height\": \"" . $graphData[$init - 1] . "%\", \"bottom\": \"0\"});";
                            echo "oszlop_szov$init.attr(\"data-height\", \"" . $graphData[$init - 1] . "\");";
                        }
                    }
                } else {
                    if($lecke == 1) {
                        for($init = 1; $init <= 3; $init++) {
                            echo "oszlop$init.css({\"height\": \"" . $graphData[$init - 1] . "%\", \"bottom\": \"0\"});";
                            echo "oszlop_szov$init.css({\"height\": \"" . $graphData[$init - 1] . "%\", \"bottom\": \"0\"});";
                            echo "oszlop_szov$init.attr(\"data-height\", \"" . $graphData[$init - 1] . "\");";
                        }
                    }
                }

                echo "$(\"#gomb$lecke\").click(function() {";

                for($i = 1; $i <= 3; $i++) {
                    echo "oszlop$i.css({\"height\": \"" . $graphData[$i - 1] . "%\", \"bottom\": \"0\"});";
                    echo "oszlop_szov$i.css({\"height\": \"" . $graphData[$i - 1] . "%\", \"bottom\": \"0\"});";
                    echo "$({szam:oszlop_szov$i.attr('data-height')}).animate({szam:" . $graphData[$i - 1] . "},{duration:dur,step: function(now){oszlop_szov$i.attr('data-height', Math.round(now));}});";
                }

                echo "});";
            }
        }
        ?>

    });
</script>
<link rel="stylesheet" type="text/css" href="css/graph.css" />

<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right"></div>
</div>
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <?php
    $result = "Eredményeim (grafikonok)";
    if(isset($_GET['test'])) {
        if($_GET['test'] == "pkezdo") $result .= " - Programkezdő teszt";
        if($_GET['test'] == "lkezdo") $result .= " - Leckekezdő teszt";
        if($_GET['test'] == "kf") $result .= " - Kérdezz-felelek teszt";
    }
    echo "<div class=\"content-right\"><h2>$result</h2></div>";
    ?>
</div>
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right">
        <?php if(!isset($_GET['test'])): ?>
        <div id="graph_list" style="display: block;margin-left: 7em;">
            <h3 class="graph_item"><a class="also_link" href="?test=pkezdo">Programkezdő teszt</a></h3>
            <h3 class="graph_item"><a class="also_link" href="?test=lkezdo">Leckekezdő teszt</a></h3>
            <h3 class="graph_item"><a class="also_link" href="?test=kf">Kérdezz-felelek teszt</a></h3>
        </div>
        <?php else: ?>
        <section class="main">

            <?php
            if($_GET['test'] != "pkezdo") {
                echo "<h3 style=\"text-align: left;margin-top: 0;\">Válasszon leckét!</h3>";
                $randomColor = mt_rand(1, 4);
                echo "<ul id=\"gy_g" . $randomColor . "\" class=\"gyteszt_gombok\">";
                for($i = 1; $i <= $numberOfLecke; $i++) {
                    echo "<li><input type=\"radio\" id=\"gomb$i\" name=\"gomb_csop\"";
                    if(isset($_GET['lecke'])) {
                        if($i == $_GET['lecke']) {
                            if($i == $_GET['lecke']) echo " checked=\"checked\" />"; else echo " />";
                        }
                    } else {
                        if($i == 1) echo " checked=\"checked\" />"; else echo " />";
                    }
                    echo "<label for=\"gomb$i\">$i</label></li>";
                }
                echo "</ul>";
                if($_GET['test'] == "lkezdo") {
                    echo "<h4 style=\"margin-bottom: 0;font-style: italic;\">Ábra: Adott lecke témájához tartozó kockázati szint</h4>";
                } else if($_GET['test'] == "kf") {
                    echo "<h4 style=\"margin-bottom: 0;font-style: italic;\">Ábra: Az eddig kitöltők átlagos elsajátítási szintje</h4>";
                }
            }
            ?>

            <ul class="graph-container">
                <li>
                    <?php
                    if($_GET['test'] == "lkezdo") {
                        echo "<span style=\"margin-bottom: .7em;\">Egyéni szint</span>";
                    } else if($_GET['test'] == "kf") {
                        echo "<span>Nem megfelelő</span>";
                    }
                    ?>
                    <div class="bar-wrapper">
                        <div class="bar-container">
                            <div class="bar-background"></div>
                            <div class="bar-inner"></div>
                            <div class="bar-inner-text"></div>
                            <div class="bar-foreground"></div>
                        </div>
                    </div>
                </li>
                <li>
                    <?php
                    if($_GET['test'] == "lkezdo") {
                        echo "<span>Elfogadható minimum szint</span>";
                    } else if($_GET['test'] == "kf") {
                        echo "<span>Megfelelő</span>";
                    }
                    ?>
                    <div class="bar-wrapper">
                        <div class="bar-container">
                            <div class="bar-background"></div>
                            <div class="bar-inner"></div>
                            <div class="bar-inner-text"></div>
                            <div class="bar-foreground"></div>
                        </div>
                    </div>
                </li>
                <li>
                    <?php
                    if($_GET['test'] == "lkezdo") {
                        echo "<span>Céges átlag szint</span>";
                    } else if($_GET['test'] == "kf") {
                        echo "<span>Kitűnő</span>";
                    }
                    ?>
                    <div class="bar-wrapper">
                        <div class="bar-container">
                            <div class="bar-background"></div>
                            <div class="bar-inner"></div>
                            <div class="bar-inner-text"></div>
                            <div class="bar-foreground"></div>
                        </div>
                    </div>
                </li>
                <li>
                    <ul class="graph-marker-container">
                        <li style="bottom:25%;"><span>25%</span></li>
                        <li style="bottom:50%;"><span>50%</span></li>
                        <li style="bottom:75%;"><span>75%</span></li>
                        <li style="bottom:100%;"><span>100%</span></li>
                    </ul>
                </li>
            </ul>
        </section>
        <?php endif ?>
    </div>
</div>
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right">
        <?php
        if(isset($_GET['test'])) {
            echo "<p style=\"margin: auto;font-style: italic;\">Megjegyzés: Ha nullákat lát, az azért lehet, mert még nem töltötte ki az adott tesztet.</p>";
        }
        ?>
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
