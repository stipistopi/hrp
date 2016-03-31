<?php
$color = "green";
include 'includes/header.php';
?>

    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="js/eleskamra.js"></script>

    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right"><h2>Éléskamra Program</h2></div>
    </div>
    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right"><h4>(Tiszta élelmiszerek)</h4></div>
    </div>
    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right"><p>Részese lenne-e egy olyan közösségnek, akik tudatosan figyelnek táplálkozásukra, az elfogyasztott táplálékok minőségére? Akik úgy segítenek magukon, hogy közben jót tesznek másokkal is?</p></div>
    </div>
    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right"><p>Az ÉLÉSKAMRA PROGRAM célja a „tiszta”, lehetőleg adalékanyagoktól mentes, hagyományos eljárással készült élelmiszerek felkutatása, valamint a hazai és kiemelten a helyi gazdaságok, kis élelmiszer feldolgozók, valamint a közösség tagjainak összekapcsolása.  Ennek eredményeképp válhat a hagyományos táplálékok napi szintű fogyasztása, egyben a helyi termelés és gazdálkodás ösztönzőjévé.</p></div>
    </div>
    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right"><p>Csatlakozzon stratégiai partnerünk törekvéséhez és közösségéhez!</p></div>
    </div>
    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right"><p style="font-style: italic;margin:auto;padding: 20px 0;">Dr. Csoki Orvos Egyesület</p></div>
    </div>
    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right content-right-center">
            <div class="contact_ok" style="display:none;">
                <h1>E-mail elküldve</h1>
                <h2>Köszönjük! Hamarosan visszajelzünk</h2>
            </div>
            <div class="contact_uj" style="display:none;">
                <h1>Hiba!</h1>
                <h2>Az e-mailt már elküldtük</h2>
            </div>
            <p><button type="button" id="eleskamra_mail">Érdekel a törekvés, szívesen hallanék róla több információt!</button></p>
            <fieldset id="eleskamra_fieldset" style="display: none;width: 70%;">
                <legend align="center">E-mail küldése</legend>
                <form id="eleskamra_form" onsubmit="return false;">
                    <table width="100%">
                        <tr>
                            <td width="50%">Nevem<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td width="50%" align="center">
                                <input id="elk_nev" type="text" maxlength="50" pattern="^[A-ZÖÜÓŐÚÉÁŰÍ]{1}[a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\.\- ]{1,50}"
                                       placeholder="Példa Tamás" required>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">E-mail címem<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td width="50%" align="center">
                                <input id="elk_email" type="text" maxlength="50" pattern="^[a-z0-9\.\-\_]{1,35}(\@)[a-z0-9\.\-\_]{1,20}(\.)[a-z0-9]{1,10}$"
                                       placeholder="valami@valami.hu" required>
                            </td>
                        <tr>
                            <td width="50%">Lakóhelyem (város/kerület)<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td width="50%" align="center">
                                <input id="elk_lakhely" type="text" maxlength="40" pattern="[0-9a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\.\,\- ]{3,50}"
                                       placeholder="1111 Budapest, Ötletes u. 4." required>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><input type="submit" value="Küldés"></td>
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