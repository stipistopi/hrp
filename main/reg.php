<?php
$active = "reg";
$color = "magenta";
include 'includes/header.php';
?>

    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="js/reg.js"></script>

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
            <div class="kartya_ok" style="display:none;">
                <h1>Kártya azonosítva!</h1>
                <h2>A rendszer sikeresen azonosította kártyaszámát</h2>
            </div>
            <div class="kartya_nem_ok" style="display:none;">
                <h1>Kártya azonosítása sikertelen!</h1>
                <h2>Vagy nincs ilyen kártya, vagy nem aktiválták még</h2>
            </div>
            <div class="reg_ok" style="display:none;">
                <h1>Sikeres regisztráció!</h1>
                <h2>E-mail elküldve; beléphet a rendszerbe</h2>
            </div>
            <div class="username_in_use" style="display:none;">
                <h1>Sikertelen regisztráció!</h1>
                <h2>Ezzel a felhasználónévvel már regisztráltak</h2>
            </div>
            <div class="card_in_use" style="display:none;">
                <h1>Sikertelen regisztráció!</h1>
                <h2>Ezzel a kártyaszámmal már regisztráltak</h2>
            </div>
            <div class="email_in_use" style="display:none;">
                <h1>Sikertelen regisztráció!</h1>
                <h2>Ezzel az e-mail címmel már regisztráltak</h2>
            </div>
            <form id="form-main-reg" style="margin-left: 5em;" onsubmit="return false;">
                <fieldset>
                    <legend>Regisztráció adatai</legend>
                    <table class="reg_kartya">
                        <tr>
                            <td>Plasztik kártya száma:</td>
                            <td><input id="kartya" type="text" maxlength="10" pattern="[0-9]{1,10}"
                                       placeholder="Kezdjen el gépelni..." required autofocus>
                            </td>
                        </tr>
                    </table>
                    <table class="reg" style="display: none;">
                        <tr>
                            <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Név</td>
                        </tr>
                        <tr>
                            <td>Vezetéknév<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td><input id="vez_nev" type="text" maxlength="25"
                                       pattern="^[A-ZÖÜÓŐÚÉÁŰÍ]{1}[a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\.\- ]{1,24}"
                                       placeholder="Példa" required></td>
                        </tr>
                        <tr>
                            <td>Keresztnév<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td><input id="k_nev" type="text" maxlength="25"
                                       pattern="^[A-ZÖÜÓŐÚÉÁŰÍ]{1}[a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\.\- ]{1,24}"
                                       placeholder="Tamás" required></td>
                        </tr>
                        <tr>
                            <td>Előnév:</td>
                            <td><input id="e_nev" type="text" maxlength="20"
                                       pattern="^[A-ZÖÜÓŐÚÉÁŰÍ]{1}[\.\-a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\s]{1,19}"
                                       placeholder="Ifj."></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Elérhetőségek
                            </td>
                        </tr>
                        <tr>
                            <td>E-mail cím<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td><input id="e-mail" type="text" maxlength="50"
                                       pattern="^[a-z0-9\.\-\_]{1,35}(\@)[a-z0-9\.\-\_]{1,20}(\.)[a-z0-9]{1,10}$"
                                       placeholder="valami@valami.hu" required></td>
                        </tr>
                        <tr>
                            <td>Telefonszám:</td>
                            <td><input id="t_szam" type="text" maxlength="16"
                                       pattern="^(\+?[0-9]{1,3})([\/\-]?[0-9]{1,4}){1,3}" placeholder="30/123-4567">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Cég adatai</td>
                        </tr>
                        <tr>
                            <td>Vállalat/intézmény neve<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td><input id="vall_neve" type="text" maxlength="40" pattern="[^\x22\x27\{\}\[\]\(\)]{3,40}"
                                       placeholder="Minta Bt." required></td>
                        </tr>
                        <tr>
                            <td>Vállalat/intézmény telephelye:</td>
                            <td><select id="vall_thely"></select></td>
                            <!-- AZ ADMIN FELÜLETBE ÁTVENNI:
                            <input id="vall_thely" type="text" maxlength="50"
                                       pattern="[^\x22\x27\{\}\[\]\(\)]{3,50}"
                                       placeholder="1111, Budapest, Ötletes u. 4.">
                            -->
                        </tr>
                        <tr>
                            <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Lakhely</td>
                        </tr>
                        <tr>
                            <td>Lakóhely (város)<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td><input id="lakhely_varos" type="text" maxlength="50"
                                       pattern="[0-9a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\.\,\- ]{3,50}"
                                       placeholder="Szeged" required></td>
                        </tr>
                        <tr>
                            <td>Lakóhely (kerület/városrész):</td>
                            <td><input id="lakhely_vresz" type="text" maxlength="50"
                                       pattern="[0-9a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\.\,\- ]{3,50}"
                                       placeholder="Makkosháza"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Válasszon saját felhasználónevet!</td>
                        </tr>
                        <tr>
                            <td>Felhasználónév<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td><input id="user_n" type="text" maxlength="20" pattern="^[^0-9][a-zA-Z0-9\.\-\_]{1,19}"
                                       placeholder="peldatomi" required></td>
                        </tr>
                        <tr>
                            <td>Jelszó<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td><input id="passw" type="password" maxlength="20" pattern="[^\x22\x27\{\}\[\]\(\)]{6,20}"
                                       placeholder="jelszó" required></td>
                        </tr>
                        <tr>
                            <td>Jelszó megerősítése<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td><input id="passw_re" type="password" maxlength="20"
                                       pattern="[^\x22\x27\{\}\[\]\(\)]{6,20}" placeholder="jelszó" required></td>
                        </tr>
                        <tr>
                            <td><a style="font-style: italic;" href="docs/adatk.pdf" target="_blank">Adatkezelési szabályzat</a> elfogadása<span style="color: red;font-weight: bold;">*</span>:
                            </td>
                            <td><input id="adatk" type="checkbox" required></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><input type="submit" value="Regisztráció"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-size: 80%">A <span
                                    style="color: red;font-weight: bold;">*</span>-al jelölt mezők kitöltése kötelező.
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </form>
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
        <div id="uresresz" class="content-right" style="padding: 180px 0;"></div>
    </div>

<?php
include 'includes/footer.php';
?>