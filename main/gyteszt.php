<?php
$color = "green";
include 'includes/header.php';
include 'includes/configHRP.php';
?>

    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="js/gyteszt.js"></script>

    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right vertical-padding-10"></div>
    </div>
    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right">
            <div class="gyteszt_ok" style="display:none;">
                <h1>E-mail elküldve!</h1>
                <h2>Kiértékelt tesztjét e-mailben elküldtük</h2>
            </div>
            <div class="gyteszt_nem_ok" style="display:none;">
                <h1>Küldés sikertelen!</h1>
                <h2>Kérjük, minden választ adjon meg!</h2>
            </div>
            <div class="gyteszt_uj" style="display:none;">
                <h1>Hiba!</h1>
                <h2>Már kiértékeltük a tesztjét</h2>
            </div>
            <fieldset id="main_fieldset">
                <legend id="curr_state" align="center">Gyorsteszt (1/4)</legend>
                    <form id="form-gyteszt" onsubmit="return false;">
                        <?php
                        for($kerdes_i=1; $kerdes_i<=4; $kerdes_i++) {
                            if($kerdes_i != 1) echo "<fieldset id='f$kerdes_i' style='display: none'>"; else echo "<fieldset id='f$kerdes_i'>";
                            if($kerdes_i == 1) echo "<legend id='leg1'>JÖVŐKÉP, LEGFONTOSABB FELADATOK</legend>";
                            if($kerdes_i == 2) echo "<legend id='leg2'>DOLGOZÓI EGYÜTTMŰKÖDÉSI PROFIL</legend>";
                            if($kerdes_i == 3) echo "<legend id='leg3'>A DOLGOZÓK ALAPÁLLAPOTA, RENDELKEZÉSRE ÁLLÁSA</legend>";
                            if($kerdes_i == 4) echo "<legend id='leg4'>PÉNZÜGYI ÉS PIACI EREDMÉNYESSÉG</legend>";
                            $stmt = $conn->prepare("SELECT kerdes FROM kerdes WHERE id=?");
                            $stmt->execute(array($kerdes_i));
                            $row = $stmt->fetchColumn();
                            echo $row;
                            $stmt = $conn->prepare("SELECT val_lehetoseg FROM valasz WHERE kerdesId=?");
                            $stmt->execute(array($kerdes_i));
                            for($valasz_i = 1; $valasz_i <= 5; $valasz_i++) {
                                $row = $stmt->fetchColumn();
                                echo "<h4>" . $row . "</h4>";
                                for($gomb_i = 1; $gomb_i <= 5; $gomb_i++) {
                                    if($kerdes_i == 1) $gomb_val = $gomb_i; else $gomb_val = 6 - $gomb_i;
                                    if($gomb_i == 1) echo "<ul id='gy_g$kerdes_i' class=\"gyteszt_gombok\">";
                                    echo "<li><input type=\"radio\" id=\"v".$kerdes_i."_".$valasz_i."_".$gomb_i."\" name=\"csop".$kerdes_i."_".$valasz_i."\" value=\"$gomb_val\" required />";
                                    echo "<label for=\"v".$kerdes_i."_".$valasz_i."_".$gomb_i."\">$gomb_i</label>";
                                    if($gomb_i == 5) echo "</li></ul>"; else echo "</li>";
                                }
                                if($valasz_i != 5) echo "<hr>";
                            }
                            echo "</fieldset>";
                            //if($kerdes_i != 4) echo "<div style=\"height:20px;\"></div>";
                        }
                        ?>
                        <table class="gyteszt_nav" width="100%">
                            <tr>
                                <td align="center"><button type="button" id="prev" disabled>Vissza</button></td>
                                <td align="center"><button type="button" id="next">Tovább</button></td>
                            </tr>
                        </table>
                        <table class="gyteszt_alja" width="100%" style="display: none;">
                            <tr>
                                <td class="gyta_elso">E-mail cím<span style="color: red;font-weight: bold;">*</span>:</td>
                                <td class="gyta_elso"><input id="e-mail" type="text" maxlength="50"
                                           pattern="^[a-z0-9\.\-\_]{1,35}(\@)[a-z0-9\.\-\_]{1,20}(\.)[a-z0-9]{1,10}$"
                                           placeholder="valami@valami.hu" required></td>
                            </tr>
                            <tr>
                                <td>Adatkezelési szabályzat elfogadása<span style="color: red;font-weight: bold;">*</span>:</td>
                                <td><input id="adatk" type="checkbox" required></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center"><input type="submit" value="Kiértékelés"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 80%">A <span
                                        style="color: red;font-weight: bold;">*</span>-al jelölt mezők kitöltése kötelező.
                                </td>
                            </tr>
                        </table>
                    </form>
            </fieldset>
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