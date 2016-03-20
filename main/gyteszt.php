<?php
$active = "reg";
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
            <div class="kartya_ok" style="display:none;">
                <h1>Kártya azonosítva!</h1>
                <h2>A rendszer sikeresen azonosította kártyaszámát</h2>
            </div>
            <fieldset>
                <legend align="center">Gyorsteszt</legend>
                    <form id="form-gyteszt" onsubmit="return false;">
                        <?php
                        for($kerdes_i=1; $kerdes_i<=4; $kerdes_i++) {
                            echo "<fieldset>";
                            if($kerdes_i == 1) echo "<legend>JÖVŐKÉP, LEGFONTOSABB FELADATOK</legend>";
                            if($kerdes_i == 2) echo "<legend>DOLGOZÓI EGYÜTTMŰKÖDÉSI PROFIL</legend>";
                            if($kerdes_i == 3) echo "<legend>A DOLGOZÓK ALAPÁLLAPOTA, RENDELKEZÉSRE ÁLLÁSA</legend>";
                            if($kerdes_i == 4) echo "<legend>PÉNZÜGYI ÉS PIACI EREDMÉNYESSÉG</legend>";
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
                                    if($gomb_i == 1) echo "<ul id='gy_g$kerdes_i' class=\"gyteszt_gombok\">";
                                    echo "<li><input type=\"radio\" id=\"v".$kerdes_i."_".$valasz_i."_".$gomb_i."\" name=\"csop".$kerdes_i."_".$valasz_i."\" value=\"$gomb_i\" required />";
                                    echo "<label for=\"v".$kerdes_i."_".$valasz_i."_".$gomb_i."\">$gomb_i</label>";
                                    if($gomb_i == 5) echo "</li></ul>"; else echo "</li>";
                                }
                                if($valasz_i != 5) echo "<hr>";
                            }
                            echo "</fieldset>";
                            if($kerdes_i != 4) echo "<div style=\"height:40px;\"></div>";
                        }
                        ?>
                        <table class="gyteszt_alja" width="100%">
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