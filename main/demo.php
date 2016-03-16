<?php
$active = "demo";
include 'includes/header.php';
?>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.blockUI.js"></script>
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

            $.ajax({
                url: "demo_reg.php",
                type: "POST",
                data: {
                    feladat: "session"
                },
                success: function(session) {
                    if(session == "session_ok") {
                        $("#also_resz").hide();
                        $("#demo_login").hide();
                        $("#lecke_vid").show();
                    } else if(session == "session_fail") {
                        $("#lecke_vid").hide();
                        $("#also_resz").show();
                        $("#demo_login").show();
                    }
                }
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
        <div class="content-right" id="demo_vid_link">
            <nav class="cl-effect-21 cl-effect-21-green"><a class="popup-trigger"
                                                            title="Tisztelt Érdeklődő!<br/><br/>Kérjük, tekintse meg a programajánló videónkat, melyet ez alatt a szöveg alatt láthat!"
                                                            href="#demo_vid_link">Programajánló</a></nav>
        </div>
    </div>
    <div class="flexbox-container top-padding-10">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right" style="padding: 20px 0;">
            <video id="vid" width="560" height="400" controls style="display: block;margin:0 auto;">
                <source src="video/vid_mp4.mp4" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>
        </div>
    </div>
    <div class="flexbox-container bottom-padding-10">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right" style="height:0px;"></div>
    </div>
    <div class="flexbox-container vertical-padding-10">
        <div class="content-left">
            <div class="circle-green"></div>
        </div>
        <div class="content-right">
            <nav class="cl-effect-21 cl-effect-21-green"><a id="lecke_vid_link" class="popup-trigger"
                                                            title="Tisztelt Érdeklődő!<br/><br/>A demó megtekintéséhez egy rövid (és ingyenes) regisztráció szükséges. Kérem, kattintson az alsó linkre az űrlap megjelenítéséhez!"
                                                            href="#lecke_vid_link">Demó</a></nav>
        </div>
    </div>
    <div class="flexbox-container top-padding-10">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right" style="padding: 20px 0;">
            <div class="erd_reg_ok" style="display:none;">
                <h1>E-mail elküldve!</h1>
                <h2>Kódját elküldtük a megadott címre</h2>
            </div>
            <div class="erd_reg_nem_ok" style="display:none;">
                <h1>Hiba!</h1>
                <h2>Ezzel az e-mail címmel már igényeltek kódot</h2>
            </div>
            <div class="kod_ok" style="display:none;">
                <h1>Kód elfogadva!</h1>
                <h2>Videó betöltése...</h2>
            </div>
            <div class="kod_nem_ok" style="display:none;">
                <h1>Hiba!</h1>
                <h2>Nem találtam ilyen kódot</h2>
            </div>
            <!-- lecke video helye -->
            <div id="lecke_vid" style="display:none;">
                <h2>Szíves türelmét kérjük, a videón még dolgozunk, de regisztrációja és kódja érvényes marad a későbbiekben is.</h2>
            </div>
            <!-- ----------------- -->
            <form id="demo_login" style="margin-left: 3em;">
                <fieldset>
                    <legend>Kód megadása</legend>
                    <table class="demo_kod">
                        <tr>
                            <td>A regisztráció után kapott kód:</td>
                            <td><input id="kod" type="text" maxlength="10" pattern="[a-zA-Z0-9]{1,10}" placeholder="Kezdjen el gépelni..." required autofocus>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </form>
            <form id="demo_reg" style="margin-left: 5em;display: none;" onsubmit="return false;">
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
                            <td>Kérek hírlevelet az újdonságokról:
                            </td>
                            <td><input id="hirlevel" type="checkbox" checked></td>
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
                            <td colspan="2" style="font-size: 80%">A <span style="color: red;font-weight: bold;">*</span>-al jelölt mezők kitöltése kötelező.</td>
                        </tr>
                    </table>
                </fieldset>
            </form>
        </div>
    </div>
    <div id="also_resz" class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right" style="padding: 10px 0;">
            <div id="also_link" style="margin-left: 3em;font-style: italic;cursor:pointer;">Kód igénylése (gyors és ingyenes) ide kattintva</div>
        </div>
    </div>
    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div id="uresresz" class="content-right" style="padding: 40px 0;"></div>
    </div>

<?php
include 'includes/footer.php';
?>