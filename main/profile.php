<?php
$active = "profile";
$color = "magenta";

include_once 'includes/config.php';

//session_start();

if(!isset($_SESSION["is_auth"])) {
    header('location: login.php?msg=1');
    exit;
}

$userId = $_SESSION['userId'];
$timeWindowName = $_SESSION['timeWindowName'];

$ret = db_getUserDataRaw($userId, null, null, null);
$userLastName = $ret['vez_nev'];
$userFirstName = $ret['ker_nev'];
$userElonev = $ret['elonev'];
$userEmail = $ret['email'];
$telefon = $ret['telefon'];

$comp = db_getCompanyDataForUser($userId, null, null, null);
$vallNev = $comp['nev'];
$thely = $comp['thely'];

$varos = $ret['lakhely_varos'];
$varosresz = $ret['lakhely_varosresz'];
$userCard = $ret['kartyaId'];
$userName = $ret['felh_nev'];

$msgColor = "darkred";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['user-submit'])) {
        if(!empty($_POST['e-mail']) && !empty($_POST['lakhely_varos']) && !empty($_POST['user_n']) && !empty($_POST['passw'])) {
            $userEmail_uj = test_input($_POST['e-mail']);
            $varos_uj = test_input($_POST['lakhely_varos']);
            $userName_uj = test_input($_POST['user_n']);
            $passw_regi = test_input($_POST['passw']);

            $validate = array("email"=>true, "varos"=>true, "fnev"=>true, "passw_regi"=>true,
                "telefon"=>true, "vresz"=>true, "passw"=>true, "passw_re"=>true);

            $validate['email'] = preg_match("/^[a-z0-9\\.\\-\\_]{1,35}(\\@)[a-z0-9\\.\\-\\_]{1,20}(\\.)[a-z0-9]{1,10}$/", $userEmail_uj);
            $validate['varos'] = preg_match("/[0-9a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\\.\\,\\- ]{3,50}$/", $varos_uj);
            $validate['fnev'] = preg_match("/^[^0-9][a-zA-Z0-9\\.\\-\\_]{1,19}$/", $userName_uj);
            $validate['passw_regi'] = preg_match("/[^\"'\\{\\}\\[\\]\\(\\)]{6,20}$/", $passw_regi);

            if(!empty($_POST['t_szam'])) {
                $telefon_uj = test_input($_POST['t_szam']);
                $validate['telefon'] = preg_match("/^(\\+?[0-9]{1,3})([\\/\\-]?[0-9]{1,4}){1,3}$/", $telefon_uj);
            } else {
                $telefon_uj = null;
            }

            if(!empty($_POST['lakhely_vresz'])) {
                $varosresz_uj = test_input($_POST['lakhely_vresz']);
                $validate['vresz'] = preg_match("/[0-9a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\\.\\,\\- ]{3,50}$/", $varosresz_uj);
            } else {
                $varosresz_uj = null;
            }

            if(!empty($_POST['new_passw'])) {
                $passw_uj = test_input($_POST['new_passw']);
                $validate['passw'] = preg_match("/[^\"'\\{\\}\\[\\]\\(\\)]{6,20}$/", $passw_uj);
            } else {
                $passw_uj = null;
            }

            if(!empty($_POST['new_passw_re'])) {
                $passw_uj_re = test_input($_POST['new_passw_re']);
                $validate['passw_re'] = preg_match("/[^\"'\\{\\}\\[\\]\\(\\)]{6,20}$/", $passw_uj_re);
            } else {
                $passw_uj_re = null;
            }

            if($userEmail != $userEmail_uj || $varos != $varos_uj || $userName != $userName_uj ||
                $telefon != $telefon_uj || $varosresz != $varosresz_uj || isset($passw_uj)) {
                $valtozas = true;
            } else {
                $valtozas = false;
            }

            $hash = db_getUserHash($userId, null, null, null);

            if($hash && !in_array(false, $validate) && $valtozas) {
                if(password_verify($passw_regi, $hash)) {
                    $username_ok = true;

                    if($userName_uj != $userName) {
                        if(db_getUserId($userName_uj, null, null) !== FALSE) $username_ok = false;
                    }

                    if($username_ok) {
                        if(isset($passw_uj)) {
                            if($passw_uj == $passw_uj_re) {
                                $hash = password_hash($passw_uj, PASSWORD_BCRYPT, ['cost' => 10]);
                            } else {
                                $msg = "Új jelszó és Új jelszó ismét mezők nem egyeznek!";
                            }
                        }

                        if(!isset($msg)) {
                            if(db_updateUser($userId, $userEmail_uj, $userName_uj, $hash, $telefon_uj, $varos_uj, $varosresz_uj)) {
                                $msgColor = "darkgreen";
                                $msg = "Adatok sikeresen módosítva!";
                            } else {
                                $msg = "Adatbázis hiba! Kérjük, jelentse!";
                            }
                        }
                    } else {
                        $msg = "A kívánt új felhasználónév már foglalt!";
                    }
                } else {
                    $msg = "Hibás a megadott jelenlegi jelszó!";
                }
            } else if(in_array(false, $validate)) {
                $msg = "Hibás formátumú adat! (" . array_search(false, $validate) . " mező)";
            } else if(!$valtozas) {
                $msg = "Nem végzett módosítást az adatokon!";
            }
        } else {
            $msg = "A kötelező mezőket ki kell tölteni!";
        }
    }
}

