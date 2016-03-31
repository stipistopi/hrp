<?php
$active = "contact";
include 'includes/header.php';
?>

    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="js/contact.js"></script>

    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right"><h2>Kapcsolat</h2></div>
    </div>
    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right"><h4>Egészségtükör Kft.</h4></div>
    </div>
    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right"><p>1111 Budapest, Bartók Béla út 20.</p></div>
    </div>
    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right"><p>Telefon: 06 1 6110 337</p></div>
    </div>
    <div class="flexbox-container">
        <div class="content-left">
            <div class="line-green"></div>
        </div>
        <div class="content-right"><p><button type="button" id="contact_mail">Üzenjen nekünk!</button></p></div>
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
            <fieldset id="contact_fieldset" style="display: none;width: 80%;">
                <legend align="center">Kapcsolatfelvétel</legend>
                <form id="contact_form" onsubmit="return false;">
                    <table width="100%">
                        <tr>
                            <td>Címzett<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td>
                                <select id="contact_select">
                                    <option value="1">Általános ügyfélszolgálat</option>
                                    <option value="2">Vezetőség</option>
                                    <option value="3">Fejlesztők</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Tárgy<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td>
                                <input id="email_targy" type="text" maxlength="40" pattern="[^\x22\x27\{\}\[\]\(\)]{3,40}"
                                       placeholder="A levél tárgya" required>
                            </td>
                        <tr>
                            <td>Üzenet<span style="color: red;font-weight: bold;">*</span>:</td>
                            <td>
                                <textarea id="contact_uzi" rows="4" style="width:100%;resize:vertical;" maxlength="500" placeholder="Üzenet szövege..." required></textarea>
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
        <div class="content-right">
            <p>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5392.819414407009!2d19.049597307926813!3d47.48193139661911!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741dc4d9dafa2ef%3A0x8b999bd4cc9ed197!2zQmFydMOzayBCw6lsYSDDunQgMjAsIEJ1ZGFwZXN0LCAxMTEx!5e0!3m2!1shu!2shu!4v1454379306247"
                    width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </p>
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