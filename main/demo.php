<?php
$active = "demo";
include 'includes/header.php';
?>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/erd_reg.js"></script>
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
                                                            title="Tisztelt Érdeklődő!<br/><br/>A programajánló megtekintéséhez egy rövid (és ingyenes) regisztráció szükséges. Kérem, kattintson ide az űrlap megjelenítéséhez!"
                                                            href="#">Programajánló</a></nav>
        </div>
    </div>
    <div class="flexbox-container top-padding-10">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right" style="padding: 20px 0;">
            <!--<img src="images/fakevid.png" height=400 style="display: block;margin:0 auto;">-->
            <video id="vid" width="560" height="400" controls style="display: none;margin:0 auto;">
                <source src="video/vid_mp4.mp4" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>
            <form id="demo_login" style="margin-left: 3em;">
                <fieldset>
                    <legend>Kód megadása</legend>
                    <table class="demo_kod">
                        <tr>
                            <td>A regisztráció után kapott kód:</td>
                            <td><input id="kod" type="text" placeholder="Kezdjen el gépelni..." required autofocus>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </form>
            <form id="demo_reg" style="margin-left: 5em;display: none;">
                <fieldset>
                    <legend>Érdeklődő regisztráció</legend>
                    <table class="erdeklodo_reg">
                        <tr>
                            <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Név</td>
                        </tr>
                        <tr>
                            <td>Vezetéknév<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td><input id="vez_nev" type="text" maxlength="25"
                                       pattern="^[A-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ]{1}[a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\.\- ]{1,24}"
                                       placeholder="Példa" required></td>
                        </tr>
                        <tr>
                            <td>Keresztnév<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td><input id="k_nev" type="text" maxlength="25"
                                       pattern="^[A-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ]{1}[a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\.\- ]{1,24}"
                                       placeholder="Tamás" required></td>
                        </tr>
                        <tr>
                            <td>Előnév:</td>
                            <td><input id="e_nev" type="text" maxlength="20"
                                       pattern="^[A-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ]{1}[\.\-a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\s]{1,19}"
                                       placeholder="Ifj."></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" style="background-color: rgba(1, 1, 1, 0.2)">Elérhetőségek</td>
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
                            <td>Adatkezelési szabályzat elfogadása<span style="color: red;font-weight: bold;">*</span>:
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
            <div class="line-green"></div>
        </div>
        <div id="uresresz" class="content-right" style="padding: 10px 0;">
            <div style="margin-left: 3em;font-style: italic;">Kód igénylése</div>
        </div>
    </div>
    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div id="uresresz" class="content-right" style="padding: 140px 0;"></div>
    </div>

<?php
include 'includes/footer.php';
?>