if(pregMatch_oneNumberFromString($timeWindowName)) {
    $numberOfLecke = pregMatch_oneNumberFromString($timeWindowName);
} else {
    $numberOfLecke = "";
}

include 'includes/header.php';

?>

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right <?php if(!isset($msg)) echo "vertical-padding-10"; ?>"></div>
</div>
<?php
if(isset($msg)) {
    echo "<div class=\"flexbox-container\">
            <div class=\"content-left\">
                <div class=\"line-magenta\"></div>
            </div>
            <div class=\"content-right vertical-padding-10\">
                <div style=\"width:80%;margin: auto;\"><p style=\"background-color:$msgColor;border-radius:16px;text-align: center;padding: 5px 0;font-weight: bold;color: white;\">$msg</p></div>
            </div>
          </div>";
}
?>
<div class="flexbox-container">
    <div class="content-left">
        <div class="line-magenta"></div>
    </div>
    <div class="content-right">
        <fieldset id="main_fieldset" style="margin: auto;width: 80%;">
            <legend align="center">Adataim</legend>
            <div style="padding: 0 20px;">
                <form method="post" action="">
                    <table class="reg" width="100%">
                        <tr>
                            <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Név</td>
                        </tr>
                        <tr>
                            <td>Vezetéknév:</td>
                            <td align="right"><input name="vez_nev" id="vez_nev" type="text" maxlength="25"
                                       pattern="^[A-ZÖÜÓŐÚÉÁŰÍ]{1}[a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\.\- ]{1,24}"
                                       value="<?php echo $userLastName; ?>" required disabled></td>
                        </tr>
                        <tr>
                            <td>Keresztnév:</td>
                            <td align="right"><input name="k_nev" id="k_nev" type="text" maxlength="25"
                                       pattern="^[A-ZÖÜÓŐÚÉÁŰÍ]{1}[a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\.\- ]{1,24}"
                                       value="<?php echo $userFirstName; ?>" required disabled></td>
                        </tr>
                        <tr>
                            <td>Előnév:</td>
                            <td align="right"><input name="e_nev" id="e_nev" type="text" maxlength="20"
                                       pattern="^[A-ZÖÜÓŐÚÉÁŰÍ]{1}[\.\-a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\s]{1,19}"
                                       value="<?php if(empty($userElonev)) echo "Nincs adat."; else echo $userElonev; ?>" disabled></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Elérhetőségek
                            </td>
                        </tr>
                        <tr>
                            <td>E-mail cím<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td align="right"><input name="e-mail" id="e-mail" type="text" maxlength="50"
                                       pattern="^[a-z0-9\.\-\_]{1,35}(\@)[a-z0-9\.\-\_]{1,20}(\.)[a-z0-9]{1,10}$"
                                       value="<?php echo $userEmail; ?>" placeholder="valami@valami.hu" required></td>
                        </tr>
                        <tr>
                            <td>Telefonszám:</td>
                            <td align="right"><input name="t_szam" id="t_szam" type="text" maxlength="16"
                                       pattern="^(\+?[0-9]{1,3})([\/\-]?[0-9]{1,4}){1,3}" <?php if(empty($telefon)) echo "placeholder=\"30/123-4567\""; else echo "value=\"" . $telefon . "\""; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Cég adatai</td>
                        </tr>
                        <tr>
                            <td>Cégnév:</td>
                            <td align="right"><input name="vall_neve" id="vall_neve" type="text" maxlength="40" pattern="[^\x22\x27\{\}\[\]\(\)]{3,40}"
                                       value="<?php echo $vallNev; ?>" required disabled></td>
                        </tr>
                        <tr>
                            <td>Telephely:</td>
                            <td align="right"><input name="vall_thely" id="vall_thely" type="text" maxlength="50"
                                                     pattern="[^\x22\x27\{\}\[\]\(\)]{3,50}"
                                                     value="<?php echo $thely; ?>" required disabled></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Lakhely</td>
                        </tr>
                        <tr>
                            <td>Város<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td align="right"><input name="lakhely_varos" id="lakhely_varos" type="text" maxlength="50"
                                       pattern="[0-9a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\.\,\- ]{3,50}"
                                       value="<?php echo $varos; ?>" placeholder="Szeged" required></td>
                        </tr>
                        <tr>
                            <td>Kerület/városrész:</td>
                            <td align="right"><input name="lakhely_vresz" id="lakhely_vresz" type="text" maxlength="50"
                                       pattern="[0-9a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\.\,\- ]{3,50}" placeholder="Makkosháza"
                                    <?php if(empty($varosresz)) echo "placeholder=\"Makkosháza\""; else echo "value=\"" . $varosresz . "\""; ?>></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Felhasználói adatok</td>
                        </tr>
                        <tr>
                            <td>Kártyaszám:</td>
                            <td align="right"><input name="kartya" id="kartya" type="text" value="IP<?php echo $userCard; ?>" required disabled></td>
                        </tr>
                        <tr>
                            <td>Felhasználónév<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td align="right"><input name="user_n" id="user_n" type="text" maxlength="20" pattern="^[^0-9][a-zA-Z0-9\.\-\_]{1,19}"
                                       placeholder="peldatomi" value="<?php echo $userName; ?>" required></td>
                        </tr>
                        <tr>
                            <td>Új jelszó:</td>
                            <td align="right"><input name="new_passw" id="new_passw" type="password" maxlength="20" pattern="[^\x22\x27\{\}\[\]\(\)]{6,20}"
                                       placeholder="jelszó"></td>
                        </tr>
                        <tr>
                            <td>Új jelszó ismét:</td>
                            <td align="right"><input name="new_passw_re" id="new_passw_re" type="password" maxlength="20"
                                       pattern="[^\x22\x27\{\}\[\]\(\)]{6,20}" placeholder="jelszó"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" style="font-weight:bold;color:darkred;border:2px solid darkblue;background-color: rgba(1, 1, 1, 0.2)">A módosításhoz adja meg jelszavát!</td>
                        </tr>
                        <tr>
                            <td>Jelenlegi jelszó<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td align="right"><input name="passw" id="passw" type="password" maxlength="20"
                                                     pattern="[^\x22\x27\{\}\[\]\(\)]{6,20}" placeholder="jelszó" required></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><input type="submit" name="user-submit" id="user-submit" value="Módosít!"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-size: 80%">A <span
                                    style="color: red;font-weight: bold;">*</span>-al jelölt mezők kitöltése kötelező.
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </fieldset>
    </div>
</div>
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
    <div class="content-right" style="height:40px;"></div>
</div>

<?php
include 'includes/footer.php';
?>
